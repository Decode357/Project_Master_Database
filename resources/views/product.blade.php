@extends('layouts.sidebar')
@section('title', 'Product')
@section('header', 'Product')
@section('content')
    <main x-data="productPage()" x-init="initSelect2()">
        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-3 ">
            <form method="GET" action="{{ route('product.index') }}" class="flex flex-wrap items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1 min-w-64">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ITEM CODE or etc.."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                    </div>
                </div>
                <!-- Search and Reset buttons -->
                <div class="flex gap-2">
                    <button type="submit" 
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hoverScale hover:bg-green-700 transition">
                        <span class="material-symbols-outlined">search</span>
                        <span>Search</span>
                    </button>
                    
                    <a href="{{ route('product.index') }}" 
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hoverScale hover:bg-gray-300 transition">
                        <span class="material-symbols-outlined">refresh</span>
                        <span>Reset</span>
                    </a>
                </div>        
                <!-- Items per page select -->
                <div>
                    <select name="per_page" onchange="this.form.submit()" 
                            class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Items</option>
                        <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10 Items</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Items</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Items</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 Items</option>
                    </select>
                </div>
                <!-- Add Product button -->
                <div class="ml-auto">
                    <button type="button" @click="openCreateModal()"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                        <span class="material-symbols-outlined">add</span>
                        <span>Add Product</span>
                    </button>
                </div>
            </form>
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
                                Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                UPDATED BY</th>
                            <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ACTION</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($products as $product)
                            @php
                                $statusText = $product->status->status ?? 'Unknown';
                                $productSKU = $product->product_sku ?? 'N/A';
                                $productName = $product->product_name ?? 'N/A';
                                $productCategory = $product->category->category_name ?? 'N/A';
                                $statusColor = match ($statusText) {
                                    'Approved' => 'bg-green-100 text-green-800',
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'Rejected' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <!-- Table Row -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4  text-gray-900">
                                    {{ $productSKU }}</td>
                                <td class="px-6 py-4  text-gray-900">
                                    {{ $productName }}</td>
                                <td class="px-6 py-4  text-gray-900">
                                    {{ $productCategory }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $statusColor }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4  text-gray-900">
                                    {{ $product->updater->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <!-- Action Buttons -->
                                    <div class="flex justify-end gap-2">
                                        <button @click="openDetailModal({{ $product->toJson() }})"
                                            class="flex items-center gap-1 px-2 py-1 text-sm font-medium text-white bg-blue-500 rounded-lg shadow-sm hover:bg-green-600 hover:shadow-md transition-all duration-200 hoverScale">
                                            <span class="material-symbols-outlined text-white">feature_search</span>
                                            <span>Detail</span>
                                        </button>

                                        <button @click="openEditModal({{ $product->toJson() }})"
                                            class="text-blue-600 hoverScale hover:text-blue-700">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>

                                        <button
                                            @click="DeleteProductModal = true; productIdToDelete = {{ $product->id }}; itemCodeToDelete = '{{ $product->product_sku }}'"
                                            class="text-red-500 hoverScale hover:text-red-700">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-sm text-gray-500 text-center">
                                    @if(request('search'))
                                        No products found for "{{ request('search') }}".
                                    @else
                                        No products found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <!-- Pagination Info และ Links -->
                <div class="flex justify-end">
                    {{ $products->links('vendor.pagination.tailwind-custom') }}
                </div>
            </div>
        </div>
        
        <!-- Modals -->
        @include('components.Edit-modals.edit-product')
        @include('components.Detail-modals.detail-product')
        @include('components.Create-modals.create-product')
        @include('components.Delete-modals.delete-product')
    </main>
@endsection
