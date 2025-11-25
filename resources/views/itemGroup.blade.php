@extends('layouts.sidebar')
@section('title', __('sidebar.item_group'))
@section('header', __('sidebar.item_group'))
@section('content')
    <main class="flex-1 bg-gray-50 dark:bg-gray-900" x-data="itemGroupPage()" x-init="initSelect2()">

        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-3 
            dark:bg-gray-800 dark:shadow-gray-900/50">
            <form method="GET" action="{{ route('item.group.index') }}" class="flex flex-wrap items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1 min-w-64">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('content.search_by') }}{{__('content.item_group_name')}}{{ __('content.etc') }}"
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

                    <a href="{{ route('item.group.index') }}" 
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

        <!-- Cards Grid -->
        @if ($itemGroups->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-2">
                @foreach ($itemGroups as $itemGroup)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden group">
                        <!-- Image Container -->
                        <div class="relative aspect-square overflow-hidden bg-gray-100 dark:bg-gray-700">
                            <img src="{{ $itemGroup->imageUrl }}" 
                                alt="{{ $itemGroup->item_group_name }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                                onerror="this.src='{{ asset('images/itemGroup/default.png') }}'">
                            
                            <!-- Overlay Actions -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 
                                        transition-all duration-300 flex items-center justify-center 
                                        space-x-3 opacity-0 group-hover:opacity-100">
                                @if ($hasEdit)
                                    <button @click="openEditModal({{ $itemGroup->toJson() }})"
                                            class="flex items-center justify-center bg-blue-600 hover:bg-blue-700 
                                                text-white w-10 h-10 rounded-full shadow-lg transform 
                                                hover:scale-110 transition-all">
                                        <span class="material-symbols-outlined text-xl">edit</span>
                                    </button>
                                @endif
                                @if ($hasDelete)
                                    <button @click="DeleteItemGroupModal = true; itemGroupIdToDelete = {{ $itemGroup->id }}; itemCodeToDelete = '{{ $itemGroup->item_group_name }}'"
                                            class="flex items-center justify-center bg-red-600 hover:bg-red-700 
                                                text-white w-10 h-10 rounded-full shadow-lg transform 
                                                hover:scale-110 transition-all">
                                        <span class="material-symbols-outlined text-xl">delete</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-100 text-center truncate" 
                                title="{{ $itemGroup->item_group_name }}">
                                {{ $itemGroup->item_group_name }}
                            </h3>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-2">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('content.showing') }} 
                        <span class="font-semibold">{{ $itemGroups->firstItem() }}</span>
                        {{ __('content.to') }}
                        <span class="font-semibold">{{ $itemGroups->lastItem() }}</span>
                        {{ __('content.of') }}
                        <span class="font-semibold">{{ $itemGroups->total() }}</span>
                        {{ __('content.results') }}
                    </div>
                    {{ $itemGroups->links('vendor.pagination.tailwind-custom') }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-12 text-center">
                <span class="material-symbols-outlined text-6xl text-gray-400 dark:text-gray-500 mb-4 block">
                    inventory_2
                </span>
                <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    @if(request('search'))
                        {{ __('content.not_found') }} "{{ request('search') }}"
                    @else
                        {{ __('content.no_data') }}
                    @endif
                </h3>
                <p class="text-gray-500 dark:text-gray-400">
                    @if(request('search'))
                        {{ __('content.try_different_search') }}
                    @else
                        {{ __('content.start_by_adding_item') }}
                    @endif
                </p>
            </div>
        @endif

        {{-- include modal --}}
        @include('components.Edit-modals.edit-itemGroup')
        @include('components.Create-modals.create-itemGroup')
        <x-modals.delete-modal 
            show="DeleteItemGroupModal"
            itemName="itemCodeToDelete"
            deleteFunction="deleteItemGroup"
        />    
    </main>
@endsection
