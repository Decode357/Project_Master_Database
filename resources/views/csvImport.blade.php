@extends('layouts.sidebar')
@section('title', __('sidebar.csv_import'))
@section('header', __('sidebar.csv_import'))
@section('content')
    <main class="flex-1 bg-gray-50 dark:bg-gray-900 flex justify-center items-center">
        <div class="w-full max-w-lg text-center">
            <!-- Header -->
            <div class="m-10">
                <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Customer Data Uploader</h1>
                <p class="text-gray-600 dark:text-gray-400">Upload a CSV file to import customer data into the database.</p>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md dark:shadow-gray-900/50 space-y-6">
                <!-- Step 1 -->
                <div>
                    <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">Step 1: Get the Template</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Download the CSV template to ensure your data is in the correct format.</p>
                    <a href="#"
                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition
                        dark:bg-blue-500 dark:hover:bg-blue-600 hoverScale">
                        Download CSV Template
                    </a>
                </div>

                <!-- Step 2 -->
                <div>
                    <h2 class="text-lg font-medium text-gray-800 dark:text-gray-100 mb-2">Step 2: Upload Your File</h2>
                    <form action="#" enctype="multipart/form-data" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select CSV File</label>
                            <div class="flex justify-center">
                                <input type="file" name="csv_file"
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

                        </div>
                        <div class="flex justify-center">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition hoverScale
                                dark:bg-green-500 dark:hover:bg-green-600">
                                Upload and Process File
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
