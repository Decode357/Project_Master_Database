@extends('layouts.sidebar')
@section('title', 'Glaze inside/outer')
@section('header', 'Glaze inside/outer')
@section('content')
    <main class="flex-1 bg-gray-50" x-data="glazeInsideOuterPage()" x-init="initSelect2()">
        <!-- Table -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <!-- Filters -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-1"> 
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                                <input type="text" placeholder="Search"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                            </div>
                        </div>
                        <div class="md:col-span-2 flex flex-wrap items-center justify-end gap-4">
                            <button @click="openCreateModal()"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                                <span class="material-symbols-outlined">add</span>
                                <span>Add Glaze Inside</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-3 rounded-xl shadow-md overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Glaze Inside Code</th>
                                <th class="px-6 py-3">Colors</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($glaze_insides as $glaze_inside)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $glaze_inside->glaze_inside_code }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            @forelse ($glaze_inside->colors ?? [] as $color)
                                                <span class="w-5 h-5 rounded-full border border-gray-300"
                                                    style="background-color: {{ $color->color_code }}"></span>
                                            @empty
                                                <span class="text-gray-400 text-sm">No colors</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button 
                                        {{-- @click="openEditModal({{ $glaze_inside->toJson() }})" --}}
                                            class="text-blue-600 hoverScale hover:text-blue-700">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>

                                        <button 
                                        @click="DeleteGlazeInsideModal = true; glazeInsideIdToDelete = {{ $glaze_inside->id }}; itemCodeToDelete = '{{ $glaze_inside->glaze_inside_code }}'"
                                        class="text-red-500 hoverScale hover:text-red-700">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No effects found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Inside pagination -->
                    <div class="mt-4 flex justify-end">
                        {{ $glaze_insides
                            ->appends(['outer_page' => request('outer_page')])  
                            ->links('vendor.pagination.tailwind-custom') }}
                    </div>               
                </div>                
            </div>

            <div>
                <!-- Filters -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-3">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-1"> 
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                                <input type="text" placeholder="Search"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                            </div>
                        </div>
                        <div class="md:col-span-2 flex flex-wrap items-center justify-end gap-4">
                            <button @click="openCreateModal()"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                                <span class="material-symbols-outlined">add</span>
                                <span>Add Glaze Outer</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-3 rounded-xl shadow-md overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                            <tr>
                                <th class="px-6 py-3">Glaze Outer Code</th>
                                <th class="px-6 py-3">Colors</th>
                                <th class="px-6 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
            
                        <tbody>
                            @forelse ($glaze_outers as $glaze_outer)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $glaze_outer->glaze_outer_code }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            @forelse ($glaze_outer->colors ?? [] as $color)
                                                <span class="w-5 h-5 rounded-full border border-gray-300"
                                                    style="background-color: {{ $color->color_code }}"></span>
                                            @empty
                                                <span class="text-gray-400 text-sm">No colors</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <button 
                                        {{-- @click="openEditModal({{ $glaze_outer->toJson() }})" --}}
                                            class="text-blue-600 hoverScale hover:text-blue-700">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>

                                        <button 
                                        @click="DeleteGlazeOuterModal = true; glazeOuterIdToDelete = {{ $glaze_outer->id }}; itemCodeToDelete = '{{ $glaze_outer->glaze_outer_code }}'"
                                        class="text-red-500 hoverScale hover:text-red-700">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No effects found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- Outer pagination -->
                    <div class="mt-4 flex justify-end">
                        {{ $glaze_outers
                            ->appends(['inside_page' => request('inside_page')]) 
                            ->links('vendor.pagination.tailwind-custom') }}
                    </div>              
                </div>
            </div>

        </div>

        {{-- include modal --}}
        @include('components.Edit-modals.edit-glazeInsideOuter')
        @include('components.Delete-modals.delete-glazeInsideOuter')
        @include('components.Create-modals.create-glazeInsideOuter')

    </main>
@endsection
