<!-- Modal Overlay -->
<div x-show="BackstampDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="BackstampDetailModal = false" style="display: none;" 
    x-data="{ 
        zoomImage: false, 
        activeTab: 'basic',
        showDebug: true,
        currentImageIndex: 0,
        get currentImage() {
            return this.backstampToView?.images && this.backstampToView.images.length > 0 
                ? this.backstampToView.images[this.currentImageIndex] 
                : null;
        }
    }">
    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-hidden h-[90vh] flex flex-col">

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 text-white p-6 flex justify-between items-center flex-shrink-0">
            <div>
                <h2 class="text-2xl font-bold" x-text="backstampToView?.backstamp_code || 'Backstamp Details'"></h2>
                <p class="text-blue-100 dark:text-blue-200 text-sm mt-1" x-text="backstampToView?.name || 'Backstamp Information'"></p>
            </div>
            <button @click="BackstampDetailModal = false"
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
                            <template x-if="backstampToView?.images?.length > 0">
                                <div>
                                    <img :src="`{{ asset('storage') }}/${backstampToView.images[currentImageIndex].file_path}`" 
                                        :alt="backstampToView.images[currentImageIndex].file_name"
                                        class="rounded-lg shadow-lg cursor-zoom-in mx-auto h-48 object-contain w-full"
                                        @click="zoomImage = true">
                                    
                                    <!-- Image Navigation -->
                                    <div class="flex justify-between items-center mt-3">
                                        <button @click="currentImageIndex = (currentImageIndex - 1 + backstampToView.images.length) % backstampToView.images.length"
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                                            <span class="material-symbols-outlined">arrow_back</span>
                                        </button>
                                        
                                        <span class="text-sm text-gray-500 dark:text-gray-400">
                                            <span x-text="currentImageIndex + 1"></span>/<span x-text="backstampToView.images.length"></span>
                                        </span>
                                        
                                        <button @click="currentImageIndex = (currentImageIndex + 1) % backstampToView.images.length"
                                                class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                                            <span class="material-symbols-outlined">arrow_forward</span>
                                        </button>
                                    </div>
                                    
                                    <!-- Thumbnails -->
                                    <div class="flex gap-1 mt-3 overflow-x-auto pb-2">
                                        <template x-for="(image, index) in backstampToView.images" :key="index">
                                            <img :src="`{{ asset('storage') }}/${image.file_path}`" 
                                                :alt="`Thumbnail ${index + 1}`"
                                                class="h-12 w-12 object-cover rounded cursor-pointer"
                                                :class="currentImageIndex === index ? 'ring-2 ring-blue-500' : ''"
                                                @click="currentImageIndex = index">
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <template x-if="!backstampToView?.images?.length">
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
                        <template x-if="backstampToView?.status">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium"
                                :class="backstampToView.status.status === 'Active' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 
                                        backstampToView.status.status === 'Inactive' ? 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' : 
                                        'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200'">
                                <span class="w-2 h-2 rounded-full mr-2"
                                    :class="backstampToView.status.status === 'Active' ? 'bg-green-500' : 
                                            backstampToView.status.status === 'Inactive' ? 'bg-red-500' : 
                                            'bg-yellow-500'"></span>
                                <span x-text="backstampToView.status.status"></span>
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
                            <button @click="activeTab = 'application'"
                                :class="activeTab === 'application' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">brush</span>
                                Application
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
                                <!-- Backstamp Code -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mr-2">tag</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Backstamp Code</span>
                                    </div>
                                    <p class="text-lg font-mono text-gray-900 dark:text-gray-100 break-words" x-text="backstampToView?.backstamp_code || '-'"></p>
                                </div>

                                <!-- Backstamp Name -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mr-2">title</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Backstamp Name</span>
                                    </div>
                                    <p class="text-gray-900 dark:text-gray-100 break-words" x-text="backstampToView?.name || '-'"></p>
                                </div>

                                <!-- Duration -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mr-2">schedule</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Duration</span>
                                    </div>
                                    <p class="text-gray-900 dark:text-gray-100" x-text="(backstampToView?.duration || '0') + ' minutes'"></p>
                                </div>

                                <!-- Approval Date -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 mr-2">event</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Approval Date</span>
                                    </div>
                                    <p class="text-gray-900 dark:text-gray-100" x-text="backstampToView?.approval_date ? new Date(backstampToView.approval_date).toLocaleDateString('th-TH') : '-'"></p>
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
                                            <p class="font-medium text-gray-900 dark:text-gray-100 break-words" x-text="backstampToView?.updater?.name || 'System'"></p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600 dark:text-gray-400">Updated At:</p>
                                            <p class="font-medium text-gray-900 dark:text-gray-100" x-text="backstampToView?.updated_at ? new Date(backstampToView.updated_at).toLocaleString('th-TH') : '-'"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Application Tab -->
                        <div x-show="activeTab === 'application'" 
                            class="h-full overflow-y-auto overflow-x-hidden">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                <!-- In Glaze -->
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg p-6 border border-blue-200 dark:border-blue-700 text-center">
                                    <div class="flex items-center justify-center mb-3">
                                        <span class="material-symbols-outlined text-3xl text-blue-600 dark:text-blue-400">format_paint</span>
                                    </div>
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">In Glaze</h4>
                                    <div class="flex items-center justify-center">
                                        <span x-show="backstampToView?.in_glaze" class="text-green-600 dark:text-green-400">
                                            <span class="material-symbols-outlined text-2xl">check_circle</span>
                                        </span>
                                        <span x-show="!backstampToView?.in_glaze" class="text-red-600 dark:text-red-400">
                                            <span class="material-symbols-outlined text-2xl">cancel</span>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2" x-text="backstampToView?.in_glaze ? 'Available' : 'Not Available'"></p>
                                </div>

                                <!-- On Glaze -->
                                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg p-6 border border-green-200 dark:border-green-700 text-center">
                                    <div class="flex items-center justify-center mb-3">
                                        <span class="material-symbols-outlined text-3xl text-green-600 dark:text-green-400">brush</span>
                                    </div>
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">On Glaze</h4>
                                    <div class="flex items-center justify-center">
                                        <span x-show="backstampToView?.on_glaze" class="text-green-600 dark:text-green-400">
                                            <span class="material-symbols-outlined text-2xl">check_circle</span>
                                        </span>
                                        <span x-show="!backstampToView?.on_glaze" class="text-red-600 dark:text-red-400">
                                            <span class="material-symbols-outlined text-2xl">cancel</span>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2" x-text="backstampToView?.on_glaze ? 'Available' : 'Not Available'"></p>
                                </div>

                                <!-- Under Glaze -->
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-lg p-6 border border-purple-200 dark:border-purple-700 text-center">
                                    <div class="flex items-center justify-center mb-3">
                                        <span class="material-symbols-outlined text-3xl text-purple-600 dark:text-purple-400">layers</span>
                                    </div>
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Under Glaze</h4>
                                    <div class="flex items-center justify-center">
                                        <span x-show="backstampToView?.under_glaze" class="text-green-600 dark:text-green-400">
                                            <span class="material-symbols-outlined text-2xl">check_circle</span>
                                        </span>
                                        <span x-show="!backstampToView?.under_glaze" class="text-red-600 dark:text-red-400">
                                            <span class="material-symbols-outlined text-2xl">cancel</span>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2" x-text="backstampToView?.under_glaze ? 'Available' : 'Not Available'"></p>
                                </div>

                                <!-- Air Dry -->
                                <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-lg p-6 border border-orange-200 dark:border-orange-700 text-center">
                                    <div class="flex items-center justify-center mb-3">
                                        <span class="material-symbols-outlined text-3xl text-orange-600 dark:text-orange-400">air</span>
                                    </div>
                                    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-2">Air Dry</h4>
                                    <div class="flex items-center justify-center">
                                        <span x-show="backstampToView?.air_dry" class="text-green-600 dark:text-green-400">
                                            <span class="material-symbols-outlined text-2xl">check_circle</span>
                                        </span>
                                        <span x-show="!backstampToView?.air_dry" class="text-red-600 dark:text-red-400">
                                            <span class="material-symbols-outlined text-2xl">cancel</span>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2" x-text="backstampToView?.air_dry ? 'Available' : 'Not Available'"></p>
                                </div>
                            </div>

                            <!-- Application Summary -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center">
                                    <span class="material-symbols-outlined mr-2">palette</span>
                                    Application Methods Summary
                                </h4>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <p class="mb-2">This backstamp supports the following application methods:</p>
                                    <ul class="list-disc list-inside space-y-1">
                                        <li x-show="backstampToView?.in_glaze" class="text-blue-600 dark:text-blue-400">In Glaze - Applied within the glaze layer</li>
                                        <li x-show="backstampToView?.on_glaze" class="text-green-600 dark:text-green-400">On Glaze - Applied on top of the glaze layer</li>
                                        <li x-show="backstampToView?.under_glaze" class="text-purple-600 dark:text-purple-400">Under Glaze - Applied beneath the glaze layer</li>
                                        <li x-show="backstampToView?.air_dry" class="text-orange-600 dark:text-orange-400">Air Dry - Can be air dried</li>
                                        <li x-show="!backstampToView?.in_glaze && !backstampToView?.on_glaze && !backstampToView?.under_glaze && !backstampToView?.air_dry" class="text-gray-500 dark:text-gray-400">No application methods available</li>
                                    </ul>
                                </div>
                            </div>
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
                                    <p class="text-lg font-medium text-blue-800 dark:text-blue-200 break-words" x-text="backstampToView?.customer?.name || '-'"></p>
                                </div>

                                <!-- Requestor -->
                                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg p-4 border border-green-200 dark:border-green-700">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 mr-2">person</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Requestor</span>
                                    </div>
                                    <p class="text-lg font-medium text-green-800 dark:text-green-200 break-words" x-text="backstampToView?.requestor?.name || '-'"></p>
                                </div>

                                <!-- Status -->
                                <div class="bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900 dark:to-orange-800 rounded-lg p-4 border border-orange-200 dark:border-orange-700">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-orange-600 dark:text-orange-400 mr-2">flag</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Status</span>
                                    </div>
                                    <p class="text-lg font-medium text-orange-800 dark:text-orange-200 break-words" x-text="backstampToView?.status?.status || '-'"></p>
                                </div>

                                <!-- Duration -->
                                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900 dark:to-red-800 rounded-lg p-4 border border-red-200 dark:border-red-700">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 mr-2">schedule</span>
                                        <span class="font-semibold text-gray-700 dark:text-gray-300">Processing Time</span>
                                    </div>
                                    <p class="text-lg font-medium text-red-800 dark:text-red-200" x-text="(backstampToView?.duration || '0') + ' minutes'"></p>
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
                Created: <span x-text="backstampToView?.created_at ? new Date(backstampToView.created_at).toLocaleDateString('th-TH') : '-'"></span>
            </div>
            <button @click="BackstampDetailModal = false"
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
            <pre x-text="JSON.stringify(backstampToView.images, null, 2)" class="whitespace-pre-wrap"></pre>
        </div>
        <div class="overflow-auto flex-1" style="max-height: calc(90vh - 40px);">
            <pre x-text="JSON.stringify(backstampToView, null, 2)" class="whitespace-pre-wrap"></pre>
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
                        :alt="backstampToView.item_code"
                        class="max-h-[80vh] max-w-[95vw] object-contain rounded-lg shadow-2xl">
                        
                    <!-- Navigation Arrows -->
                    <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex justify-between px-4">
                        <button @click.stop="currentImageIndex = (currentImageIndex - 1 + backstampToView.images.length) % backstampToView.images.length"
                                class="bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-all">
                            <span class="material-symbols-outlined">arrow_back</span>
                        </button>
                        <button @click.stop="currentImageIndex = (currentImageIndex + 1) % backstampToView.images.length"
                                class="bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-all">
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                    </div>
                    
                    <!-- Image Counter -->
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black bg-opacity-50 text-white px-3 py-1 rounded-full">
                        <span x-text="currentImageIndex + 1"></span>/<span x-text="backstampToView.images.length"></span>
                    </div>
                </div>
            </template>

            <template x-if="!backstampToView?.images?.length">
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
