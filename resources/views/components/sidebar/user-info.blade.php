@php
    use Illuminate\Support\Str;
    $roleInitial = 'U';
    if (Auth::user()->hasRole('admin')) {
        $roleInitial = 'A';
    } elseif (Auth::user()->hasRole('superadmin')) {
        $roleInitial = 'SA';
    }
@endphp

<div class="mt-auto flex flex-col gap-2 px-2">
    <!-- User Info Section -->
    <div class="flex items-center gap-3 rounded-md p-3 mt-2 shadow-md bg-gray-50 dark:bg-gray-700">
        <div class="relative flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-600">
            <span class="text-lg font-bold text-gray-700 dark:text-gray-200">{{ $roleInitial }}</span>
            <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white dark:border-gray-700 bg-green-500"></div>
        </div>
        <div>
            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ Str::limit(Auth::user()->name, 19) }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit(Auth::user()->email, 20) }}</p>
        </div>
    </div>

    <!-- Logout & Settings -->
    <div class="flex flex-row gap-2 pb-2">
        <form method="POST" action="{{ route('logout') }}" class="flex-1">
            @csrf
            <button type="submit"
                class="btn w-full flex justify-center rounded-lg bg-gray-500 dark:bg-gray-600
                py-2 px-3 text-sm font-semibold text-white shadow-sm hoverScale hover:bg-red-500 dark:hover:bg-red-600">
                <span class="material-symbols-outlined text-lg">logout</span>
                <span class="mt-1 ml-1">{{__('sidebar.logout')}}</span>
            </button>
        </form>

        <div class="relative" x-data="{ settingsOpen: false }" @click.outside="settingsOpen = false">
            <button @click="settingsOpen = !settingsOpen"
                class="flex items-center justify-center rounded-lg bg-gray-200 dark:bg-gray-700 px-3 py-2.5
                text-gray-600 dark:text-gray-300 hoverScale hover:bg-gray-300 dark:hover:bg-gray-600">
                <span class="material-symbols-outlined">settings</span>
            </button>
            
            <div x-show="settingsOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="absolute right-0 bottom-full mb-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 
                    ring-1 ring-black dark:ring-gray-600 ring-opacity-5 z-50"
                style="display: none;"
                @click="settingsOpen = false">
                <div class="py-1">
                    <a href="{{ route('profile.edit') }}" 
                        class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 
                            hover:bg-gray-100 dark:hover:bg-gray-700">
                        {{ __('sidebar.profile') }}
                    </a>
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