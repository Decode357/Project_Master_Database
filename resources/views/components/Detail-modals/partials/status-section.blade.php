<!-- Status & Process Badge -->
<div class="my-2 flex justify-center items-center gap-6 border border-gray-200 dark:border-gray-600 rounded-lg p-2">
    <!-- Status -->
    <template x-if="{{ $item }}?.status">
        <div class="flex flex-col items-center">
            <label class="text-gray-700 dark:text-gray-300 font-semibold mb-1">{{ __('content.status') }}</label>
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium"
                :class="{
                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': {{ $item }}.status.status === 'Active',
                    'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300': {{ $item }}.status.status === 'Cancel',
                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300': {{ $item }}.status.status !== 'Active' && {{ $item }}.status.status !== 'Cancel'
                }">
                <span class="w-2 h-2 rounded-full mr-2"
                    :class="{
                        'bg-green-500': {{ $item }}.status.status === 'Active',
                        'bg-red-500': {{ $item }}.status.status === 'Cancel',
                        'bg-yellow-500': {{ $item }}.status.status !== 'Active' && {{ $item }}.status.status !== 'Cancel'
                    }"></span>
                <span x-text="{{ $item }}.status.status"></span>
            </span>
        </div>
    </template>

    @if($showProcess ?? false)
    <!-- Process -->
    <template x-if="{{ $item }}?.process">
        <div class="flex flex-col items-center">
            <label class="text-gray-700 dark:text-gray-300 font-semibold mb-1">{{ __('content.process') }}</label>
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                <span class="w-2 h-2 rounded-full mr-2 bg-blue-500"></span>
                <span x-text="{{ $item }}.process.process_name"></span>
            </span>
        </div>
    </template>
    @endif
</div>