<!-- Modal Overlay -->
<div x-show="GlazeDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="GlazeDetailModal = false" style="display: none;"
    x-data="{ 
        zoomImage: false, 
        activeTab: 'info',
        showDebug: false,
        currentImageIndex: 0,
        get currentImage() {
            return this.glazeToView?.images && this.glazeToView.images.length > 0 
                ? this.glazeToView.images[this.currentImageIndex] 
                : null;
        }
    }">
    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-visible h-[90vh] flex flex-col">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 dark:from-purple-700 dark:to-purple-900 text-white p-6 flex justify-between items-center flex-shrink-0 rounded-t-2xl">
            <div>
                <h2 class="text-2xl font-bold" x-text="glazeToView?.glaze_code || '{{ __('content.details') }} {{ __('content.glaze') }}'"></h2>
                <p class="text-purple-100 dark:text-purple-200 text-sm mt-1" x-text="glazeToView?.glaze_name || '{{ __('content.details') }} {{ __('content.glaze') }}'"></p>
            </div>
            <button @click="GlazeDetailModal = false"
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
                            <template x-if="glazeToView?.images?.length > 0">
                                <div>
                                    <img :src="`{{ asset('storage') }}/${glazeToView.images[currentImageIndex].file_path}`" 
                                        :alt="glazeToView.images[currentImageIndex].file_name"
                                        class="rounded-lg shadow-lg cursor-zoom-in mx-auto h-64 md:h-80 object-contain w-full"
                                        @click="zoomImage = true">
                                    
                                    <!-- Image Navigation -->
                                    <div class="flex justify-between items-center mt-3">
                                        <button @click="currentImageIndex = (currentImageIndex - 1 + glazeToView.images.length) % glazeToView.images.length"
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                                            <span class="material-symbols-outlined mt-1">arrow_back</span>
                                        </button>
                                        
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            <span x-text="currentImageIndex + 1"></span>/<span x-text="glazeToView.images.length"></span>
                                        </span>
                                        
                                        <button @click="currentImageIndex = (currentImageIndex + 1) % glazeToView.images.length"
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                                            <span class="material-symbols-outlined mt-1">arrow_forward</span>
                                        </button>
                                    </div>
                                    
                                    <!-- Thumbnails -->
                                    <div class="flex gap-1 px-2 py-2 overflow-x-auto pb-2"> 
                                        <template x-for="(image, index) in glazeToView.images" :key="index">
                                            <img :src="`{{ asset('storage') }}/${image.file_path}`" 
                                                :alt="`Thumbnail ${index + 1}`"
                                                class="h-12 w-12 object-cover rounded cursor-pointer"
                                                :class="currentImageIndex === index ? 'ring-2 ring-purple-500' : ''"
                                                @click="currentImageIndex = index">
                                        </template>
                                    </div>
                                </div>
                            </template>
                            
                            <template x-if="!glazeToView?.images?.length">
                                <div class="bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center h-48">
                                    <div class="text-center text-gray-500 dark:text-gray-400">
                                        <span class="material-symbols-outlined text-6xl mb-2 block">image</span>
                                        <p>{{ __('content.no_images_available') }}</p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div class="my-2 flex justify-center items-center border border-gray-200 dark:border-gray-600 rounded-lg p-2">
                        <template x-if="glazeToView?.status">
                            <div class="flex flex-col items-center">
                                <label class="text-gray-700 dark:text-gray-300 font-semibold mb-1">{{ __('content.status') }}</label>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200">
                                    <span class="w-2 h-2 rounded-full mr-2 bg-yellow-500"></span>
                                    <span x-text="glazeToView.status.status"></span>
                                </span>
                            </div>
                        </template>
                    </div>

                    <!-- Last Updated Info -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                            <span class="material-symbols-outlined mr-2">history</span>
                            {{ __('content.update_information') }}
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">{{ __('content.update_by') }}:</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100 break-words" x-text="glazeToView?.updater?.name || 'System'"></p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">{{ __('content.update_at') }}:</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100" x-text="glazeToView?.updated_at ? new Date(glazeToView.updated_at).toLocaleString('th-TH') : '-'"></p>
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
                                :class="activeTab === 'info' ? 'border-purple-500 text-purple-600 dark:text-purple-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">info</span>
                                {{ __('content.information') }}
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content Container -->
                    <div class="flex-1 min-h-0">
                        <!-- Information Tab -->
                        <div x-show="activeTab === 'info'" class="h-full overflow-y-auto overflow-x-hidden flex flex-col gap-2 font-lg text-lg">
                            
                            <!-- Glaze Code -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">qr_code_2</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.glaze_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.glaze_code || '-'"></span>
                            </div>
                            
                            <!-- Temperature -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-red-600 dark:text-red-400">device_thermostat</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.fire_temp') }}:
                                </label>
                                <span 
                                    class="text-gray-900 dark:text-gray-100"
                                    x-text="glazeToView?.fire_temp ? glazeToView.fire_temp + ' {{ __('content.°C_full') }}' : '-'">
                                </span>

                            </div>

                            <!-- Approval Date -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">Order_Approve</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.approval_date') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.approval_date ? new Date(glazeToView.approval_date).toLocaleDateString('th-TH') : '-'"></span>
                            </div>
                            
                            <hr class="my-3 border-gray-300 dark:border-gray-600">

                            <!-- Glaze Inside -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-indigo-600 dark:text-indigo-400">qr_code</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.inside_color_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.glaze_inside?.glaze_inside_code || '-'"></span>
                            </div>
                            
                            <!-- Inside Color -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-indigo-600 dark:text-indigo-400">Format_Color_Fill</span>
                                <label class="text-gray-700 dark:text-gray-300 font-medium">
                                    {{ __('content.inside_color') }}:
                                </label>
                                <template x-if="glazeToView?.glaze_inside?.colors?.length > 0">
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="(color, index) in glazeToView.glaze_inside.colors" :key="index">
                                            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                                <!-- Color Code -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_code || '-'"></span>
                                                <span class="text-gray-400 dark:text-gray-500">|</span>
                                                <!-- Color Name -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_name || '-'"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>                    
                                <template x-if="!glazeToView?.glaze_inside?.colors?.length">
                                    <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('content.no_color') }}</span>
                                </template>
                            </div>

                            <!-- Glaze Outside -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-pink-600 dark:text-pink-400">qr_code</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.outside_color_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.glaze_outer?.glaze_outer_code || '-'"></span>
                            </div>

                            <!-- Outside Color -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-pink-600 dark:text-pink-400">Format_Color_Fill</span>
                                <label class="text-gray-700 dark:text-gray-300 font-medium">
                                    {{ __('content.outside_color') }}:
                                </label>
                                <template x-if="glazeToView?.glaze_outer?.colors?.length > 0">
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="(color, index) in glazeToView.glaze_outer.colors" :key="index">
                                            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                                <!-- Color Code -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_code || '-'"></span>
                                                <span class="text-gray-400 dark:text-gray-500">|</span>
                                                <!-- Color Name -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_name || '-'"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>                    
                                <template x-if="!glazeToView?.glaze_outer?.colors?.length">
                                    <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('content.no_color') }}</span>
                                </template>
                            </div>

                            <hr class="my-3 border-gray-300 dark:border-gray-600">

                            <!-- Effect Code-->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">qr_code</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.effect_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.effect?.effect_code || '-'"></span>
                            </div>

                            <!-- Effect Name -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">auto_awesome</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.effect_name') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.effect?.effect_name || '-'"></span>
                            </div>

                            <!-- Effect Color -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">Format_Color_Fill</span>
                                <label class="text-gray-700 dark:text-gray-300 font-medium">
                                    {{ __('content.effect_color') }}:
                                </label>
                                <template x-if="glazeToView?.effect?.colors?.length > 0">
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="(color, index) in glazeToView.effect.colors" :key="index">
                                            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                                <!-- Color Code -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_code || '-'"></span>
                                                <span class="text-gray-400 dark:text-gray-500">|</span>
                                                <!-- Color Name -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_name || '-'"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>                    
                                <template x-if="!glazeToView?.effect?.colors?.length">
                                    <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('content.no_color') }}</span>
                                </template>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center border-t border-gray-200 dark:border-gray-600 flex-shrink-0 rounded-b-2xl">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-sm mr-1">schedule</span>
                {{ __('content.created_at') }}: <span x-text="glazeToView?.created_at ? new Date(glazeToView.created_at).toLocaleDateString('th-TH') : '-'"></span>
            </div>
            <button @click="GlazeDetailModal = false"
                class="bg-gray-500 dark:bg-gray-600 hover:bg-purple-600 dark:hover:bg-purple-500 text-white py-2 px-6 rounded-lg transition-all duration-200 hoverScale">
                {{ __('content.close') }}
            </button>
        </div>
    </div>

    <!-- Debug Panel - กดปุ่ม F3 เพื่อเปิด/ปิด -->
    <div x-show="showDebug" 
        class="fixed top-2 right-2 bg-black bg-opacity-90 text-green-400 p-4 rounded text-xs font-mono max-w-2xl"
        @keydown.window.f2.prevent="showDebug = !showDebug">
        <div class="flex justify-between items-center mb-2">
            <span>Debug: Glaze Data (Press F3 to close)</span>
            <button @click="showDebug = false" class="text-white hover:text-red-400">✕</button>
        </div>
        <div class="overflow-auto" style="max-height: calc(90vh - 40px);">
            <pre x-text="JSON.stringify(glazeToView, null, 2)" class="whitespace-pre-wrap"></pre>
        </div>
    </div>

    <!-- Zoom Image Modal -->
    <div x-show="zoomImage" x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-95 flex items-center justify-center z-60"
        @click.self="zoomImage = false">
        <div class="relative max-h-[95vh] max-w-[95vw]">
            <template x-if="glazeToView?.images?.length > 0">
                <div class="relative">
                    <img :src="`{{ asset('storage') }}/${glazeToView.images[currentImageIndex].file_path}`" 
                        :alt="glazeToView.glaze_code"
                        class="max-h-[80vh] max-w-[95vw] object-contain rounded-lg shadow-2xl">
                        
                    <!-- Navigation Arrows -->
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex justify-between px-4">
                        <button @click.stop="currentImageIndex = (currentImageIndex - 1 + glazeToView.images.length) % glazeToView.images.length"
                                class="bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-all">
                            <span class="material-symbols-outlined">arrow_back</span>
                        </button>
                        <button @click.stop="currentImageIndex = (currentImageIndex + 1) % glazeToView.images.length"
                                class="bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-all">
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                    
                    <!-- Image Counter -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full">
                        <span x-text="currentImageIndex + 1"></span>/<span x-text="glazeToView.images.length"></span>
                    </div>
                </div>
            </template>
            
            <template x-if="!glazeToView?.images?.length">
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
