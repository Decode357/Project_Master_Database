<!-- Edit Product Modal -->
<div id="EditProductModal" 
     x-show="EditProductModal" 
     x-transition.opacity
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
     style="display: none;">

     <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Edit Product</h2>
        <hr class="mb-3">
        <!-- Form Content -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditProductModal = false; errors = {}" class="px-4 py-2 rounded-md bg-gray-200 hoverScale hover:bg-red-500 hover:text-white">Cancel</button>
            </div>
        <!--end Form Content -->
    </div>
</div>