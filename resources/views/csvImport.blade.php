@extends('layouts.sidebar')
@section('title', __('sidebar.csv_import'))
@section('header', __('sidebar.csv_import'))
@section('content')
    <main class="flex-1 bg-gray-50 dark:bg-gray-900 flex justify-center items-center">
        <div class="w-full max-w-lg text-center">
            <!-- Header -->
            <div class="m-10">
                <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Customer Data Uploader</h1>
                <p class="text-gray-600 dark:text-gray-400">Upload a CSV or Excel file to import customer data into the database.</p>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-md">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('errors') && is_array(session('errors')))
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-md">
                    <ul class="list-disc list-inside">
                        @foreach(session('errors') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(isset($errors) && is_object($errors) && method_exists($errors, 'any') && $errors->any())
                <div class="mb-4 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-md">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md dark:shadow-gray-900/50 space-y-6">
                <!-- Step 1 -->
                <div>
                    <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">Step 1: Get the Template</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Download the template to ensure your data is in the correct format.</p>
                    <div class="flex gap-3 justify-center">
                        <a href="{{ route('customers.template') }}"
                            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition
                            dark:bg-blue-500 dark:hover:bg-blue-600 hoverScale">
                            <i class="fas fa-download mr-2"></i>Download Template
                        </a>
                        <a href="{{ route('customers.export') }}"
                            class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition
                            dark:bg-blue-500 dark:hover:bg-blue-600 hoverScale">
                            <i class="fas fa-file-export mr-2"></i>Export All Data
                        </a>
                    </div>
                </div>

                <!-- Step 2 -->
                <div>
                    <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">Step 2: Upload Your File</h2>
                    <form action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select File (CSV/Excel)</label>
                            <div class="flex justify-center">
                                <input type="file" name="file" accept=".csv,.xlsx,.xls" required
                                    class="text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4
                                        file:rounded-md file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100
                                        dark:file:bg-blue-900 dark:file:text-blue-300
                                        dark:hover:file:bg-blue-800
                                        focus:outline-none focus:ring-2 focus:ring-blue-500
                                        dark:focus:ring-blue-400
                                    " />
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Supported formats: CSV, XLSX, XLS
                            </p>
                        </div>
                        <div class="flex justify-center">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition hoverScale
                                dark:bg-green-500 dark:hover:bg-green-600">
                                <i class="fas fa-upload mr-2"></i>Upload and Process File
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Instructions -->
                <div class="mt-6 text-left">
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">📋 Instructions:</h3>
                    <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-1 list-disc list-inside">
                        <li>Download the template first</li>
                        <li>Fill in customer data (code, name, email, phone)</li>
                        <li>Code is required, other fields are optional</li>
                        <li>Duplicate codes will update existing records</li>
                        <li>Invalid rows will be skipped</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
@endsection
