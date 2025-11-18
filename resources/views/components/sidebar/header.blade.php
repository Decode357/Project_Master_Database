@php
    $userPermissions = Auth::user()->permissions->pluck('name')->toArray();
    $permissionLabel = __('auth.user') . ' : ' . __('auth.view_only');

    if (Auth::user()->hasRole('admin')) {
        $translatedPermissions = array_map(fn($perm) => __('auth.' . $perm), $userPermissions);
        $permissionLabel = __('auth.admin') . ' : ' . implode(', ', $translatedPermissions);
    } elseif (Auth::user()->hasRole('superadmin')) {
        $permissionLabel = __('auth.superadmin') . ' : ' . __('auth.all_permissions');
    }
@endphp

<header class="flex top-0 right-0 h-16 bg-white dark:bg-gray-800 shadow-md items-center justify-between px-6 z-30"
        :class="headerClass">
    <div class="flex items-center gap-4">
        <button @click="toggleSidebar()"
            class="rounded-full p-2 text-gray-500 dark:text-gray-400 hoverScale hover:text-gray-700 dark:hover:text-gray-200 md:hidden">
            <span class="material-symbols-outlined">menu</span>
        </button>
        <h2>
            <span class="text-xl font-semibold text-gray-900 dark:text-gray-100">@yield('header', 'Title')</span>
            <span class="text-gray-500 dark:text-gray-400">| {{ $permissionLabel }}</span>
        </h2>
    </div>
    
    <div class="flex items-center gap-2 flex-row">
        <button @click="toggleLanguage()" 
            class="flex items-center justify-center rounded-lg bg-gray-200 dark:bg-gray-600 px-3 py-2
                    text-gray-600 dark:text-gray-300 hoverScale hover:bg-gray-300 dark:hover:bg-gray-500">
            <span class="material-symbols-outlined mr-1">language</span>
            <span x-text="'{{ __('sidebar.language') }}'"></span>
        </button>                    
        <button @click="toggleTheme()"
            class="flex items-center justify-center rounded-lg bg-gray-200 dark:bg-gray-600 px-3 py-2
                    text-gray-600 dark:text-gray-300 hoverScale hover:bg-gray-300 dark:hover:bg-gray-500">
            <span class="material-symbols-outlined" x-text="themeIcon"></span>
        </button>
    </div>
</header>