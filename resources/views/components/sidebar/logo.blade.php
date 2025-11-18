<div class="mb-2">
    <div class="bg-white dark:bg-gray-800 p-2 inline-block shadow-sm">
        <img src="{{ asset('images/PatraLogo.png') }}" 
            alt="PATRA - We make good life possible" 
            class="mx-auto w-auto transition-opacity duration-300 dark:hidden">
        
        <img src="{{ asset('images/PatraLogoWhite.png') }}" 
            alt="PATRA - We make good life possible" 
            class="mx-auto w-auto transition-opacity duration-300 hidden dark:block">
    </div>           
    <div class="flex items-center gap-2 px-4">
        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-900 dark:bg-gray-700 text-white">
            <span class="material-symbols-outlined text-full">database</span>
        </div>
        <h1 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ __('sidebar.master_database') }}</h1>
    </div>
</div>