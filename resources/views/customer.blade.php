@extends('layouts.sidebar')
@section('title', __('sidebar.customers'))
@section('header', __('sidebar.customers'))
@section('content')
    <main  x-data="customerPage()" x-init="initSelect2()">
        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-3 
            dark:bg-gray-800 dark:shadow-gray-900/50">
            <form method="GET" action="{{ route('customer.index') }}" class="flex flex-wrap items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1 min-w-64">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('content.search_by') }}{{ __('content.customer_code') }},{{__('content.customer_name')}}{{ __('content.etc') }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent
                            dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" />
                    </div>
                </div>
                <!-- Search and Reset buttons -->
                <div class="flex gap-2">
                    <button type="submit" 
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hoverScale hover:bg-green-700">
                        <span class="material-symbols-outlined">search</span>
                        <span>{{__('content.search')}}</span>
                    </button>

                    <a href="{{ route('customer.index') }}" 
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hoverScale hover:bg-gray-300
                            dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                        <span class="material-symbols-outlined">refresh</span>
                        <span>{{__('content.reset')}}</span>
                    </a>
                </div>        
                <!-- Items per page select -->
                <div>
                    <select name="per_page" onchange="this.form.submit()" 
                            class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent
                            dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 {{ __('content.items') }}</option>
                        <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10 {{ __('content.items') }}</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 {{ __('content.items') }}</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 {{ __('content.items') }}</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 {{ __('content.items') }}</option>
                    </select>
                </div>
                <!-- Add button -->
                @if ($hasCreate)
                    <div class="ml-auto">
                        <button type="button" @click="openCreateModal()"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700">
                            <span class="material-symbols-outlined">add</span>
                            <span>{{ __('content.add') }}</span>
                        </button>
                    </div>
                @endif
            </form>
        </div>

        <!-- Table -->
        <div class="rounded-xl shadow-md bg-white
            dark:shadow-gray-900/50 dark:bg-gray-800">
            <div class="overflow-x-auto rounded-xl">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs uppercase bg-gray-50 border-b dark:border-gray-700
                        dark:bg-gray-700 dark:text-gray-400 text-black">
                        <tr>
                            <th class="px-4 py-3">{{ __('content.customer_code') }}</th>
                            <th class="px-4 py-3">{{ __('content.customer_name') }}</th>
                            <th class="px-4 py-3">{{ __('content.email') }}</th>
                            <th class="px-4 py-3">{{ __('content.phone') }}</th>
                            <th class="px-4 py-3 text-right">{{ __('content.action') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($customers as $customer)
                            <tr class="bg-white border-b hover:bg-gray-50 
                                dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $customer->code }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $customer->name ?? '-' }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $customer->email ?? '-' }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $customer->phone ?? '-' }}</td>
                                <td class="px-4 py-3 text-right space-x-2">
                                    @if ($hasEdit)
                                        <button @click="openEditModal({{ $customer->toJson() }})"
                                                class="text-blue-600 hover:text-blue-700">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>                                        
                                    @endif
                                    @if ($hasDelete)
                                        <button @click="DeleteCustomerModal = true; customerIdToDelete = {{ $customer->id }}; itemCodeToDelete = '{{ $customer->code }}'"
                                                class="text-red-500 hover:text-red-700">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-3 text-sm text-gray-500 text-center
                                    dark:text-gray-400">
                                    @if(request('search'))
                                        {{ __('content.not_found') }} "{{ request('search') }}".
                                    @else
                                        {{ __('content.not_found') }}
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4 flex justify-end pb-2">
                    {{ $customers->links('vendor.pagination.tailwind-custom') }}
                </div>
            </div>
        </div>
        {{-- include modal --}}  
        @include('components.Edit-modals.edit-customer')
        @include('components.Create-modals.create-customer')
        <x-modals.delete-modal 
            show="DeleteCustomerModal"
            itemName="itemCodeToDelete"
            deleteFunction="deleteCustomer"
        />  
    </main>
@endsection
