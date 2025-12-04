<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Title'))</title>
    <link rel="icon" type="image/jpg" href="{{ asset('images/PatraIcon2.jpg') }}">

    <style>
        [x-cloak] { display: none !important; }
        .sidebar-hidden { transform: translateX(-100%); }
        .sidebar-visible { transform: translateX(0); }
        @media (min-width: 768px) {
            .sidebar-hidden { transform: translateX(0); }
        }
        .dark { color-scheme: dark; }
        .dark .bg-white { @apply bg-gray-800; }
        .dark .text-gray-900 { @apply text-gray-100; }
        .dark .text-gray-700 { @apply text-gray-300; }
        .dark .text-gray-500 { @apply text-gray-400; }
        .dark .border-gray-200 { @apply border-gray-700; }
        .dark .bg-gray-50 { @apply bg-gray-900; }
        .dark .bg-gray-100 { @apply bg-gray-700; }
        .dark .shadow-md { @apply shadow-gray-900/50; }
        .dark .shadow-xl { @apply shadow-gray-900/50; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900" 
    x-data="sidebarManager()" 
    x-cloak 
    style='font-family: "Public Sans", "Noto Sans", sans-serif;'>

    <!-- Overlay -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" 
        x-show="sidebarOpen" 
        x-transition.opacity
        @click="sidebarOpen = false" 
        style="display: none;">
    </div>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 w-64 flex-col border-r border-gray-200 dark:border-gray-700 
                    bg-white dark:bg-gray-800 shadow-xl
                    transform ease-in-out md:static md:flex md:z-auto"
            :class="sidebarClass" x-cloak>
            
            <x-sidebar.logo />
            <x-sidebar.navigation />
            <x-sidebar.user-info />
        </aside>

        <!-- Main content area -->
        <main class="flex-1 flex flex-col w-full md:ml-0">
            <x-sidebar.header />
            
            <section class="flex-1 p-3 overflow-y-auto ml-0 md:ml-0">
                <div>
                    @yield('content')
                </div>
            </section>
        </main>
    </div>

    
    <!-- Your Scripts -->
    <script src="{{ asset('js/sidebar-manager.js') }}"></script>
    <script src="{{ asset('js/modals/modal-common.js') }}"></script>
    <script src="{{ asset('js/language-manager.js') }}"></script>
    <script src="{{ asset('js/theme-manager.js') }}"></script>
    <script src="{{ asset('js/pages/shape-page.js') }}"></script>
    <script src="{{ asset('js/pages/pattern-page.js') }}"></script>
    <script src="{{ asset('js/pages/backstamp-page.js') }}"></script>
    <script src="{{ asset('js/pages/glaze-page.js') }}"></script>
    <script src="{{ asset('js/pages/color-page.js') }}"></script>
    <script src="{{ asset('js/pages/effect-page.js') }}"></script>
    <script src="{{ asset('js/pages/user-page.js') }}"></script>
    <script src="{{ asset('js/pages/glazeInsideOuter-page.js') }}"></script>
    <script src="{{ asset('js/pages/shapeCollection.blade-page.js') }}"></script>
    <script src="{{ asset('js/pages/customer-page.js') }}"></script>
    <script src="{{ asset('js/pages/itemGroup-page.js') }}"></script>
</body>
</html>