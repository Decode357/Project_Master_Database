@extends('layouts.sidebar')
@section('title', __('sidebar.shapes'))
@section('header', __('sidebar.shapes'))
@section('content')
    <main x-data="shapePage()" x-init="initSelect2()">
        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-3
            dark:bg-gray-800 dark:shadow-gray-900/50">
            <form method="GET" action="{{ route('shape.index') }}" class="flex flex-wrap items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1 min-w-64">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by Shape CODE or etc.."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent
                            dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 " />
                    </div>
                </div>
                <!-- Search and Reset buttons -->
                <div class="flex gap-2">
                    <button type="submit" 
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hoverScale hover:bg-green-700 ">
                        <span class="material-symbols-outlined">search</span>
                        <span>Search</span>
                    </button>

                    <a href="{{ route('shape.index') }}" 
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hoverScale hover:bg-gray-300
                            dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                        <span class="material-symbols-outlined">refresh</span>
                        <span>Reset</span>
                    </a>
                </div>        
                <!-- Items per page select -->
                <div>
                    <select name="per_page" onchange="this.form.submit()" 
                            class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent
                            dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 Items</option>
                        <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10 Items</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 Items</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 Items</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 Items</option>
                    </select>
                </div>
                <!-- Add Shape button -->
                @if ($hasCreate)
                <div class="ml-auto">
                    <button type="button" @click="openCreateModal()"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700">
                        <span class="material-symbols-outlined">add</span>
                        <span>Add</span>
                    </button>
                </div>                    
                @endif
            </form>
        </div>
        <!-- Table -->
        <div class="rounded-xl shadow-md bg-white
            dark:shadow-gray-900/50 dark:bg-gray-800">
            <div class="overflow-x-auto rounded-xl">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200 uppercase text-xs
                            dark:bg-gray-700 dark:border-gray-700 ">
                        <tr class="dark:text-gray-400 text-gray-700">
                            <th class="px-4 py-3 text-left">
                                SHAPE CODE</th>  
                            <th class="px-4 py-3 text-left">
                                Description TH</th>
                            <th class="px-4 py-3 text-left">
                                Description EN</th>
                            <th class="px-4 py-3 text-left">
                                TYPE</th>
                            <th class="px-4 py-3 text-left">
                                STATUS</th>
                            <th class="px-4 py-3 text-left">
                                PROCESS</th>
                            <th class="px-4 py-3 text-left">
                                UPDATED BY</th>
                            <th class="px-4 py-3 text-end">
                                ACTION</th>
                        </tr>
                    </thead>
                    <!-- Table Body -->
                    <tbody>
                        @forelse ($shapes as $shape)
                            @php
                                $status = $shape->status->status ?? 'Unknown';
                                $type = $shape->shapeType->name ?? 'Unknown';
                                $process = $shape->process->process_name ?? 'Unknown';
                                $updatedBy = $shape->updater->name ?? 'Unknown';
                                $statusColor = match ($status) {
                                    'Approved' => 'bg-green-100 text-green-800',
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'Rejected' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <!-- Table Row -->
                            <tr class="dark:text-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $shape->item_code }}</td>
                                <td class="px-4 py-3">{{ Str::limit($shape->item_description_thai, 15) }}</td>
                                <td class="px-4 py-3">{{ Str::limit($shape->item_description_eng, 15) }}</td>
                                <td class="px-4 py-3">{{ $type }}</td>
                                <td class="px-4 py-3">
                                    <span class="{{ $statusColor }} px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ $status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $process }}</td>
                                <td class="px-4 py-3">{{ $updatedBy }}</td>
                                <td class="px-4 py-3">
                                    <!-- Action Buttons -->
                                    <div class="flex justify-end gap-1">
                                        <button @click="openDetailModal({{ $shape->toJson() }})"
                                            class="flex items-center gap-1 px-2 py-1 text-sm font-medium text-white bg-blue-500 rounded-lg shadow-sm hover:bg-green-600 hover:shadow-md hoverScale">
                                            <span class="material-symbols-outlined text-white">feature_search</span>
                                        </button>
                                        @if ($hasEdit)
                                            <button @click="openEditModal({{ $shape->toJson() }})"
                                                class="text-blue-600 hover:text-blue-700">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>                                            
                                        @endif
                                        @if ($hasDelete)
                                            <button
                                                @click="DeleteShapeModal = true; shapeIdToDelete = {{ $shape->id }}; itemCodeToDelete = '{{ $shape->item_code }}'"
                                                class="text-red-500 hover:text-red-700">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-sm text-gray-500 text-center 
                                                dark:text-gray-400">
                                    @if(request('search'))
                                        No shapes found for "{{ request('search') }}".
                                    @else
                                        No shapes found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                <div class="mt-4 flex justify-end pb-2">
                    {{ $shapes->links('vendor.pagination.tailwind-custom') }}
                </div>
            </div>
        </div>
        <!-- Modals -->
        @include('components.Edit-modals.edit-shape')
        @include('components.Detail-modals.detail-shape')
        @include('components.Create-modals.create-shape')
        @include('components.Delete-modals.delete-shape')
    </main>
@endsection
