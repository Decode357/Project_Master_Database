<!-- Footer -->
<div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 flex justify-between items-center border-t border-gray-200 dark:border-gray-600 flex-shrink-0 rounded-b-2xl">
    <div class="text-sm text-gray-500 dark:text-gray-400">
        <span class="material-symbols-outlined text-base align-middle">info</span>
        <span class="ml-1">{{ __('content.created_at') }}:</span>
        <span class="font-medium" x-text="{{ $item }}?.created_at ? new Date({{ $item }}.created_at).toLocaleDateString('th-TH') : '-'"></span>
    </div>
</div>