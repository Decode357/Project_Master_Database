<!-- Modal Overlay -->
<div x-show="ProductPriceDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="ProductPriceDetailModal = false" style="display: none;"
    x-data="{ zoomImage: false }">

    <!-- Modal Content -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 relative overflow-hidden flex flex-col">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold">Product Price Details</h2>
                <p class="text-blue-100 text-sm mt-1" x-text="productPriceToView?.price_tier + ' (' + productPriceToView?.currency + ')'"></p>
            </div>
            <button @click="ProductPriceDetailModal = false"
                class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <span class="material-symbols-outlined text-green-600 mr-2">attach_money</span>
                        <span class="font-semibold text-gray-700">Price</span>
                    </div>
                    <p class="text-2xl font-bold text-green-700" x-text="Number(productPriceToView?.price).toLocaleString('en-US', {minimumFractionDigits:2}) + ' ' + (productPriceToView?.currency || '')"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <span class="material-symbols-outlined text-blue-600 mr-2">sell</span>
                        <span class="font-semibold text-gray-700">Tier</span>
                    </div>
                    <p class="text-lg font-medium text-blue-800" x-text="productPriceToView?.price_tier || '-'"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <span class="material-symbols-outlined text-amber-600 mr-2">event</span>
                        <span class="font-semibold text-gray-700">Effective Date</span>
                    </div>
                    <p class="text-gray-900" x-text="productPriceToView?.effective_date ? new Date(productPriceToView.effective_date).toLocaleDateString('th-TH') : '-'"></p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-center mb-2">
                        <span class="material-symbols-outlined text-gray-600 mr-2">inventory_2</span>
                        <span class="font-semibold text-gray-700">Product</span>
                    </div>
                    <p class="text-gray-900" x-text="productPriceToView?.product?.product_sku || '-'"></p>
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <h4 class="font-semibold text-gray-700 mb-2 flex items-center">
                    <span class="material-symbols-outlined mr-2">history</span>
                    Update Information
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Created By:</p>
                        <p class="font-medium break-words" x-text="productPriceToView?.creator?.name || '-'"></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Updated By:</p>
                        <p class="font-medium break-words" x-text="productPriceToView?.updater?.name || '-'"></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Created At:</p>
                        <p class="font-medium" x-text="productPriceToView?.created_at ? new Date(productPriceToView.created_at).toLocaleString('th-TH') : '-'"></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Updated At:</p>
                        <p class="font-medium" x-text="productPriceToView?.updated_at ? new Date(productPriceToView.updated_at).toLocaleString('th-TH') : '-'"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 flex justify-end items-center border-t">
            <button @click="ProductPriceDetailModal = false"
                class="bg-gray-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg transition-all duration-200 hoverScale">
                <span class="material-symbols-outlined text-sm mr-1 mt-1">close</span>
                Close
            </button>
        </div>
    </div>
</div>