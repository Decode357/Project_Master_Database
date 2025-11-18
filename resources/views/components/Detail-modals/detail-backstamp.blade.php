<!-- Modal Overlay -->
<div x-show="BackstampDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="BackstampDetailModal = false" style="display: none;"
    x-data="{ 
        zoomImage: false, 
        activeTab: 'info',
        currentImageIndex: 0,
        get currentImage() {
            return this.backstampToView?.images && this.backstampToView.images.length > 0 
                ? this.backstampToView.images[this.currentImageIndex] 
                : null;
        }
    }">
    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-visible h-[90vh] flex flex-col">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-600 to-orange-800 dark:from-orange-700 dark:to-orange-900 text-white p-6 flex justify-between items-center flex-shrink-0 rounded-t-2xl">
            <div>
                <h2 class="text-2xl font-bold" x-text="backstampToView?.backstamp_code || '{{ __('content.details') }} {{ __('content.backstamp') }}'"></h2>
                <p class="text-orange-100 dark:text-orange-200 text-sm mt-1" x-text="backstampToView?.name || '{{ __('content.details') }} {{ __('content.backstamp') }}'"></p>
            </div>
            <button @click="BackstampDetailModal = false"
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
                            <template x-if="backstampToView?.images?.length > 0">
                                <div>
                                    <img :src="`{{ asset('storage') }}/${backstampToView.images[currentImageIndex].file_path}`" 
                                        :alt="backstampToView.images[currentImageIndex].file_name"
                                        class="rounded-lg shadow-lg cursor-zoom-in mx-auto h-64 md:h-80 object-contain w-full"
                                        @click="zoomImage = true">
                                    
                                    <!-- Image Navigation -->
                                    <div class="flex justify-between items-center mt-3">
                                        <button @click="currentImageIndex = (currentImageIndex - 1 + backstampToView.images.length) % backstampToView.images.length"
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                                            <span class="material-symbols-outlined mt-1">arrow_back</span>
                                        </button>
                                        
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            <span x-text="currentImageIndex + 1"></span>/<span x-text="backstampToView.images.length"></span>
                                        </span>
                                        
                                        <button @click="currentImageIndex = (currentImageIndex + 1) % backstampToView.images.length"
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                                            <span class="material-symbols-outlined mt-1">arrow_forward</span>
                                        </button>
                                    </div>
                                    
                                    <!-- Thumbnails -->
                                    <div class="flex gap-1 px-2 py-2 overflow-x-auto pb-2"> 
                                        <template x-for="(image, index) in backstampToView.images" :key="index">
                                            <img :src="`{{ asset('storage') }}/${image.file_path}`" 
                                                :alt="`Thumbnail ${index + 1}`"
                                                class="h-12 w-12 object-cover rounded cursor-pointer"
                                                :class="currentImageIndex === index ? 'ring-2 ring-orange-500' : ''"
                                                @click="currentImageIndex = index">
                                        </template>
                                    </div>
                                </div>
                            </template>
                            
                            <template x-if="!backstampToView?.images?.length">
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
                        <template x-if="backstampToView?.status">
                            <div class="flex flex-col items-center">
                                <label class="text-gray-700 dark:text-gray-300 font-semibold mb-1">{{ __('content.status') }}</label>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium"
                                    :class="{
                                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': backstampToView.status.status === 'Active',
                                        'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300': backstampToView.status.status === 'Cancel',
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300': backstampToView.status.status !== 'Active' && backstampToView.status.status !== 'Cancel'
                                    }">
                                    <span class="w-2 h-2 rounded-full mr-2"
                                        :class="{
                                            'bg-green-500': backstampToView.status.status === 'Active',
                                            'bg-red-500': backstampToView.status.status === 'Cancel',
                                            'bg-yellow-500': backstampToView.status.status !== 'Active' && backstampToView.status.status !== 'Cancel'
                                        }"></span>
                                    <span x-text="backstampToView.status.status"></span>
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
                                <p class="font-medium text-gray-900 dark:text-gray-100 break-words" x-text="backstampToView?.updater?.name || 'System'"></p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">{{ __('content.update_at') }}:</p>
                                <p class="font-medium text-gray-900 dark:text-gray-100" x-text="backstampToView?.updated_at ? new Date(backstampToView.updated_at).toLocaleString('th-TH') : '-'"></p>
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
                                :class="activeTab === 'info' ? 'border-orange-500 text-orange-600 dark:text-orange-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">info</span>
                                {{ __('content.information') }}
                            </button>
                            <button @click="activeTab = 'customer_details'"
                                :class="activeTab === 'customer_details' ? 'border-orange-500 text-orange-600 dark:text-orange-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">Patient_List</span>
                                {{ __('content.customer_details') }}
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content Container -->
                    <div class="flex-1 min-h-0">
                        <!-- Information Tab -->
                        <div x-show="activeTab === 'info'" class="h-full overflow-y-auto overflow-x-hidden flex flex-col gap-2 font-lg text-lg">
                            
                            <!-- Backstamp Code -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-orange-600 dark:text-orange-400">qr_code_2</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.backstamp_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="backstampToView?.backstamp_code || '-'"></span>
                            </div>
                            
                            <!-- Backstamp Name -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-orange-600 dark:text-orange-400">border_color</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.backstamp_name') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="backstampToView?.name || '-'"></span>
                            </div>

                            <!-- Organic -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-lime-600 dark:text-lime-400">
                                    Eco
                                </span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.organic') }}:
                                </label>
                                <template x-if="backstampToView?.organic === true">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check</span>
                                </template>
                                <template x-if="backstampToView?.organic === false">
                                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">close</span>
                                </template>
                            </div>

                            <!-- In Glaze -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">
                                    Vertical_Align_Center
                                </span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.in_glaze') }}:
                                </label>
                                <template x-if="backstampToView?.in_glaze === true">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check</span>
                                </template>
                                <template x-if="backstampToView?.in_glaze === false">
                                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">close</span>
                                </template>
                            </div>

                            <!-- On Glaze -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">
                                    Vertical_Align_Bottom
                                </span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.on_glaze') }}:
                                </label>
                                <template x-if="backstampToView?.on_glaze === true">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check</span>
                                </template>
                                <template x-if="backstampToView?.on_glaze === false">
                                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">close</span>
                                </template>
                            </div>

                            <!-- Under Glaze -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">
                                    Vertical_Align_Top
                                </span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.under_glaze') }}:
                                </label>
                                <template x-if="backstampToView?.under_glaze === true">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check</span>
                                </template>
                                <template x-if="backstampToView?.under_glaze === false">
                                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">close</span>
                                </template>
                            </div>

                            <!-- Air dry -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-gray-600 dark:text-gray-400">
                                    Air
                                </span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.air_dry') }}:
                                </label>
                                <template x-if="backstampToView?.air_dry === true">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check</span>
                                </template>
                                <template x-if="backstampToView?.air_dry === false">
                                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">close</span>
                                </template>
                            </div>

                            <!-- Approval Date -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">Order_Approve</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.approval_date') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="backstampToView?.approval_date ? new Date(backstampToView.approval_date).toLocaleDateString('th-TH') : '-'"></span>
                            </div>

                            <hr class="mt-3 mb-2 border-gray-300 dark:border-gray-600">
                            
                            <!-- Customer -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">business</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.customer') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100 hoverScale hover:text-blue-600 hover:dark:text-blue-400" @click="activeTab = 'customer_details'" style="cursor: pointer;" 
                                    x-text="backstampToView?.customer?.name || '-'">
                                </span>
                            </div>
                            
                            <!-- Requestor -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-red-600 dark:text-red-400">person_raised_hand</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.requestor') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="backstampToView?.requestor?.name || '-'"></span>
                            </div>
                        </div>
                        <!-- Customer Detail -->
                        <div x-show="activeTab === 'customer_details'" class="h-full overflow-y-auto overflow-x-visible flex flex-col gap-1 font-lg text-lg">
                            <!-- Code -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">Qr_Code_2</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="backstampToView?.customer?.code || '-'"></span>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Name -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">Signature</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.name') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="backstampToView?.customer?.name || '-'"></span>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Email -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">Mail</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.email') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="backstampToView?.customer?.email || '-'"></span>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Phone -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">call</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.phone') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="backstampToView?.customer?.phone || '-'"></span>
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
                {{ __('content.created_at') }}: <span x-text="backstampToView?.created_at ? new Date(backstampToView.created_at).toLocaleDateString('th-TH') : '-'"></span>
            </div>
            <button @click="BackstampDetailModal = false"
                class="bg-gray-500 dark:bg-gray-600 hover:bg-orange-600 dark:hover:bg-orange-500 text-white py-2 px-6 rounded-lg transition-all duration-200 hoverScale">
                {{ __('content.close') }}
            </button>
        </div>
    </div>

    <!-- Zoom Image Modal -->
    <div x-show="zoomImage" x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-95 flex items-center justify-center z-60"
        @click.self="zoomImage = false">
        <div class="relative max-h-[95vh] max-w-[95vw]">
            <template x-if="backstampToView?.images?.length > 0">
                <div class="relative">
                    <img :src="`{{ asset('storage') }}/${backstampToView.images[currentImageIndex].file_path}`" 
                        :alt="backstampToView.backstamp_code"
                        class="max-h-[80vh] max-w-[95vw] object-contain rounded-lg shadow-2xl">
                        
                    <!-- Navigation Arrows -->
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex justify-between px-4">
                        <button @click.stop="currentImageIndex = (currentImageIndex - 1 + backstampToView.images.length) % backstampToView.images.length"
                                class="text-gray-500 hoverScale">
                            <span class="material-symbols-outlined">Arrow_Back_iOS</span>
                        </button>
                        <button @click.stop="currentImageIndex = (currentImageIndex + 1) % backstampToView.images.length"
                                class="text-gray-500 hoverScale">
                            <span class="material-symbols-outlined">Arrow_Forward_iOS</span>
                        </button>
                    </div>
                    
                    <!-- Image Counter -->
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 text-white px-3 py-1 rounded-full">
                        <span x-text="currentImageIndex + 1"></span>/<span x-text="backstampToView.images.length"></span>
                    </div>
                </div>
            </template>
            
            <template x-if="!backstampToView?.images?.length">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-8 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4 block">image</span>
                    <p class="text-gray-600 dark:text-gray-300">{{ __('content.no_images_available') }}</p>
                </div>
            </template>
            
            <!-- Close button -->
            <button @click="zoomImage = false"
                class="absolute top-4 right-4 text-gray-500 hoverScale">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    </div>
</div>
