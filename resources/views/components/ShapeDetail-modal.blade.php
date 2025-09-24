<!-- Modal Overlay -->
<div x-show="ShapeDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="ShapeDetailModal = false" style="display: none;"
    x-data="{ zoomImage: false }">
    
    <!-- Modal Content -->
    <div class="bg-white rounded-xl shadow-xl w-full max-w-3xl p-6 md:p-8 relative overflow-y-auto max-h-[90vh]">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-800">Shape Details</h2>
            <button @click="ShapeDetailModal = false"
                class="text-gray-400 hover:text-gray-700 rounded-full p-2">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <hr class="mb-6 border-gray-200">

        <!-- Image Section -->
        <div class="mb-6">
            <img src="https://decorahome.com/cdn/shop/files/IMG_5898_2000x.jpg?v=1692719856" 
                 alt="Shape Image"
                 class="rounded-lg shadow cursor-zoom-in mx-auto max-h-64 object-contain"
                 @click="zoomImage = true">
            <p class="text-sm text-gray-500 text-center mt-2">Click image to zoom</p>
        </div>

        <!-- Detail Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm md:text-base">
            <p><span class="font-semibold text-gray-700">ITEM CODE:</span> ABC123</p>
            <p><span class="font-semibold text-gray-700">Description TH:</span> ชามเล็ก</p>
            <p><span class="font-semibold text-gray-700">Description EN:</span> Small Bowl</p>
            <p><span class="font-semibold text-gray-700">TYPE:</span> Ceramic</p>
            <p><span class="font-semibold text-gray-700">STATUS:</span>
                <span class="inline-block px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
            </p>
            <p><span class="font-semibold text-gray-700">COLLECTION:</span> Classic</p>
            <p><span class="font-semibold text-gray-700">CUSTOMER:</span> Acme Corp</p>
            <p><span class="font-semibold text-gray-700">GROUP:</span> Kitchenware</p>
            <p><span class="font-semibold text-gray-700">PROCESS:</span> Hand-made</p>
            <p><span class="font-semibold text-gray-700">DESIGNER:</span> John Doe</p>
            <p><span class="font-semibold text-gray-700">VOLUME:</span> 250ml</p>
            <p><span class="font-semibold text-gray-700">WEIGHT:</span> 180g</p>
            <p><span class="font-semibold text-gray-700">LONG DIAMETER:</span> 12cm</p>
            <p><span class="font-semibold text-gray-700">SHORT DIAMETER:</span> 10cm</p>
            <p><span class="font-semibold text-gray-700">HEIGHT LONG:</span> 8cm</p>
            <p><span class="font-semibold text-gray-700">HEIGHT SHORT:</span> 7cm</p>
            <p><span class="font-semibold text-gray-700">BODY:</span> Porcelain</p>
            <p><span class="font-semibold text-gray-700">REQUESTOR:</span> Alice</p>
            <p><span class="font-semibold text-gray-700">APPROVAL DATE:</span> 2025-09-15</p>
        </div>

        <!-- Back Button -->
        <div class="mt-6 flex justify-end">
            <button @click="ShapeDetailModal = false"
                class="bg-gray-200  py-2 px-4 rounded-lg hoverScale hover:bg-red-500 hover:text-white">
                Back
            </button>
        </div>
    </div>

    <!-- Zoom Image Modal -->
    <div x-show="zoomImage" x-transition.opacity
         class="fixed inset-0 bg-black bg-opacity-90 flex items-center justify-center z-50"
         @click.self="zoomImage = false">
        <img src="https://decorahome.com/cdn/shop/files/IMG_5898_2000x.jpg?v=1692719856" 
             alt="Zoomed Image"
             class="max-h-[90vh] max-w-[90vw] object-contain rounded-lg shadow-2xl cursor-zoom-out"
             @click="zoomImage = false">
    </div>
</div>
