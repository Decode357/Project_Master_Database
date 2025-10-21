<!-- Delete effect Modal -->
<div x-show="DeleteEffectModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="DeleteEffectModal = false" style="display: none;">
    <div x-show="DeleteEffectModal" x-transition
        class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md p-6 md:p-8 relative overflow-y-auto max-h-[90vh]">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Confirm Delete</h2>
            <button @click="DeleteEffectModal = false" class="text-gray-400 dark:text-gray-500 hoverScale hover:text-gray-700 dark:hover:text-gray-300 rounded-full p-2">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <hr class="mb-4 border-gray-200 dark:border-gray-600">
        <p class="text-gray-700 dark:text-gray-300 mb-6">
            Are you sure you want to delete <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="itemCodeToDelete"></span>?
        </p>
        <div class="flex justify-end gap-3">
            <button @click="DeleteEffectModal = false"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hoverScale hover:bg-gray-300 dark:hover:bg-gray-500">
                Cancel
            </button>
            <form :action="`/effect/${effectIdToDelete}`" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 dark:bg-red-600 text-white rounded-lg hoverScale hover:bg-red-600 dark:hover:bg-red-700">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>