<!-- Modal Overlay -->
<div x-show="GlazeDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="GlazeDetailModal = false" style="display: none;" 
    x-data="{ 
        zoomImage: false, 
        activeTab: 'basic',
        showDebug: true,
        currentImageIndex: 0,
        get currentImage() {
            return this.glazeToView?.images && this.glazeToView.images.length > 0 
                ? this.glazeToView.images[this.currentImageIndex] 
                : null;
        }
    }">

    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-hidden h-[90vh] flex flex-col">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 text-white p-6 flex justify-between items-center flex-shrink-0">
            <div>
                <h2 class="text-2xl font-bold" x-text="glazeToView?.glaze_code || '{{ __('content.details') }} {{ __('content.glaze') }}'"></h2>
                <p class="text-blue-100 dark:text-blue-200 text-sm mt-1" x-text="'{{ __('content.details') }} {{ __('content.glaze') }}'"></p>
            </div>
            <button @click="GlazeDetailModal = false"
                class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-hidden">
            <!-- Image and Basic Info Section -->
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
                                        class="rounded-lg shadow-lg cursor-zoom-in mx-auto h-48 object-contain w-full"
                                        @click="zoomImage = true">
                                    
                                    <!-- Image Navigation -->
                                    <div class="flex justify-between items-center mt-3">
                                        <button @click="currentImageIndex = (currentImageIndex - 1 + glazeToView.images.length) % glazeToView.images.length"
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                                            <span class="material-symbols-outlined">arrow_back</span>
                                        </button>
                                        
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            <span x-text="currentImageIndex + 1"></span>/<span x-text="glazeToView.images.length"></span>
                                        </span>
                                        
                                        <button @click="currentImageIndex = (currentImageIndex + 1) % glazeToView.images.length"
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                                            <span class="material-symbols-outlined">arrow_forward</span>
                                        </button>
                                    </div>
                                    
                                    <!-- Thumbnails -->
                                    <div class="flex gap-1 mt-3 overflow-x-auto pb-2">
                                        <template x-for="(image, index) in glazeToView.images" :key="index">
                                            <img :src="`{{ asset('storage') }}/${image.file_path}`" 
                                                :alt="`Thumbnail ${index + 1}`"
                                                class="h-12 w-12 object-cover rounded cursor-pointer"
                                                :class="currentImageIndex === index ? 'ring-2 ring-blue-500' : ''"
                                                @click="currentImageIndex = index">
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <template x-if="!glazeToView?.images?.length">
                                <div class="bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center h-48">
                                    <div class="text-center text-gray-500 dark:text-gray-400">
                                        <span class="material-symbols-outlined text-6xl mb-2 block">image</span>
                                        <p>No Images Available</p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                    <!-- Status Badge -->
                    <div class="mt-4 text-center flex-shrink-0">
                        <template x-if="glazeToView?.status">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium"
                                    :class="glazeToView.status.status === 'Active' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 
                                            glazeToView.status.status === 'Inactive' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : 
                                            'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200'">
                                <span class="w-2 h-2 rounded-full mr-2"
                                        :class="glazeToView.status.status === 'Active' ? 'bg-green-500' : 
                                                glazeToView.status.status === 'Inactive' ? 'bg-red-500' : 
                                                'bg-yellow-500'"></span>
                                <span x-text="glazeToView.status.status"></span>
                            </span>
                        </template>
                    </div>
                </div>

                <!-- Tabs Content -->
                <div class="lg:col-span-2 flex flex-col overflow-hidden">
                    
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-6 flex-shrink-0">
                        <nav class="flex space-x-8">
                            <button @click="activeTab = 'basic'"
                                :class="activeTab === 'basic' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">info</span>
                                Basic Information
                            </button>
                            <button @click="activeTab = 'colors'"
                                :class="activeTab === 'colors' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">palette</span>
                                Colors
                            </button>
                            <button @click="activeTab = 'relations'"
                                :class="activeTab === 'relations' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">group</span>
                                Relations
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content Container -->
                    <div class="flex-1 min-h-0">
                        <!-- Basic Information Tab -->
                        <div x-show="activeTab === 'basic'" 
                             class="h-full overflow-y-auto overflow-x-hidden">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Glaze Code -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mr-2">tag</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Glaze Code</span>
                                    </div>
                                    <p class="text-lg font-mono text-gray-900 dark:text-gray-100 break-words" x-text="glazeToView?.glaze_code || '-'"></p>
                                </div>

                                <!-- Duration -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mr-2">schedule</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Duration</span>
                                    </div>
                                    <p class="text-gray-900 dark:text-gray-100" x-text="(glazeToView?.duration || '0') + ' minutes'"></p>
                                </div>

                                <!-- Approval Date -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mr-2">event</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Approval Date</span>
                                    </div>
                                    <p class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.approval_date ? new Date(glazeToView.approval_date).toLocaleDateString('th-TH') : '-'"></p>
                                </div>

                                <!-- Created Date -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mr-2">add_circle</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Created Date</span>
                                    </div>
                                    <p class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.created_at ? new Date(glazeToView.created_at).toLocaleDateString('th-TH') : '-'"></p>
                                </div>

                                <!-- Last Updated Info -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 sm:col-span-2">
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
                                        <span class="material-symbols-outlined mr-2">history</span>
                                        Update Information
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600 dark:text-gray-400">Last Updated By:</p>
                                            <p class="font-medium text-gray-900 dark:text-gray-100 break-words" x-text="glazeToView?.updater?.name || 'System'"></p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600 dark:text-gray-400">Updated At:</p>
                                            <p class="font-medium text-gray-900 dark:text-gray-100" x-text="glazeToView?.updated_at ? new Date(glazeToView.updated_at).toLocaleString('th-TH') : '-'"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Colors Tab -->
                        <div x-show="activeTab === 'colors'" 
                             class="h-full overflow-y-auto overflow-x-hidden">
                            <template x-if="glazeToView?.colors && glazeToView.colors.length > 0">
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                    <template x-for="color in glazeToView.colors" :key="color.id">
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-all">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-full border-2 border-gray-300 dark:border-gray-500 shadow-inner"
                                                     :style="`background-color: ${color.color_code || '#000000'}`"></div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-medium text-gray-900 dark:text-gray-100 text-sm truncate" x-text="color.color_name"></p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-mono" x-text="color.color_code"></p>
                                                    <p class="text-xs text-gray-400 dark:text-gray-500 truncate" x-text="color.customer?.name || '-'"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!glazeToView?.colors || glazeToView.colors.length === 0">
                                <div class="text-center py-12">
                                    <span class="material-symbols-outlined text-6xl text-gray-400 dark:text-gray-500 mb-4 block">palette</span>
                                    <p class="text-gray-500 dark:text-gray-400 text-lg">No colors associated with this glaze</p>
                                </div>
                            </template>
                        </div>

                        <!-- Relations Tab -->
                        <div x-show="activeTab === 'relations'" 
                             class="h-full overflow-y-auto overflow-x-hidden">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Customer -->
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg p-4 border border-blue-200 dark:border-blue-700">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mr-2">business</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Customer</span>
                                    </div>
                                    <p class="text-lg font-medium text-blue-800 dark:text-blue-200 break-words" x-text="glazeToView?.customer?.name || '-'"></p>
                                </div>

                                <!-- Requestor -->
                                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg p-4 border border-green-200 dark:border-green-700">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 mr-2">person</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Requestor</span>
                                    </div>
                                    <p class="text-lg font-medium text-green-800 dark:text-green-200 break-words" x-text="glazeToView?.requestor?.name || '-'"></p>
                                </div>

                                <!-- Status -->
                                <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-lg p-4 border border-orange-200 dark:border-orange-700">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-orange-600 dark:text-orange-400 mr-2">flag</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Status</span>
                                    </div>
                                    <p class="text-lg font-medium text-orange-800 dark:text-orange-200 break-words" x-text="glazeToView?.status?.status || '-'"></p>
                                </div>

                                <!-- Color Count -->
                                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900 dark:to-red-800 rounded-lg p-4 border border-red-200 dark:border-red-700">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 mr-2">palette</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Associated Colors</span>
                                    </div>
                                    <p class="text-lg font-medium text-red-800 dark:text-red-200" x-text="(glazeToView?.colors?.length || 0) + ' colors'"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center border-t border-gray-200 dark:border-gray-600 flex-shrink-0">
            <div class="text-sm text-gray-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-sm mr-1">schedule</span>
                Created: <span x-text="glazeToView?.created_at ? new Date(glazeToView.created_at).toLocaleDateString('th-TH') : '-'"></span>
            </div>
            <button @click="GlazeDetailModal = false"
                class="bg-gray-500 dark:bg-gray-600 hover:bg-blue-600 dark:hover:bg-blue-500 text-white py-2 px-6 rounded-lg transition-all duration-200 hoverScale">
                <span class="material-symbols-outlined text-sm mr-1 mt-1">close</span>
                Close
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
            <pre x-text="JSON.stringify(glazeToView.images, null, 2)" class="whitespace-pre-wrap"></pre>
        </div>
        <div class="overflow-auto flex-1" style="max-height: calc(90vh - 40px);">
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
                        :alt="glazeToView.item_code"
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
                    <p class="text-gray-600 dark:text-gray-300">No Images Available</p>
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
