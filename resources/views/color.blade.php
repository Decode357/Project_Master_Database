@extends('layouts.sidebar')
@section('title', 'Effect')
@section('header', 'Effect')
@section('content')
    <main class="flex-1 bg-gray-50" x-data="colorPage()" x-init="initSelect2()">
        
        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-1">
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" placeholder="Search by color code or name"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                    </div>
                </div>
                <div class="md:col-span-2 flex flex-wrap items-center justify-end gap-4">
                    <button @click="CreateColorModal = true"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                        <span class="material-symbols-outlined">add</span>
                        <span>Add Color</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white p-3 rounded-lg shadow-md overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Preview</th>
                        <th class="px-6 py-3">Color Code</th>
                        <th class="px-6 py-3">Color Name</th>
                        <th class="px-6 py-3">Customer ID</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colors as $color)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="inline-block w-6 h-6 rounded-full border border-gray-300"
                                    style="background-color: {{ $color->color_code }}"></span>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $color->color_code }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $color->color_name }}</td>
                            <td class="px-6 py-4">{{ $color->customer_id }}</td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <button class="text-blue-600 hoverScale hover:text-blue-700">
                                    <span class="material-symbols-outlined">edit</span>
                                </button>
                                <button @click="DeleteColorModal = true; colorIdToDelete = {{ $color->id }}; itemCodeToDelete = '{{ $color->color_code }}'"
                                    class="text-red-500 hoverScale hover:text-red-700">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-4 flex justify-end">
                {{ $colors->links('vendor.pagination.tailwind-custom') }}
            </div>
        </div>

        {{-- include modal --}}
        @include('components.Delete-modals.delete-color')
        @include('components.Create-modals.create-color')
    </main>
@endsection
