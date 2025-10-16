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

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50" x-data="{ sidebarOpen: false }" style='font-family: "Public Sans", "Noto Sans", sans-serif;'>

    <!-- Overlay ใช้เฉพาะมือถือและซ่อนเมื่อขยายจอ -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" x-show="sidebarOpen" x-transition.opacity
        @click="sidebarOpen = false" @resize.window="if (window.innerWidth >= 768) sidebarOpen = false"
        style="display: none;">
    </div>
    <!-- Sidebar -->
    <div class="flex h-screen overflow-hidden">
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 flex-col gap-y-4 border-r border-gray-200 bg-white p-4 shadow-xl
                transform transition-transform duration-300 ease-in-out md:static md:flex md:z-auto"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

            <h1 class="text-4xl font-bold ml-3">PATRA</h1>
            <div class="flex items-center gap-2">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-900 text-white">
                    <span class="material-symbols-outlined text-full">database</span>
                </div>
                <h1 class="text-lg font-bold text-gray-900">Product Master</h1>
            </div>

            <nav class="flex flex-col gap-1 shadow-sm mt-4 ">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('dashboard') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined text-lg">home</span>
                    <span>Dashboards</span>
                </a>
                
                <a href="{{ route('product.index') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('product.index') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined text-lg">package_2</span>
                    <span>Products</span>
                </a>

                <a href="{{ route('shape.index') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('shape.index') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined text-lg">shapes</span>
                    <span>Shapes</span>
                </a>

                <a href="{{ route('pattern.index') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('pattern.index') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined text-lg">border_color</span>
                    <span>Patterns</span>
                </a>

                <a href="{{ route('backstamp.index') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('backstamp.index') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined text-lg">verified</span>
                    <span>Backstamps</span>
                </a>
                
                <a href="{{ route('glaze.index') }}"
                    class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('glaze.index') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                    <span class="material-symbols-outlined text-lg">water_drop</span>
                    <span>Glazes</span>
                </a>
                @php
                    use Spatie\Permission\Models\Permission;
                    use Illuminate\Support\Facades\Auth;

                    $user = Auth::user();
                    $hasFileImport = $user->getDirectPermissions()->pluck('name')->contains('file import');
                @endphp
                @role('admin|superadmin')
                    <hr class="my-2" />
                    <span class="text-center text-sm text-gray-400">Admin console</span>

                    <a href="{{ route('product.price.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('product.price.index') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                        <span class="material-symbols-outlined text-lg">paid</span>
                        <span>Product Price</span>
                    </a>

                    <a href="{{ route('user') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('user') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                        <span class="material-symbols-outlined text-lg">group</span>
                        <span>User Management</span>
                    </a>

                    <a href="{{ route('color.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('color.index') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                        <span class="material-symbols-outlined text-lg">palette</span>
                        <span>Colors</span>
                    </a>

                    <a href="{{ route('effect.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('effect.index') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                        <span class="material-symbols-outlined text-lg">auto_awesome</span>
                        <span>Effects</span>
                    </a>
                    <a href="{{ route('glaze.inside.outer.index') }}"
                        class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('glaze.inside.outer.index') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                        <span class="material-symbols-outlined text-lg">opacity</span>
                        <span>Glaze inside/outer</span>
                    </a>
                    @if ($hasFileImport)
                        <a href="{{ route('csvImport') }}"
                            class="flex items-center gap-3 rounded-md px-3 py-2 text-sm font-medium
                    {{ request()->routeIs('csvImport') ? 'bg-primary-50 text-primary-600 font-semibold scale-110' : 'text-gray-700 hoverScale hover:bg-gray-100' }}">
                            <span class="material-symbols-outlined text-lg">cloud_upload</span>
                            <span>CSV Import</span>
                        </a>
                    @endif

                @endrole
            </nav>
            <!-- Sidebar User Info & Actions -->
            <div class="mt-auto flex flex-col gap-2" x-data="{ open: false }">
                <!-- Sidebar User Info -->
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
                <div class="flex items-center gap-3 rounded-md p-3 shadow-md">
                    <div class="relative flex h-10 w-10 items-center justify-center rounded-full bg-gray-100">
                        <span class="text-lg font-bold text-gray-700">{{ $roleInitial }}</span>
                        <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-green-500">
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">{{ Str::limit(Auth::user()->name, 19) }}</p>
                        <p class="text-xs text-gray-500">{{ Str::limit(Auth::user()->email, 20) }}</p>
                    </div>
                </div>

                <!-- Logout & Settings -->
                <div class="flex flex-row gap-2">
                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="btn w-full flex justify-center rounded-lg bg-gray-500
                            py-2 px-3 text-sm font-semibold text-white shadow-sm hoverScale hover:bg-red-500
                            focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <span class="material-symbols-outlined text-lg">logout</span>
                            <span class="mt-1 ml-1">Logout</span>
                        </button>
                    </form>

                    <!-- Settings Dropdown -->
                    <x-dropdown width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center justify-center rounded-lg bg-white px-3  py-2
                                text-gray-600 hoverScale hover:bg-gray-300 hover:text-gray-900">
                                <span class="material-symbols-outlined">settings</span>
                            </button>
                        </x-slot>
                        <!-- Dropdown Content -->
                        <x-slot name="content">
                            <div
                                class="origin-bottom-right absolute right-0 bottom-full mb-16 w-32 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <!-- Profile Link -->
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </aside>

        <!-- ✅ แก้ไข: Main content area -->
        <main class="flex-1 flex flex-col w-full md:ml-0">
            <!-- ✅ แก้ไข: Header responsive positioning -->
            <header
                class="flex top-0 right-0 h-16 bg-white shadow-md items-center justify-between px-6 z-30 transition-all duration-300"
                :class="{
                    'left-64': window.innerWidth >= 768,
                    'left-0': window.innerWidth < 768
                }"
                x-init="$watch('sidebarOpen', value => {
                    if (window.innerWidth < 768 && value) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = 'auto';
                    }
                })">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="rounded-full p-2 text-gray-500 hoverScale hover:text-gray-700 md:hidden">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    @php
                        // ดึง permission ของ user ปัจจุบัน
                        $userPermissions = Auth::user()->permissions->pluck('name')->toArray();

                        // สร้างข้อความที่จะแสดง
                        $permissionLabel = 'User : view only'; // default = user

                        if (Auth::user()->hasRole('admin')) {
                            $permissionLabel = 'Admin : ' . implode(', ', $userPermissions);
                        } elseif (Auth::user()->hasRole('superadmin')) {
                            $permissionLabel = 'Super Admin : all permissions';
                        }
                    @endphp
                    <h2>
                        <span class="text-xl font-semibold">@yield('header', 'Title')</span>
                        <span class="text-gray-500">| {{ $permissionLabel }}</span>
                    </h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative w-full max-w-md">
                        <input type="search" placeholder="search..."
                            class="w-full rounded-full border border-gray-300 px-4 py-2 pl-10 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition" />
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <span class="material-symbols-outlined mt-2">search</span>
                        </span>
                    </div>
                    <button class="rounded-full p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                </div>
            </header>

            <!-- ✅ แก้ไข: Content section -->
            <section class="flex-1 p-6  overflow-y-auto ml-0 md:ml-0 transition-all duration-300">
                <div>
                    @yield('content')
                </div>
            </section>
        </main>
    </div>

    <!-- ✅ เพิ่ม: JavaScript สำหรับจัดการ responsive behavior -->
    <script>
        // จัดการ sidebar behavior เมื่อขนาดหน้าจอเปลี่ยน
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) {
                // Desktop - ปิด mobile sidebar และเปิด body scroll
                Alpine.store('sidebar', {
                    open: false
                });
                document.body.style.overflow = 'auto';
            }
        });

        // เพิ่ม Alpine store สำหรับจัดการ sidebar state
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                open: false
            });
        });
    </script>

    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Chart.js CDN -->
    <script src="{{ asset('js/pages/dashboard-page.js') }}"></script>
    <!-- Select2 CSS & JS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Modal common Scripts -->
    <script src="{{ asset('js/modals/modal-common.js') }}"></script> 
    
    <!-- Page Specific Scripts -->
    <script src="{{ asset('js/pages/product-page.js') }}"></script>
    <script src="{{ asset('js/pages/product-price-page.js') }}"></script>
    <script src="{{ asset('js/pages/shape-page.js') }}"></script>
    <script src="{{ asset('js/pages/pattern-page.js') }}"></script>
    <script src="{{ asset('js/pages/backstamp-page.js') }}"></script>
    <script src="{{ asset('js/pages/glaze-page.js') }}"></script>
    <script src="{{ asset('js/pages/color-page.js') }}"></script>
    <script src="{{ asset('js/pages/effect-page.js') }}"></script>
    <script src="{{ asset('js/pages/user-page.js') }}"></script>
    <script src="{{ asset('js/pages/glazeInsideOuter-page.js') }}"></script>
</body>

</html>
