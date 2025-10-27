<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Title'))</title>

    <link as="style"
        href="https://fonts.googleapis.com/css2?display=swap&family=Noto+Sans:wght@400;500;700;900&family=Public+Sans:wght@400;500;700;900"
        onload="this.rel='stylesheet'" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <!-- Theme CSS -->
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

    <!-- Sidebar -->
    <div class="flex h-screen overflow-hidden">
        <aside class="fixed inset-y-0 left-0 z-50 w-64 flex-col border-r border-gray-200 dark:border-gray-700 
                    bg-white dark:bg-gray-800 shadow-xl
                    transform ease-in-out md:static md:flex md:z-auto"
            :class="sidebarClass"   
            x-cloak>
            <div class="mb-2">
                <div class="bg-white p-2 inline-block shadow-sm">
                    <img src="{{ asset('images/PatraLogo.png') }}" 
                        alt="PATRA - We make good life possible" 
                        class="mx-auto w-auto">
                </div>            
                <div class="flex items-center gap-2 px-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-900 dark:bg-gray-700 text-white">
                        <span class="material-symbols-outlined text-full">database</span>
                    </div>
                    <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ __('sidebar.master_database') }}</h1>
                </div>                
            </div>


            <nav class="flex flex-col gap-1 shadow-sm px-4">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium 
                    {{ request()->routeIs('dashboard') 
                        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-110' 
                        : 'text-gray-700 dark:text-gray-300 hoverScale hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <span class="material-symbols-outlined text-lg">home</span>
                    <span>{{ __('sidebar.dashboard') }}</span>
                </a>

                <a href="{{ route('shape.index') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium 
                    {{ request()->routeIs('shape.index') 
                        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-110' 
                        : 'text-gray-700 dark:text-gray-300 hoverScale hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <span class="material-symbols-outlined text-lg">shapes</span>
                    <span>{{ __('sidebar.shapes') }}</span>
                </a>
                
                <a href="{{ route('glaze.index') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium 
                    {{ request()->routeIs('glaze.index') 
                        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-110' 
                        : 'text-gray-700 dark:text-gray-300 hoverScale hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <span class="material-symbols-outlined text-lg">water_drop</span>
                    <span>{{ __('sidebar.glazes') }}</span>
                </a>
                
                <a href="{{ route('pattern.index') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('pattern.index') 
                        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-110' 
                        : 'text-gray-700 dark:text-gray-300 hoverScale hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <span class="material-symbols-outlined text-lg">border_color</span>
                    <span>{{ __('sidebar.patterns') }}</span>
                </a>

                <a href="{{ route('backstamp.index') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium 
                    {{ request()->routeIs('backstamp.index') 
                        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-110' 
                        : 'text-gray-700 dark:text-gray-300 hoverScale hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <span class="material-symbols-outlined text-lg">verified</span>
                    <span>{{ __('sidebar.backstamps') }}</span>
                </a>

                @php
                    use Spatie\Permission\Models\Permission;
                    use Illuminate\Support\Facades\Auth;

                    $user = Auth::user();
                    $hasFileImport = $user->getDirectPermissions()->pluck('name')->contains('file import');
                    $hasCreate = $user->getDirectPermissions()->pluck('name')->contains('create');
                    $hasEdit = $user->getDirectPermissions()->pluck('name')->contains('edit');
                    $hasDelete = $user->getDirectPermissions()->pluck('name')->contains('delete');
                @endphp
                @role('admin|superadmin')
                    <hr class="my-2 border-gray-300 dark:border-gray-600" />
                    <span class="text-center text-sm text-gray-400 dark:text-gray-500">{{ __('sidebar.admin_console') }}</span>

                    <a href="{{ route('user') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium 
                    {{ request()->routeIs('user') 
                        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-110' 
                        : 'text-gray-700 dark:text-gray-300 hoverScale hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <span class="material-symbols-outlined text-lg">group</span>
                        <span>{{ __('sidebar.user_management') }}</span>
                    </a>

                    <a href="{{ route('color.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium 
                    {{ request()->routeIs('color.index') 
                        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-110' 
                        : 'text-gray-700 dark:text-gray-300 hoverScale hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <span class="material-symbols-outlined text-lg">palette</span>
                        <span>{{ __('sidebar.colors') }}</span>
                    </a>

                    <a href="{{ route('effect.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium 
                    {{ request()->routeIs('effect.index') 
                        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-110' 
                        : 'text-gray-700 dark:text-gray-300 hoverScale hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <span class="material-symbols-outlined text-lg">auto_awesome</span>
                        <span>{{ __('sidebar.effects') }}</span>
                    </a>
                    
                    <a href="{{ route('glaze.inside.outer.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('glaze.inside.outer.index') 
                        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-110' 
                        : 'text-gray-700 dark:text-gray-300 hoverScale hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <span class="material-symbols-outlined text-lg">opacity</span>
                        <span>{{ __('sidebar.glaze_inside_outer') }}</span>
                    </a>
                    
                    <a href="{{ route('shape.collection.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('shape.collection.index') 
                        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-110' 
                        : 'text-gray-700 dark:text-gray-300 hoverScale hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        <span class="material-symbols-outlined text-lg">Collections_Bookmark</span>
                        <span>{{ __('sidebar.shape_collections') }}</span>
                    </a>
                    
                    @if ($hasFileImport)
                        <a href="{{ route('csvImport') }}"
                            class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('csvImport') 
                        ? 'bg-primary-50 dark:bg-primary-900 text-primary-600 dark:text-primary-400 font-semibold scale-110' 
                        : 'text-gray-700 dark:text-gray-300 hoverScale hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <span class="material-symbols-outlined text-lg">cloud_upload</span>
                            <span>{{ __('sidebar.csv_import') }}</span>
                        </a>
                    @endif

                @endrole
            </nav>
            
            <!-- Sidebar User Info & Actions -->
            <div class="mt-auto flex flex-col gap-2 px-2" x-data="{ open: false }">
                @php
                    use Illuminate\Support\Str;

                    $roleInitial = 'U';
                    if (Auth::user()->hasRole('admin')) {
                        $roleInitial = 'A';
                    } elseif (Auth::user()->hasRole('superadmin')) {
                        $roleInitial = 'SA';
                    }
                @endphp
                <!-- User Info Section -->
                <div class="flex items-center gap-3 rounded-md p-3 shadow-md bg-gray-50 dark:bg-gray-700">
                    <div class="relative flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-600">
                        <span class="text-lg font-bold text-gray-700 dark:text-gray-200">{{ $roleInitial }}</span>
                        <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white dark:border-gray-700 bg-green-500">
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ Str::limit(Auth::user()->name, 19) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit(Auth::user()->email, 20) }}</p>
                    </div>
                </div>

                <!-- Logout & Settings -->
                <div class="flex flex-row gap-2 pb-2">
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="btn w-full flex justify-center rounded-lg bg-gray-500 dark:bg-gray-600
                            py-2 px-3 text-sm font-semibold text-white shadow-sm hoverScale hover:bg-red-500 dark:hover:bg-red-600
                            focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <span class="material-symbols-outlined text-lg">logout</span>
                            <span class="mt-1 ml-1">{{__('sidebar.logout')}}</span>
                        </button>
                    </form>

                    <!-- Settings Dropdown -->
                    <div class="relative" x-data="{ settingsOpen: false }" @click.outside="settingsOpen = false">
                        <!-- Trigger Button -->
                        <button @click="settingsOpen = !settingsOpen"
                            class="flex items-center justify-center rounded-lg bg-white dark:bg-gray-700 px-3 py-2.5
                            text-gray-600 dark:text-gray-300 hoverScale hover:bg-gray-300 dark:hover:bg-gray-600">
                            <span class="material-symbols-outlined">settings</span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="settingsOpen"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 bottom-full mb-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 
                                ring-1 ring-black dark:ring-gray-600 ring-opacity-5 focus:outline-none z-50"
                            style="display: none;"
                            @click="settingsOpen = false">
                        
                            <div class="py-1">
                                <!-- Profile Link -->
                                <a href="{{ route('profile.edit') }}" 
                                class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 
                                        hover:bg-gray-100 dark:hover:bg-gray-700">
                                    {{ __('sidebar.profile') }}
                                </a>

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 
                                                hover:bg-gray-100 dark:hover:bg-gray-700">
                                        {{ __('sidebar.logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main content area -->
        <main class="flex-1 flex flex-col w-full md:ml-0">
            <!-- Header -->
            <header class="flex top-0 right-0 h-16 bg-white dark:bg-gray-800 shadow-md items-center justify-between px-6 z-30"
                    :class="headerClass">
                <div class="flex items-center gap-4">
                    <button @click="toggleSidebar()"
                        class="rounded-full p-2 text-gray-500 dark:text-gray-400 hoverScale hover:text-gray-700 dark:hover:text-gray-200 md:hidden">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    @php
                        $userPermissions = Auth::user()->permissions->pluck('name')->toArray();
                        $permissionLabel = __('auth.user') . ' : ' . __('auth.view_only');

                        if (Auth::user()->hasRole('admin')) {
                            // แปลง permission name แต่ละตัวเป็น localized text
                            $translatedPermissions = array_map(function($perm) {
                                return __('auth.' . $perm);
                            }, $userPermissions);

                            $permissionLabel = __('auth.admin') . ' : ' . implode(', ', $translatedPermissions);
                        }elseif (Auth::user()->hasRole('superadmin')) {
                            $permissionLabel = __('auth.superadmin') . ' : ' . __('auth.all_permissions');
                        }

                    @endphp
                    <h2>
                        <span class="text-xl font-semibold text-gray-900 dark:text-gray-100">@yield('header', 'Title')</span>
                        <span class="text-gray-500 dark:text-gray-400">| {{ $permissionLabel }}</span>
                    </h2>
                </div>
                <!-- Theme Toggle -->
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
            <section class="flex-1 p-3 overflow-y-auto ml-0 md:ml-0">
                <div>
                    @yield('content')
                </div>
            </section>
        </main>
    </div>
    <script src="{{ asset('js/sidebar-manager.js') }}"></script>
        <!-- Add SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Alpine.js CDN -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Select2 CSS & JS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- Modal common Scripts -->
    <script src="{{ asset('js/modals/modal-common.js') }}"></script> 
    <!-- Manager Script -->
    <script src="{{ asset('js/language-manager.js') }}"></script>
    <script src="{{ asset('js/theme-manager.js') }}"></script>
    <!-- Page Specific Scripts -->
    <script src="{{ asset('js/pages/shape-page.js') }}"></script>
    <script src="{{ asset('js/pages/pattern-page.js') }}"></script>
    <script src="{{ asset('js/pages/backstamp-page.js') }}"></script>
    <script src="{{ asset('js/pages/glaze-page.js') }}"></script>
    <script src="{{ asset('js/pages/color-page.js') }}"></script>
    <script src="{{ asset('js/pages/effect-page.js') }}"></script>
    <script src="{{ asset('js/pages/user-page.js') }}"></script>
    <script src="{{ asset('js/pages/glazeInsideOuter-page.js') }}"></script>
    <script src="{{ asset('js/pages/shapeCollection.blade-page.js') }}"></script>
</body>

</html>
