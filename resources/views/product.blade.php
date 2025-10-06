@extends('layouts.sidebar')
@section('title', 'Product')
@section('header', 'Product')
@section('content')
    <main x-data="shapePage()" x-init="initSelect2()">
        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-1">
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" placeholder="Search by ITEM CODE or etc.."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                    </div>
                </div>
                <div class="md:col-span-2 flex justify-end items-center gap-4">
                    {{-- <button @click="openCreateModal()"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                        <span class="material-symbols-outlined">add</span>
                        <span>Add Shape</span>
                    </button> --}}
                </div>
            </div>
        </div>
        <!-- Table -->
        <div class="rounded-xl p-3 shadow-md bg-white">
            <div class="overflow-x-auto rounded-xl">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ProductSKU</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                UPDATED BY</th>
                            <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ACTION</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-200">

                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="mt-4 flex justify-end">
                    {{-- {{ $shapes->links('vendor.pagination.tailwind-custom') }} --}}
                </div>
            </div>
        </div>
        <!-- Modals -->
        {{-- @include('components.Edit-modals.edit-shape')
        @include('components.Detail-modals.detail-shape')
        @include('components.Create-modals.create-shape')
        @include('components.Delete-modals.delete-shape') --}}
    </main>
@endsection
