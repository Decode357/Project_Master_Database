<!-- Modal Overlay -->
<div x-show="ProductPriceDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="ProductPriceDetailModal = false" style="display: none;"
    x-data="{ zoomImage: false, activeTab: 'basic' }">
    
    <!-- Modal Content -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-hidden h-[90vh] flex flex-col">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 flex justify-between items-center flex-shrink-0">
            <div>
                <h2 class="text-2xl font-bold" x-text="productPriceToView?.item_code || 'Product Price Details'"></h2>
                <p class="text-blue-100 text-sm mt-1" x-text="productPriceToView?.item_description_eng || 'Product Price Details'"></p>
            </div>
            <button @click="ProductPriceDetailModal = false"
                class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <!-- Body -->

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t flex-shrink-0">
            <div class="text-sm text-gray-500">
                <span class="material-symbols-outlined text-sm mr-1">schedule</span>
                Created: <span x-text="productPriceToView?.created_at ? new Date(productPriceToView.created_at).toLocaleDateString('th-TH') : '-'"></span>
            </div>
            <button @click="ProductPriceDetailModal = false"
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
            <template x-if="productPriceToView?.image?.file_path">
                <img :src="`{{ asset('storage') }}/${productPriceToView.image.file_path}`" 
                     :alt="productPriceToView.item_code"
                     class="max-h-[95vh] max-w-[95vw] object-contain rounded-lg shadow-2xl cursor-zoom-out"
                     @click="zoomImage = false">
            </template>
            <template x-if="!productPriceToView?.image?.file_path">
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