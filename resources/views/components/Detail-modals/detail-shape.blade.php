<!-- Modal Overlay -->
<div x-show="ShapeDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="ShapeDetailModal = false" style="display: none;"
    x-data="{ 
        zoomImage: false, 
        activeTab: 'info',
        showDebug: false,
        currentImageIndex: 0,
        get currentImage() {
            return this.shapeToView?.images && this.shapeToView.images.length > 0 
                ? this.shapeToView.images[this.currentImageIndex] 
                : null;
        }
    }">
    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-visible h-[90vh] flex flex-col">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 text-white p-6 flex justify-between items-center flex-shrink-0 rounded-t-2xl">
            <div>
                <h2 class="text-2xl font-bold" x-text="shapeToView?.item_code || '{{ __('content.details') }} {{ __('content.shape') }}'"></h2>
                <p class="text-blue-100 dark:text-blue-200 text-sm mt-1" x-text="shapeToView?.item_description_thai || '{{ __('content.details') }} {{ __('content.shape') }}'"></p>
            </div>
            <button @click="ShapeDetailModal = false"
                class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-visible">
            <!-- Image and Information Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6 h-full">
                
                <!-- Image Section -->
                <div class="lg:col-span-1 flex flex-col">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 flex-shrink-0">
                        <div class="relative">
                            <!-- Main Image Display -->
                            <template x-if="shapeToView?.images?.length > 0">
                                <div>
                                    <img :src="`{{ asset('storage') }}/${shapeToView.images[currentImageIndex].file_path}`" 
                                        :alt="shapeToView.images[currentImageIndex].file_name"
                                        class="rounded-lg shadow-lg cursor-zoom-in mx-auto h-64 md:h-80 object-contain w-full"
                                        @click="zoomImage = true">
                                    
                                    <!-- Image Navigation -->
                                    <div class="flex justify-between items-center mt-3">
                                        <button @click="currentImageIndex = (currentImageIndex - 1 + shapeToView.images.length) % shapeToView.images.length"
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                                            <span class="material-symbols-outlined mt-1">arrow_back</span>
                                        </button>
                                        
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            <span x-text="currentImageIndex + 1"></span>/<span x-text="shapeToView.images.length"></span>
                                        </span>
                                        
                                        <button @click="currentImageIndex = (currentImageIndex + 1) % shapeToView.images.length"
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                                            <span class="material-symbols-outlined mt-1">arrow_forward</span>
                                        </button>
                                    </div>
                                    
                                    <!-- Thumbnails -->
                                    <div class="flex gap-1 px-2 py-2 overflow-x-auto pb-2">
                                        <template x-for="(image, index) in shapeToView.images" :key="index">
                                            <img :src="`{{ asset('storage') }}/${image.file_path}`" 
                                                :alt="`Thumbnail ${index + 1}`"
                                                class="h-12 w-12 object-cover rounded cursor-pointer"
                                                :class="currentImageIndex === index ? 'ring-2 ring-blue-500' : ''"
                                                @click="currentImageIndex = index">
                                        </template>
                                    </div>
                                </div>
                            </template>
                            
                            <template x-if="!shapeToView?.images?.length">
                                <div class="bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center h-48">
                                    <div class="text-center text-gray-500 dark:text-gray-400">
                                        <span class="material-symbols-outlined text-6xl mb-2 block">image</span>
                                        <p>{{ __('content.no_images_available') }}</p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <!-- Status & Process Badge -->
                    <div class="my-2 flex justify-center items-center gap-6 border border-gray-200 dark:border-gray-600 rounded-lg p-2">
                        <!-- Status -->
                        <template x-if="shapeToView?.status">
                            <div class="flex flex-col items-center">
                                <label class="text-gray-700 dark:text-gray-300 font-semibold mb-1">{{ __('content.status') }}</label>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                    <span class="w-2 h-2 rounded-full mr-2 bg-yellow-500"></span>
                                    <span x-text="shapeToView.status.status"></span>
                                </span>
                            </div>
                        </template>

                        <!-- Process -->
                        <template x-if="shapeToView?.process">
                            <div class="flex flex-col items-center">
                                <label class="text-gray-700 dark:text-gray-300 font-semibold mb-1">{{ __('content.process') }}</label>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                    <span class="w-2 h-2 rounded-full mr-2 bg-yellow-500"></span>
                                    <span x-text="shapeToView.process.process_name"></span>
                                </span>
                            </div>
                        </template>
                    </div>
                    <!-- Last Updated Info -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 sm:col-span-3">
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                            <span class="material-symbols-outlined mr-2">history</span>
                            {{ __('content.update_information') }}
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">{{ __('content.update_by') }}:</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100 break-words" x-text="shapeToView?.updater?.name || 'System'"></p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">{{ __('content.update_at') }}:</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100" x-text="shapeToView?.updated_at ? new Date(shapeToView.updated_at).toLocaleString('th-TH') : '-'"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Content -->
                <div class="lg:col-span-2 flex flex-col overflow-visible">
                    
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-6 flex-shrink-0">
                        <nav class="flex space-x-8">
                            <button @click="activeTab = 'info'"
                                :class="activeTab === 'info' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">info</span>
                                {{ __('content.information') }}
                            </button>
                            <button @click="activeTab = 'specification'"
                                :class="activeTab === 'specification' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">straighten</span>
                                {{ __('content.specification') }}
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content Container -->
                    <div class="flex-1 min-h-0">
                        <!-- Information Tab -->
                        <div x-show="activeTab === 'info'" class="h-full overflow-y-auto overflow-x-hidden flex flex-col gap-2 font-lg text-lg">
                            
                            <!-- Item Code -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">qr_code_2</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.shape_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.item_code || '-'"></span>
                            </div>
                            
                            <!-- Description (TH) -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">translate</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.description_th') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100 " x-text="shapeToView?.item_description_thai || '-'"></span>
                            </div>
                            
                            <!-- Description (EN) -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">language</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.description_en') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.item_description_eng || '-'"></span>
                            </div>
                            
                            <!-- Collection Code -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-pink-600 dark:text-pink-400">qr_code</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.collection_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.shape_collection?.collection_code || '-'"></span>
                            </div>
                            
                            <!-- Collection Name -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-pink-600 dark:text-pink-400">folder_special</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.collection_name') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.shape_collection?.collection_name || '-'"></span>
                            </div>
                            
                            <!-- Type -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-indigo-600 dark:text-indigo-400">category</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.type') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.shape_type?.name || '-'"></span>
                            </div>
                            
                            <!-- Group -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-teal-600 dark:text-teal-400">workspaces</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.group') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.item_group?.item_group_name || '-'"></span>
                            </div>

                            <!-- Approval Date -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">Order_Approve</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.approval_date') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.approval_date ? new Date(shapeToView.approval_date).toLocaleDateString('th-TH') : '-'"></span>
                            </div>

                            <hr class="mt-3 mb-2 border-gray-300 dark:border-gray-600">
                            
                            <!-- Customer -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">business</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.customer') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.customer?.name || '-'"></span>
                            </div>
                            
                            <!-- Designer -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-orange-600 dark:text-orange-400">palette</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.designer') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.designer?.designer_name || '-'"></span>
                            </div>
                            
                            <!-- Requestor -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-red-600 dark:text-red-400">person_raised_hand</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.requestor') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.requestor?.name || '-'"></span>
                            </div>
                        </div>
                        <!-- Specification Image -->
                        <div x-show="activeTab === 'specification'" class="flex justify-center mb-4 hoverScale150"   style="transform-origin: bottom left;" >
                            <div class="bg-white p-1 py-3 inline-block shadow-sm rounded-lg">
                                <img src="{{ asset('images/speci.png') }}" 
                                    alt="speci" 
                                    class="mx-auto w-auto">
                            </div> 
                        </div>
                        <!-- Specification Tab -->
                        <div x-show="activeTab === 'specification'" class="h-full overflow-y-auto overflow-x-visible flex flex-col gap-1 font-lg text-lg">
                            <!-- Volume -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">water_drop</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.volume') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.volume || '-'"></span>
                                <label class="text-gray-400 dark:text-gray-500">
                                    {{ __('content.cc_full') }}
                                </label>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Weight -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">scale</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.weight') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.weight || '-'"></span>
                                <label class="text-gray-400 dark:text-gray-500">
                                    {{ __('content.g_full') }}
                                </label>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Long Diameter -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">straighten</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.long_diameter') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.long_diameter || '-'"></span>
                                <label class="text-gray-400 dark:text-gray-500">
                                    {{ __('content.mm_full') }}
                                </label>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Short Diameter -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-orange-600 dark:text-orange-400">width</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.short_diameter') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.short_diameter || '-'"></span>
                                <label class="text-gray-400 dark:text-gray-500">
                                    {{ __('content.mm_full') }}
                                </label>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Height Long -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-red-600 dark:text-red-400">height</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.height_long') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.height_long || '-'"></span>
                                <label class="text-gray-400 dark:text-gray-500">
                                    {{ __('content.mm_full') }}
                                </label>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Height Short -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-pink-600 dark:text-pink-400">expand</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.height_short') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.height_short || '-'"></span>
                                <label class="text-gray-400 dark:text-gray-500">
                                    {{ __('content.mm_full') }}
                                </label>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Body -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-teal-600 dark:text-teal-400">width_full</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.body') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.body || '-'"></span>
                                <label class="text-gray-400 dark:text-gray-500">
                                    {{ __('content.mm_full') }}
                                </label>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center border-t border-gray-200 dark:border-gray-600 flex-shrink-0 rounded-b-2xl">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-sm mr-1">schedule</span>
                {{ __('content.created_at') }}: <span x-text="shapeToView?.created_at ? new Date(shapeToView.created_at).toLocaleDateString('th-TH') : '-'"></span>
            </div>
            <button @click="ShapeDetailModal = false"
                class="bg-gray-500 dark:bg-gray-600 hover:bg-blue-600 dark:hover:bg-blue-500 text-white py-2 px-6 rounded-lg transition-all duration-200 hoverScale">
                {{ __('content.close') }}
            </button>
        </div>
    </div>
    <!-- Debug Panel - กดปุ่ม F2 เพื่อเปิด/ปิด -->
    <div x-show="showDebug" 
        class="fixed top-2 right-2 bg-black bg-opacity-90 text-green-400 p-4 rounded text-xs font-mono  flex flex-row"
        @keydown.window.f2.prevent="showDebug = !showDebug">
        <div class="flex justify-between items-center mb-2">
            <button @click="showDebug = false" class="text-white hover:text-red-400">✕</button>
        </div>
        <div class="overflow-auto flex-1" style="max-height: calc(90vh - 40px);">
            <pre x-text="JSON.stringify(shapeToView.images, null, 2)" class="whitespace-pre-wrap"></pre>
        </div>
        <div class="overflow-auto flex-1" style="max-height: calc(90vh - 40px);">
            <pre x-text="JSON.stringify(shapeToView, null, 2)" class="whitespace-pre-wrap"></pre>
        </div>
    </div> 
    <!-- Zoom Image Modal -->
    <div x-show="zoomImage" x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-95 flex items-center justify-center z-60"
        @click.self="zoomImage = false">
        <div class="relative max-h-[95vh] max-w-[95vw]">
            <template x-if="shapeToView?.images?.length > 0">
                <div class="relative">
                    <img :src="`{{ asset('storage') }}/${shapeToView.images[currentImageIndex].file_path}`" 
                        :alt="shapeToView.item_code"
                        class="max-h-[80vh] max-w-[95vw] object-contain rounded-lg shadow-2xl">
                        
                    <!-- Navigation Arrows -->
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex justify-between px-4">
                        <button @click.stop="currentImageIndex = (currentImageIndex - 1 + shapeToView.images.length) % shapeToView.images.length"
                                class="bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-all">
                            <span class="material-symbols-outlined">arrow_back</span>
                        </button>
                        <button @click.stop="currentImageIndex = (currentImageIndex + 1) % shapeToView.images.length"
                                class="bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-all">
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                    
                    <!-- Image Counter -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full">
                        <span x-text="currentImageIndex + 1"></span>/<span x-text="shapeToView.images.length"></span>
                    </div>
                </div>
            </template>
            
            <template x-if="!shapeToView?.images?.length">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-8 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4 block">image</span>
                    <p class="text-gray-600 dark:text-gray-300">{{ __('content.no_images_available') }}</p>
                </div>
            </template>
            <!-- Close button -->
            <button @click="zoomImage = false"
                class="absolute top-4 right-4 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    </div>
</div>