<!-- Modal Overlay -->
<div x-show="ShapeDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="ShapeDetailModal = false" style="display: none;"
    x-data="{ zoomImage: false, activeTab: 'basic' }">
    
    <!-- Modal Content -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-hidden h-[90vh] flex flex-col">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 flex justify-between items-center flex-shrink-0">
            <div>
                <h2 class="text-2xl font-bold" x-text="shapeToView?.item_code || 'Shape Details'"></h2>
                <p class="text-blue-100 text-sm mt-1" x-text="shapeToView?.item_description_eng || 'Product Details'"></p>
            </div>
            <button @click="ShapeDetailModal = false"
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
                    <div class="bg-gray-50 rounded-xl p-4 text-center flex-shrink-0">
                        <template x-if="shapeToView?.image?.file_path">
                            <img :src="`{{ asset('storage') }}/${shapeToView.image.file_path}`" 
                                 :alt="shapeToView.item_code"
                                 class="rounded-lg shadow-lg cursor-zoom-in mx-auto h-48 object-contain w-full"
                                 @click="zoomImage = true">
                        </template>
                        <template x-if="!shapeToView?.image?.file_path">
                            <div class="bg-gray-200 rounded-lg flex items-center justify-center h-48">
                                <div class="text-center text-gray-500">
                                    <span class="material-symbols-outlined text-6xl mb-2 block">image</span>
                                    <p>No Image Available</p>
                                </div>
                            </div>
                        </template>
                        <p class="text-sm text-gray-500 mt-3">
                            <span class="material-symbols-outlined text-lg align-middle">zoom_in</span>
                            Click to zoom
                        </p>
                    </div>

                    <!-- Status Badge -->
                    <div class="mt-4 text-center flex-shrink-0">
                        <template x-if="shapeToView?.status">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium"
                                  :class="shapeToView.status.status === 'Active' ? 'bg-green-100 text-green-800' : 
                                          shapeToView.status.status === 'Inactive' ? 'bg-red-100 text-red-800' : 
                                          'bg-yellow-100 text-yellow-800'">
                                <span class="w-2 h-2 rounded-full mr-2"
                                      :class="shapeToView.status.status === 'Active' ? 'bg-green-500' : 
                                              shapeToView.status.status === 'Inactive' ? 'bg-red-500' : 
                                              'bg-yellow-500'"></span>
                                <span x-text="shapeToView.status.status"></span>
                            </span>
                        </template>
                    </div>
                </div>

                <!-- Tabs Content -->
                <div class="lg:col-span-2 flex flex-col overflow-hidden">
                    
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 mb-6 flex-shrink-0">
                        <nav class="flex space-x-8">
                            <button @click="activeTab = 'basic'"
                                :class="activeTab === 'basic' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">info</span>
                                Basic Information
                            </button>
                            <button @click="activeTab = 'dimensions'"
                                :class="activeTab === 'dimensions' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">straighten</span>
                                Dimensions
                            </button>
                            <button @click="activeTab = 'relations'"
                                :class="activeTab === 'relations' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
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
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <!-- Item Code -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">tag</span>
                                        <span class="font-semibold text-gray-700">Item Code</span>
                                    </div>
                                    <p class="text-lg font-mono text-gray-900 break-words" x-text="shapeToView?.item_code || '-'"></p>
                                </div>

                                <!-- Collection -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">collections</span>
                                        <span class="font-semibold text-gray-700">Collection</span>
                                    </div>
                                    <p class="text-gray-900 break-words" x-text="shapeToView?.shape_collection?.collection_code || '-'"></p>
                                </div>
                                <!-- Process -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">precision_manufacturing</span>
                                        <span class="font-semibold text-gray-700">Process</span>
                                    </div>
                                    <p class="text-gray-900 break-words" x-text="shapeToView?.process?.process_name || '-'"></p>
                                </div>
                                <!-- Type -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">category</span>
                                        <span class="font-semibold text-gray-700">Type</span>
                                    </div>
                                    <p class="text-gray-900 break-words" x-text="shapeToView?.shape_type?.name || '-'"></p>
                                </div>
                                <!-- Body -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">texture</span>
                                        <span class="font-semibold text-gray-700">Body</span>
                                    </div>
                                    <p class="text-gray-900 break-words" x-text="shapeToView?.body || '-'"></p>
                                </div>

                                <!-- Approval Date -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">event</span>
                                        <span class="font-semibold text-gray-700">Approval Date</span>
                                    </div>
                                    <p class="text-gray-900" x-text="shapeToView?.approval_date ? new Date(shapeToView.approval_date).toLocaleDateString('th-TH') : '-'"></p>
                                </div>
                                <!-- Description Thai -->
                                <div class="bg-gray-50 rounded-lg p-4 sm:col-span-3">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">translate</span>
                                        <span class="font-semibold text-gray-700">Description (TH)</span>
                                    </div>
                                    <!-- Description Thai -->
                                    <p class="text-gray-900 break-words overflow-wrap-anywhere hyphens-auto" 
                                       x-text="shapeToView?.item_description_thai || '-'"></p>
                                </div>

                                <!-- Description English -->
                                <div class="bg-gray-50 rounded-lg p-4 sm:col-span-3">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">language</span>
                                        <span class="font-semibold text-gray-700">Description (EN)</span>
                                    </div>
                                    <!-- Description English -->  
                                    <p class="text-gray-900 break-words overflow-wrap-anywhere hyphens-auto" 
                                       x-text="shapeToView?.item_description_eng || '-'"></p>
                                </div>
                                <!-- Last Updated Info -->
                                <div class="bg-gray-50 rounded-lg p-4 sm:col-span-3">
                                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                                        <span class="material-symbols-outlined mr-2">history</span>
                                        Update Information
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Last Updated By:</p>
                                            <p class="font-medium break-words" x-text="shapeToView?.updater?.name || 'System'"></p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Updated At:</p>
                                            <p class="font-medium" x-text="shapeToView?.updated_at ? new Date(shapeToView.updated_at).toLocaleString('th-TH') : '-'"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dimensions Tab -->
                        <div x-show="activeTab === 'dimensions'"
                             class="h-full overflow-y-auto overflow-x-hidden">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                                <!-- Volume -->
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">water_drop</span>
                                        <span class="font-semibold text-gray-700">Volume</span>
                                    </div>
                                    <p class="text-2xl font-bold text-blue-700" x-text="(shapeToView?.volume || '0') + ' ml'"></p>
                                </div>

                                <!-- Weight -->
                                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-green-600 mr-2">scale</span>
                                        <span class="font-semibold text-gray-700">Weight</span>
                                    </div>
                                    <p class="text-2xl font-bold text-green-700" x-text="(shapeToView?.weight || '0') + ' g'"></p>
                                </div>

                                <!-- Long Diameter -->
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-purple-600 mr-2">straighten</span>
                                        <span class="font-semibold text-gray-700">Long Diameter</span>
                                    </div>
                                    <p class="text-2xl font-bold text-purple-700" x-text="(shapeToView?.long_diameter || '0') + ' cm'"></p>
                                </div>

                                <!-- Short Diameter -->
                                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-orange-600 mr-2">straighten</span>
                                        <span class="font-semibold text-gray-700">Short Diameter</span>
                                    </div>
                                    <p class="text-2xl font-bold text-orange-700" x-text="(shapeToView?.short_diameter || '0') + ' cm'"></p>
                                </div>

                                <!-- Height Long -->
                                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-red-600 mr-2">height</span>
                                        <span class="font-semibold text-gray-700">Height Long</span>
                                    </div>
                                    <p class="text-2xl font-bold text-red-700" x-text="(shapeToView?.height_long || '0') + ' cm'"></p>
                                </div>

                                <!-- Height Short -->
                                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-4 border border-indigo-200">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-indigo-600 mr-2">height</span>
                                        <span class="font-semibold text-gray-700">Height Short</span>
                                    </div>
                                    <p class="text-2xl font-bold text-indigo-700" x-text="(shapeToView?.height_short || '0') + ' cm'"></p>
                                </div>
                            </div>

                            <!-- Dimensions Visualization -->
                            <div class="bg-gray-50 rounded-lg p-6">
                                <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
                                    <span class="material-symbols-outlined mr-2">3d_rotation</span>
                                    Dimensions Summary
                                </h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <span class="material-symbols-outlined text-blue-600">water_drop</span>
                                        </div>
                                        <p class="font-medium" x-text="(shapeToView?.volume || '0') + ' ml'"></p>
                                        <p class="text-gray-500">Volume</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <span class="material-symbols-outlined text-green-600">scale</span>
                                        </div>
                                        <p class="font-medium" x-text="(shapeToView?.weight || '0') + ' g'"></p>
                                        <p class="text-gray-500">Weight</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <span class="material-symbols-outlined text-purple-600">straighten</span>
                                        </div>
                                        <p class="font-medium" x-text="(shapeToView?.long_diameter || '0') + ' × ' + (shapeToView?.short_diameter || '0') + ' cm'"></p>
                                        <p class="text-gray-500">Diameter</p>
                                    </div>
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                            <span class="material-symbols-outlined text-red-600">height</span>
                                        </div>
                                        <p class="font-medium" x-text="(shapeToView?.height_long || '0') + ' × ' + (shapeToView?.height_short || '0') + ' cm'"></p>
                                        <p class="text-gray-500">Height</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Relations Tab -->
                        <div x-show="activeTab === 'relations'" 
                             class="h-full overflow-y-auto overflow-x-hidden">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                                <!-- Customer -->
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">business</span>
                                        <span class="font-semibold text-gray-700">Customer</span>
                                    </div>
                                    <p class="text-lg font-medium text-blue-800 break-words" x-text="shapeToView?.customer?.name || '-'"></p>
                                </div>

                                <!-- Group -->
                                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-green-600 mr-2">category</span>
                                        <span class="font-semibold text-gray-700">Group</span>
                                    </div>
                                    <p class="text-lg font-medium text-green-800 break-words" x-text="shapeToView?.item_group?.item_group_name || '-'"></p>
                                </div>

                                <!-- Designer -->
                                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-orange-600 mr-2">design_services</span>
                                        <span class="font-semibold text-gray-700">Designer</span>
                                    </div>
                                    <p class="text-lg font-medium text-orange-800 break-words" x-text="shapeToView?.designer?.designer_name || '-'"></p>
                                </div>

                                <!-- Requestor -->
                                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-red-600 mr-2">person</span>
                                        <span class="font-semibold text-gray-700">Requestor</span>
                                    </div>
                                    <p class="text-lg font-medium text-red-800 break-words" x-text="shapeToView?.requestor?.name || '-'"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t flex-shrink-0">
            <div class="text-sm text-gray-500">
                <span class="material-symbols-outlined text-sm mr-1">schedule</span>
                Created: <span x-text="shapeToView?.created_at ? new Date(shapeToView.created_at).toLocaleDateString('th-TH') : '-'"></span>
            </div>
            <button @click="ShapeDetailModal = false"
                class="bg-gray-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg transition-all duration-200 hoverScale">
                <span class="material-symbols-outlined text-sm mr-1 mt-1">close</span>
                Close
            </button>
        </div>
    </div>

    <!-- Zoom Image Modal -->
    <div x-show="zoomImage" x-transition.opacity
         class="fixed inset-0 bg-black bg-opacity-95 flex items-center justify-center z-60"
         @click.self="zoomImage = false">
        <div class="relative max-h-[95vh] max-w-[95vw]">
            <template x-if="shapeToView?.image?.file_path">
                <img :src="`{{ asset('storage') }}/${shapeToView.image.file_path}`" 
                     :alt="shapeToView.item_code"
                     class="max-h-[95vh] max-w-[95vw] object-contain rounded-lg shadow-2xl cursor-zoom-out"
                     @click="zoomImage = false">
            </template>
            <template x-if="!shapeToView?.image?.file_path">
                <div class="bg-white rounded-lg p-8 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4 block">image</span>
                    <p class="text-gray-600">No Image Available</p>
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