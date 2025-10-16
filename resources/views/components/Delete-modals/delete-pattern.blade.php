<!-- Delete pattern Modal -->
<div x-show="DeletePatternModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="DeletePatternModal = false" style="display: none;">
    <div x-show="DeletePatternModal" x-transition
        class="bg-white rounded-xl shadow-xl w-full max-w-md p-6 md:p-8 relative overflow-y-auto max-h-[90vh]">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Confirm Delete</h2>
            <button @click="DeletePatternModal = false" class="text-gray-400 hoverScale hover:text-gray-700 rounded-full p-2">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <hr class="mb-4 border-gray-200">
        <p class="text-gray-700 mb-6">
            Are you sure you want to delete <span class="font-semibold" x-text="itemCodeToDelete"></span>?
        </p>
        <div class="flex justify-end gap-3">
            <button @click="DeletePatternModal = false"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hoverScale hover:bg-gray-300">
                Cancel
            </button>

            <form :action="`/pattern/${patternIdToDelete}`" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hoverScale hover:bg-red-600">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>