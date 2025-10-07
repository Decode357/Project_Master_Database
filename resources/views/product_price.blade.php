@extends('layouts.sidebar')
@section('title', 'Product Price')
@section('header', 'Product Price')
@section('content')
    <main x-data="productPricePage()" x-init="initSelect2()">
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
                    <button @click="openCreateModal()"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                        <span class="material-symbols-outlined">add</span>
                        <span>Add Shape</span>
                    </button>
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
                                Price Tier</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Currency</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Effective Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                UPDATED BY</th>
                            <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ACTION</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($productPrices as $productPrice)
                            @php
                                $statusText = $productPrice->status->status ?? 'Unknown';
                                $productSKU = $productPrice->product->product_sku ?? 'N/A';
                                $priceTier = $productPrice->price_tier?? 'N/A';
                                $currency = $productPrice->currency ?? 'N/A';
                                $effectiveDate = $productPrice->effective_date ?? 'N/A';
                                $updatedBy = $productPrice->updater->name ?? 'N/A';
                            @endphp
                            <tr>
                                <td class="px-6 py-4 ">
                                    {{ $productSKU }}</td>
                                <td class="px-6 py-4 ">
                                    {{ $priceTier }}</td>
                                <td class="px-6 py-4 ">
                                    {{ $currency }}</td>
                                <td class="px-6 py-4">
                                    {{ $effectiveDate ? \Carbon\Carbon::parse($effectiveDate)->locale('th')->translatedFormat('d/m/Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 ">
                                    {{ $updatedBy }}</td>
                                <td class="px-6 py-4">
                                    <!-- Action Buttons -->
                                    <div class="flex justify-end gap-2">
                                        <button @click="openDetailModal({{ $productPrice->toJson() }})"
                                            class="flex items-center gap-1 px-2 py-1 text-sm font-medium text-white bg-blue-500 rounded-lg shadow-sm hover:bg-green-600 hover:shadow-md transition-all duration-200 hoverScale">
                                            <span class="material-symbols-outlined text-white">feature_search</span>
                                            <span>Detail</span>
                                        </button>

                                        <button @click="openEditModal({{ $productPrice->toJson() }})"
                                            class="text-blue-600 hoverScale hover:text-blue-700">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>

                                        <button
                                            @click="DeleteProductPriceModal = true; productPriceIdToDelete = {{ $productPrice->id }}; itemCodeToDelete = '{{ $productSKU }}'"
                                            class="text-red-500 hoverScale hover:text-red-700">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="mt-4 flex justify-end">
                    {{ $productPrices->links('vendor.pagination.tailwind-custom') }}
                </div>
            </div>
        </div>
        <!-- Modals -->
        @include('components.Edit-modals.edit-product-price')
        @include('components.Detail-modals.detail-product-price')
        @include('components.Create-modals.create-product-price')
        @include('components.Delete-modals.delete-product-price')
    </main>
@endsection
