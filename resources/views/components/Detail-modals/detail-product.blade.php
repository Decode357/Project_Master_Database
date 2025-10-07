<!-- Modal Overlay -->
<div x-show="ProductDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="ProductDetailModal = false" style="display: none;"
    x-data="{ zoomImage: false, activeTab: 'basic' }">
    
    <!-- Modal Content -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-hidden h-[90vh] flex flex-col">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 flex justify-between items-center flex-shrink-0">
            <div>
                <h2 class="text-2xl font-bold" x-text="productToView?.product_sku || 'Product Details'"></h2>
                <p class="text-blue-100 text-sm mt-1" x-text="productToView?.product_name || 'Product Details'"></p>
            </div>
            <button @click="ProductDetailModal = false"
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
                        <template x-if="productToView?.image?.file_path">
                            <img :src="`{{ asset('storage') }}/${productToView.image.file_path}`" 
                                 :alt="productToView.product_sku"
                                 class="rounded-lg shadow-lg cursor-zoom-in mx-auto h-48 object-contain w-full"
                                 @click="zoomImage = true">
                        </template>
                        <template x-if="!productToView?.image?.file_path">
                            <div class="bg-gray-200 rounded-lg flex items-center justify-center h-48">
                                <div class="text-center text-gray-500">
                                    <span class="material-symbols-outlined text-6xl mb-2 block">inventory_2</span>
                                    <p>No Image Available</p>
                                </div>
                            </div>
                        </template>
                        <p class="text-sm text-gray-500 mt-3">
                            <span class="material-symbols-outlined text-lg align-middle">zoom_in</span>
                            Click to zoom
                        </p>
                    </div>
                    <!-- debug JSON output -->
                    {{-- <div class="mt-4 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100 overflow-y-auto max-h-[40vh]">
                        <pre x-text="JSON.stringify(productToView, null, 2)"></pre>
                    </div> --}}
                    <!-- Status Badge -->
                    <div class="mt-4 text-center flex-shrink-0">
                        <template x-if="productToView?.status">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium"
                                  :class="productToView.status.status === 'Active' ? 'bg-green-100 text-green-800' : 
                                          productToView.status.status === 'Inactive' ? 'bg-red-100 text-red-800' : 
                                          'bg-yellow-100 text-yellow-800'">
                                <span class="w-2 h-2 rounded-full mr-2"
                                      :class="productToView.status.status === 'Active' ? 'bg-green-500' : 
                                              productToView.status.status === 'Inactive' ? 'bg-red-500' : 
                                              'bg-yellow-500'"></span>
                                <span x-text="productToView.status.status"></span>
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
                            <button @click="activeTab = 'components'"
                                :class="activeTab === 'components' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">widgets</span>
                                Components
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content Container -->
                    <div class="flex-1 min-h-0">
                        <!-- Basic Information Tab -->
                        <div x-show="activeTab === 'basic'" 
                             class="h-full overflow-y-auto overflow-x-hidden">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Product SKU -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">tag</span>
                                        <span class="font-semibold text-gray-700">Product SKU</span>
                                    </div>
                                    <p class="text-lg font-mono text-gray-900 break-words" x-text="productToView?.product_sku || '-'"></p>
                                </div>

                                <!-- Product Name -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">label</span>
                                        <span class="font-semibold text-gray-700">Product Name</span>
                                    </div>
                                    <p class="text-lg text-gray-900 break-words" x-text="productToView?.product_name || '-'"></p>
                                </div>

                                <!-- Category -->
                                <div class="bg-gray-50 rounded-lg p-4 sm:col-span-2">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">category</span>
                                        <span class="font-semibold text-gray-700">Category</span>
                                    </div>
                                    <p class="text-gray-900 break-words" x-text="productToView?.category?.category_name || '-'"></p>
                                </div>
                                <!-- Component Summary -->
                                <div class="bg-gray-50 rounded-lg p-6 sm:col-span-2">
                                    <h4 class="font-semibold text-gray-700 mb-4 flex items-center">
                                        <span class="material-symbols-outlined mr-2">summarize</span>
                                        Component Summary
                                    </h4>
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                        <div class="text-center ">
                                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                                <span class="material-symbols-outlined text-blue-600 text-lg">shapes</span>
                                            </div>
                                            <p class="font-medium text-xs" x-text="productToView?.shape?.item_code || 'None'"></p>
                                            <p class="text-gray-500 text-xs">Shape</p>
                                        </div>
                                        <div class="text-center">
                                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                                <span class="material-symbols-outlined text-green-600 text-lg">water_drop</span>
                                            </div>
                                            <p class="font-medium text-xs" x-text="productToView?.glaze?.glaze_code || 'None'"></p>
                                            <p class="text-gray-500 text-xs">Glaze</p>
                                        </div>
                                        <div class="text-center">
                                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                                <span class="material-symbols-outlined text-purple-600 text-lg">border_color</span>
                                            </div>
                                            <p class="font-medium text-xs" x-text="productToView?.pattern?.pattern_code || 'None'"></p>
                                            <p class="text-gray-500 text-xs">Pattern</p>
                                        </div>
                                        <div class="text-center">
                                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                                <span class="material-symbols-outlined text-orange-600 text-lg">verified</span>
                                            </div>
                                            <p class="font-medium text-xs" x-text="productToView?.backstamp?.backstamp_code || 'None'"></p>
                                            <p class="text-gray-500 text-xs">Backstamp</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Update Information -->
                                <div class="bg-gray-50 rounded-lg p-4 sm:col-span-2">
                                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                                        <span class="material-symbols-outlined mr-2">history</span>
                                        Update Information
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Last Updated By:</p>
                                            <p class="font-medium break-words" x-text="productToView?.updater?.name || 'System'"></p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Updated At:</p>
                                            <p class="font-medium" x-text="productToView?.updated_at ? new Date(productToView.updated_at).toLocaleString('th-TH') : '-'"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Components Tab -->
                        <div x-show="activeTab === 'components'"
                             class="h-full overflow-y-auto overflow-x-hidden">
                            <div class="space-y-6">
        
                                <!-- Shape Component - Detailed -->
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
                                    <div class="flex items-center mb-4">
                                        <span class="material-symbols-outlined text-blue-600 mr-2 text-xl">shapes</span>
                                        <span class="font-bold text-gray-800 text-xl">Shape Details</span>
                                    </div>
                                    
                                    <template x-if="productToView?.shape">
                                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                            <!-- Shape Information -->
                                            <div class="lg:col-span-3 space-y-4">
                                                <!-- Basic Info Row -->
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                                    <div class="bg-white/70 rounded-lg p-3">
                                                        <p class="text-xs font-medium text-blue-700 mb-1">Item Code</p>
                                                        <p class="text-lg font-bold text-blue-900" x-text="productToView.shape.item_code"></p>
                                                    </div>
                                                    <div class="bg-white/70 rounded-lg p-3">
                                                        <p class="text-xs font-medium text-blue-700 mb-1">Type</p>
                                                        <p class="text-sm font-medium text-blue-800" x-text="productToView.shape.shape_type?.name || 'N/A'"></p>
                                                    </div>
                                                    <div class="bg-white/70 rounded-lg p-3">
                                                        <p class="text-xs font-medium text-blue-700 mb-1">Body</p>
                                                        <p class="text-sm font-medium text-blue-800" x-text="productToView.shape.body || 'N/A'"></p>
                                                    </div>
                                                </div>

                                                <!-- Dimensions Row -->
                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                                    <template x-if="productToView.shape.volume">
                                                        <div class="bg-white/70 rounded-lg p-3 text-center">
                                                            <p class="text-xs font-medium text-blue-700 mb-1">Volume</p>
                                                            <p class="text-lg font-bold text-blue-900" x-text="productToView.shape.volume + ' ml'"></p>
                                                        </div>
                                                    </template>
                                                    <template x-if="productToView.shape.weight">
                                                        <div class="bg-white/70 rounded-lg p-3 text-center">
                                                            <p class="text-xs font-medium text-blue-700 mb-1">Weight</p>
                                                            <p class="text-lg font-bold text-blue-900" x-text="productToView.shape.weight + ' g'"></p>
                                                        </div>
                                                    </template>
                                                    <template x-if="productToView.shape.long_diameter">
                                                        <div class="bg-white/70 rounded-lg p-3 text-center">
                                                            <p class="text-xs font-medium text-blue-700 mb-1">Long Ø</p>
                                                            <p class="text-sm font-semibold text-blue-900" x-text="productToView.shape.long_diameter + ' cm'"></p>
                                                        </div>
                                                    </template>
                                                    <template x-if="productToView.shape.short_diameter">
                                                        <div class="bg-white/70 rounded-lg p-3 text-center">
                                                            <p class="text-xs font-medium text-blue-700 mb-1">Short Ø</p>
                                                            <p class="text-sm font-semibold text-blue-900" x-text="productToView.shape.short_diameter + ' cm'"></p>
                                                        </div>
                                                    </template>
                                                </div>

                                                <!-- Description -->
                                                <div class="bg-white/70 rounded-lg p-3">
                                                    <p class="text-xs font-medium text-blue-700 mb-2">Description</p>
                                                    <p class="text-sm text-blue-800 leading-relaxed" x-text="productToView.shape.item_description_eng || 'No description available'"></p>
                                                    <template x-if="productToView.shape.item_description_thai">
                                                        <p class="text-sm text-blue-700 mt-2 italic" x-text="productToView.shape.item_description_thai"></p>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                    
                                    <template x-if="!productToView?.shape">
                                        <div class="text-center py-8">
                                            <span class="material-symbols-outlined text-gray-300 text-4xl mb-2 block">shapes</span>
                                            <p class="text-gray-500 font-medium">No shape assigned</p>
                                            <p class="text-gray-400 text-sm">This product doesn't have a shape component</p>
                                        </div>
                                    </template>
                                </div>

                                <!-- Glaze Component - Detailed -->
                                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
                                    <div class="flex items-center mb-4">
                                        <span class="material-symbols-outlined text-green-600 mr-2 text-xl">water_drop</span>
                                        <span class="font-bold text-gray-800 text-xl">Glaze Details</span>
                                    </div>
                                    
                                    <template x-if="productToView?.glaze">
                                        <div class="space-y-4">
                                            <!-- Glaze Basic Info -->
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div class="bg-white/70 rounded-lg p-3">
                                                    <p class="text-xs font-medium text-green-700 mb-1">Glaze Code</p>
                                                    <p class="text-lg font-bold text-green-900" x-text="productToView.glaze.glaze_code"></p>
                                                </div>
                                                <div class="bg-white/70 rounded-lg p-3">
                                                    <p class="text-xs font-medium text-green-700 mb-1">Fire Temperature</p>
                                                    <p class="text-lg font-semibold text-green-900" x-text="productToView.glaze.fire_temp ? productToView.glaze.fire_temp + '°C' : 'N/A'"></p>
                                                </div>
                                                <div class="bg-white/70 rounded-lg p-3">
                                                    <p class="text-xs font-medium text-green-700 mb-1">Status</p>
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                                          :class="productToView.glaze.status?.status === 'Active' ? 'bg-green-100 text-green-800' : 
                                                                  productToView.glaze.status?.status === 'Inactive' ? 'bg-red-100 text-red-800' : 
                                                                  'bg-yellow-100 text-yellow-800'">
                                                        <span x-text="productToView.glaze.status?.status || 'Unknown'"></span>
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- Effect Colors -->
                                            <template x-if="productToView.glaze.effect?.colors && productToView.glaze.effect.colors.length > 0">
                                                <div class="bg-white/70 rounded-lg p-4">
                                                    <div class="flex items-center mb-3">
                                                        <span class="material-symbols-outlined text-purple-600 mr-2">auto_fix_high</span>
                                                        <span class="font-semibold text-gray-700">Effect Colors</span>
                                                        <span class="ml-2 text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full" x-text="productToView.glaze.effect.effect_name"></span>
                                                    </div>
                                                    <div class="flex flex-wrap gap-2">
                                                        <template x-for="color in productToView.glaze.effect.colors" :key="color.id">
                                                            <div class="flex items-center bg-white px-3 py-2 rounded-lg border">
                                                                <span class="w-4 h-4 rounded-full mr-2 border border-gray-300"
                                                                      :style="'background-color: ' + (color.color_code || '#8B5CF6')"></span>
                                                                <span class="text-sm font-medium" x-text="color.color_name"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            <!-- Inside Glaze Colors -->
                                            <template x-if="productToView.glaze.glaze_inside?.colors && productToView.glaze.glaze_inside.colors.length > 0">
                                                <div class="bg-white/70 rounded-lg p-4">
                                                    <div class="flex items-center mb-3">
                                                        <span class="material-symbols-outlined text-cyan-600 mr-2">layers</span>
                                                        <span class="font-semibold text-gray-700">Inside Glaze Colors</span>
                                                        <span class="ml-2 text-xs bg-cyan-100 text-cyan-800 px-2 py-1 rounded-full" x-text="productToView.glaze.glaze_inside.glaze_inside_code"></span>
                                                    </div>
                                                    <div class="flex flex-wrap gap-2">
                                                        <template x-for="color in productToView.glaze.glaze_inside.colors" :key="color.id">
                                                            <div class="flex items-center bg-white px-3 py-2 rounded-lg border">
                                                                <span class="w-4 h-4 rounded-full mr-2 border border-gray-300"
                                                                      :style="'background-color: ' + (color.color_code || '#06B6D4')"></span>
                                                                <span class="text-sm font-medium" x-text="color.color_name"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            <!-- Outer Glaze Colors -->
                                            <template x-if="productToView.glaze.glaze_outer?.colors && productToView.glaze.glaze_outer.colors.length > 0">
                                                <div class="bg-white/70 rounded-lg p-4">
                                                    <div class="flex items-center mb-3">
                                                        <span class="material-symbols-outlined text-amber-600 mr-2">format_paint</span>
                                                        <span class="font-semibold text-gray-700">Outer Glaze Colors</span>
                                                        <span class="ml-2 text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded-full" x-text="productToView.glaze.glaze_outer.glaze_outer_code"></span>
                                                    </div>
                                                    <div class="flex flex-wrap gap-2">
                                                        <template x-for="color in productToView.glaze.glaze_outer.colors" :key="color.id">
                                                            <div class="flex items-center bg-white px-3 py-2 rounded-lg border">
                                                                <span class="w-4 h-4 rounded-full mr-2 border border-gray-300"
                                                                      :style="'background-color: ' + (color.color_code || '#F59E0B')"></span>
                                                                <span class="text-sm font-medium" x-text="color.color_name"></span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                    
                                    <template x-if="!productToView?.glaze">
                                        <div class="text-center py-8">
                                            <span class="material-symbols-outlined text-gray-300 text-4xl mb-2 block">water_drop</span>
                                            <p class="text-gray-500 font-medium">No glaze assigned</p>
                                            <p class="text-gray-400 text-sm">This product doesn't have a glaze component</p>
                                        </div>
                                    </template>
                                </div>

                                <!-- Pattern Component - Simple -->
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-purple-600 mr-2">border_color</span>
                                        <span class="font-semibold text-gray-700 text-lg">Pattern</span>
                                    </div>
                                    <template x-if="productToView?.pattern">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="bg-white/70 rounded-lg p-3">
                                                <p class="text-xs font-medium text-purple-700 mb-1">Pattern Code</p>
                                                <p class="text-lg font-medium text-purple-800" x-text="productToView.pattern.pattern_code"></p>
                                            </div>
                                            <div class="bg-white/70 rounded-lg p-3">
                                                <p class="text-xs font-medium text-purple-700 mb-1">Pattern Name</p>
                                                <p class="text-sm text-purple-800" x-text="productToView.pattern.pattern_name"></p>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="!productToView?.pattern">
                                        <p class="text-gray-500 text-center py-4">No pattern assigned</p>
                                    </template>
                                </div>

                                <!-- Backstamp Component - Simple -->
                                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200 mb-8">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-orange-600 mr-2">verified</span>
                                        <span class="font-semibold text-gray-700 text-lg">Backstamp</span>
                                    </div>
                                    <template x-if="productToView?.backstamp">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="bg-white/70 rounded-lg p-3">
                                                <p class="text-xs font-medium text-orange-700 mb-1">Backstamp Code</p>
                                                <p class="text-lg font-medium text-orange-800" x-text="productToView.backstamp.backstamp_code"></p>
                                            </div>
                                            <div class="bg-white/70 rounded-lg p-3">
                                                <p class="text-xs font-medium text-orange-700 mb-1">Name</p>
                                                <p class="text-sm text-orange-800" x-text="productToView.backstamp.name || 'N/A'"></p>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="!productToView?.backstamp">
                                        <p class="text-gray-500 text-center py-4">No backstamp assigned</p>
                                    </template>
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
                Created: <span x-text="productToView?.created_at ? new Date(productToView.created_at).toLocaleDateString('th-TH') : '-'"></span>
            </div>
            <button @click="ProductDetailModal = false"
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
            <template x-if="productToView?.image?.file_path">
                <img :src="`{{ asset('storage') }}/${productToView.image.file_path}`" 
                     :alt="productToView.product_sku"
                     class="max-h-[95vh] max-w-[95vw] object-contain rounded-lg shadow-2xl cursor-zoom-out"
                     @click="zoomImage = false">
            </template>
            <template x-if="!productToView?.image?.file_path">
                <div class="bg-white rounded-lg p-8 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4 block">inventory_2</span>
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