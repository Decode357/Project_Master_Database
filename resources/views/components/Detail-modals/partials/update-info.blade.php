<!-- Last Updated Info -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
    <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-3 flex items-center">
        <span class="material-symbols-outlined mr-2">history</span>
        {{ __('content.update_information') }}
    </h4>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
        <div>
            <p class="text-gray-600 dark:text-gray-400">{{ __('content.update_by') }}:</p>
            <p class="font-medium text-gray-900 dark:text-gray-100 break-words" x-text="{{ $item }}?.updater?.name || 'System'"></p>
        </div>
        <div>
            <p class="text-gray-600 dark:text-gray-400">{{ __('content.update_at') }}:</p>
            <p class="font-medium text-gray-900 dark:text-gray-100" x-text="{{ $item }}?.updated_at ? new Date({{ $item }}.updated_at).toLocaleString('th-TH') : '-'"></p>
        </div>
    </div>
</div>