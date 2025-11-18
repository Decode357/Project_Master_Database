@props(['route', 'icon', 'label', 'isChild' => false])

<a href="{{ route($route) }}"
    class="flex items-center gap-3 rounded-md px-{{ $isChild ? '2' : '3' }} py-2 text-sm font-medium {{ $isChild ? 'ml-6' : '' }}
    {{ request()->routeIs($route) 
        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-105' 
        : ($isChild 
            ? 'text-gray-600 dark:text-gray-400 hoverScale hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700'
            : 'text-gray-700 dark:text-gray-300 hoverScale hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-100') }}">
    
    @if($isChild)
        <span class="w-0.5 h-4 bg-gray-300 dark:bg-gray-600 rounded"></span>
    @endif
    
    <span class="material-symbols-outlined text-{{ $isChild ? 'base' : 'lg' }}">{{ $icon }}</span>
    <span>{{ $label }}</span>
</a>