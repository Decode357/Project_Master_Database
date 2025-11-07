@extends('layouts.sidebar')
@section('title', __('sidebar.csv_import'))
@section('header', __('sidebar.csv_import'))
@section('content')
    <main class="flex-1 bg-gray-50 dark:bg-gray-900 p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mb-2">
                    <i class="fas fa-database mr-2"></i>{{ __('content.data_import_center') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('content.import_and_manage') }}
                </p>
            </div>

            <!-- Import Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Customer Import Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-green-400 dark:bg-green-400 p-3 rounded-xl">
                            <i class="fas fa-users text-blue-600 dark:text-blue-400 text-2xl"></i>
                        </div>
                        <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-gray-100">
                            {{ __('content.customer') }}
                        </h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                        {{ __('content.customer_import_detail') }}
                    </p>
                    <button onclick="openCustomerModal()"
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hoverScale hover:bg-blue-700 transition
                        dark:bg-blue-500 dark:hover:bg-blue-600">
                        <i class="fas fa-file-import mr-2"></i>{{ __('content.import') }}
                    </button>
                </div>

                <!-- Future Import Cards -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 opacity-50">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-400 dark:bg-red-400 p-3 rounded-xl">
                            <i class="fas fa-box text-gray-600 dark:text-gray-400 text-2xl"></i>
                        </div>
                        <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-gray-100">
                            Shapes
                        </h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                        Coming soon...
                    </p>
                    <button disabled
                        class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">
                        <i class="fas fa-lock mr-2"></i>Coming Soon
                    </button>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 opacity-50">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-400 dark:bg-red-400 p-3 rounded-xl">
                            <i class="fas fa-box text-gray-600 dark:text-gray-400 text-2xl"></i>
                        </div>
                        <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-gray-100">
                            Glazes
                        </h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                        Coming soon...
                    </p>
                    <button disabled
                        class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">
                        <i class="fas fa-lock mr-2"></i>Coming Soon
                    </button>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 opacity-50">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-400 dark:bg-red-400 p-3 rounded-xl">
                            <i class="fas fa-warehouse text-gray-600 dark:text-gray-400 text-2xl"></i>
                        </div>
                        <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-gray-100">
                            Patterns
                        </h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                        Coming soon...
                    </p>
                    <button disabled
                        class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">
                        <i class="fas fa-lock mr-2"></i>Coming Soon
                    </button>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 opacity-50">
                    <div class="flex items-center mb-4">
                        <div class="bg-red-400 dark:bg-red-400 p-3 rounded-xl">
                            <i class="fas fa-warehouse text-gray-600 dark:text-gray-400 text-2xl"></i>
                        </div>
                        <h2 class="ml-3 text-xl font-semibold text-gray-800 dark:text-gray-100">
                            Backstamps
                        </h2>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                        Coming soon...
                    </p>
                    <button disabled
                        class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">
                        <i class="fas fa-lock mr-2"></i>Coming Soon
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- Include Customer Import Modal -->
    @include('components.Import-modals.import-customer')
@endsection
