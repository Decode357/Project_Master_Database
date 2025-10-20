@extends('layouts.sidebar')
@section('title', 'Effect')
@section('header', 'Effect')
@section('content')
    <main class="flex-1 bg-gray-50 dark:bg-gray-900" x-data="effectPage()" x-init="initSelect2()">

        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-3 
            dark:bg-gray-800 dark:shadow-gray-900/50">
            <form method="GET" action="{{ route('effect.index') }}" class="flex flex-wrap items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1 min-w-64">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ITEM CODE or etc.."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent
                            dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" />
                    </div>
                </div>
                <!-- Search and Reset buttons -->
                <div class="flex gap-2">
                    <button type="submit" 
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hoverScale hover:bg-green-700">
                        <span class="material-symbols-outlined">search</span>
                        <span>Search</span>
                    </button>

                    <a href="{{ route('effect.index') }}" 
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
                <!-- Add Effect button -->
                <div class="ml-auto">
                    <button type="button" @click="openCreateModal()"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700">
                        <span class="material-symbols-outlined">add</span>
                        <span>Add</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="rounded-xl shadow-md bg-white
            dark:shadow-gray-900/50 dark:bg-gray-800">
            <div class="overflow-x-auto rounded-xl">
                <table class="w-full text-sm text-left text-gray-600
                    dark:text-gray-400">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b dark:border-gray-700
                        dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3">Effect ID</th>
                            <th class="px-6 py-3">Effect Code</th>
                            <th class="px-6 py-3">Effect Name</th>
                            <th class="px-6 py-3">Colors</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($effects as $effect)
                            <tr class="bg-white border-b hover:bg-gray-50 
                                dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $effect->id }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $effect->effect_code }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $effect->effect_name }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        @forelse ($effect->colors ?? [] as $color)
                                            <span class="w-5 h-5 rounded-full border border-gray-300 dark:border-gray-600"
                                                style="background-color: {{ $color->color_code }}"
                                                title="{{ $color->color_name }}"></span>
                                        @empty
                                            <span class="text-gray-400 text-sm dark:text-gray-500">No colors</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button @click="openEditModal({{ $effect->toJson() }})"
                                            class="text-blue-600 hover:text-blue-700">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>

                                    <button
                                        @click="DeleteEffectModal = true; effectIdToDelete = {{ $effect->id }}; itemCodeToDelete = '{{ $effect->effect_code }}'"
                                            class="text-red-500 hover:text-red-700">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-sm text-gray-500 text-center
                                    dark:text-gray-400">
                                    @if(request('search'))
                                        No effects found for "{{ request('search') }}".
                                    @else
                                        No effects found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4 flex justify-end">
                    {{ $effects->links('vendor.pagination.tailwind-custom') }}
                </div>
            </div>
        </div>
        {{-- include modal --}}
        @include('components.Edit-modals.edit-effect')
        @include('components.Delete-modals.delete-effect')
        @include('components.Create-modals.create-effect')

    </main>
@endsection
