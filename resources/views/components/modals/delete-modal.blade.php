@props([
    'show' => 'DeleteModal',
    'itemName' => 'itemCodeToDelete',
    'deleteFunction' => 'deleteItem',
    'title' => __('content.confirm_delete'),
])

<div x-show="{{ $show }}" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="{{ $show }} = false" style="display: none;">
    <div x-show="{{ $show }}" x-transition
        class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md p-6 md:p-8 relative overflow-y-auto max-h-[90vh]">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100">{{ $title }}</h2>
            <button @click="{{ $show }} = false" 
                class="text-gray-400 dark:text-gray-500 hoverScale hover:text-gray-700 dark:hover:text-gray-300 rounded-full p-2">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <hr class="mb-4 border-gray-200 dark:border-gray-600">
        <p class="text-gray-700 dark:text-gray-300 mb-6">
            {{ __('content.confirm_delete_message') }}
            <span class="font-semibold text-gray-900 dark:text-gray-100" x-text="{{ $itemName }}"></span>
        </p>
        <div class="flex justify-end gap-3">
            <button @click="{{ $show }} = false"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hoverScale hover:bg-gray-300 dark:hover:bg-gray-500">
                Cancel
            </button>
            <button type="button" @click="$event.target.disabled = true; {{ $deleteFunction }}()"
                class="px-4 py-2 rounded-md bg-red-600 text-white hoverScale hover:bg-red-700">
                Delete
            </button>
        </div>
    </div>
</div>