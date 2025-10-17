@extends('layouts.sidebar')
@section('title', 'Glaze inside/outer')
@section('header', 'Glaze inside/outer')
@section('content')
    <main class="flex-1 bg-gray-50" x-data="glazeInsideOuterPage()" x-init="initSelect2()">
        <!-- Tables -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Glaze Inside -->
            <div>
                <!-- Inside Filters -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-3">
                    <form method="GET" action="{{ route('glaze.inside.outer.index') }}"
                        class="flex flex-wrap items-end gap-4">
                        <!-- Preserve outer search params -->
                        <input type="hidden" name="outer_search" value="{{ request('outer_search') }}">
                        <input type="hidden" name="outer_per_page" value="{{ request('outer_per_page') }}">
                        <input type="hidden" name="outer_page" value="{{ request('outer_page') }}">

                        <!-- Search -->
                        <div class="flex-1 min-w-64">
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                                <input type="text" name="inside_search" value="{{ request('inside_search') }}"
                                    placeholder="Search Inside Code..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                            </div>
                        </div>
                        <!-- Search and Reset buttons -->
                        <div class="flex gap-2">
                            <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hoverScale hover:bg-green-700 transition">
                                <span class="material-symbols-outlined">search</span>
                            </button>

                            <a href="{{ route('glaze.inside.outer.index', [
                                'outer_search' => request('outer_search'),
                                'outer_per_page' => request('outer_per_page'),
                                'outer_page' => request('outer_page')
                            ]) }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hoverScale hover:bg-gray-300 transition">
                                <span class="material-symbols-outlined">refresh</span>
                            </a>
                        </div>
                        <!-- Per Page -->
                        <div>
                            <select name="inside_per_page" onchange="this.form.submit()"
                                class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="5" {{ request('inside_per_page') == 5 ? 'selected' : '' }}>5 Items
                                </option>
                                <option value="10"
                                    {{ request('inside_per_page') == 10 || !request('inside_per_page') ? 'selected' : '' }}>
                                    10 Items</option>
                                <option value="25" {{ request('inside_per_page') == 25 ? 'selected' : '' }}>25 Items
                                </option>
                                <option value="50" {{ request('inside_per_page') == 50 ? 'selected' : '' }}>50 Items
                                </option>
                                <option value="100" {{ request('inside_per_page') == 100 ? 'selected' : '' }}>100 Items
                                </option>
                            </select>
                        </div>
                        <!-- Add Inside button -->
                        <div class="ml-auto">
                            <button type="button" @click="openCreateInsideModal()"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                                <span class="material-symbols-outlined">add</span>
                                <span>Add Inside</span>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Inside Table -->
                <div class=" rounded-xl p-3 shadow-md bg-white">
                    <div class="overflow-x-auto rounded-xl">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Code</th>
                                    <th class="px-4 py-3">Colors</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($glaze_insides as $glaze_inside)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">
                                            {{ $glaze_inside->glaze_inside_code }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-1 flex-wrap">
                                                @forelse ($glaze_inside->colors ?? [] as $color)
                                                    <span class="w-4 h-4 rounded-full border border-gray-300"
                                                        style="background-color: {{ $color->color_code }}"
                                                        title="{{ $color->color_name }}"></span>
                                                @empty
                                                    <span class="text-gray-400 text-xs">No colors</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex justify-end gap-1">
                                                <button @click="openEditInsideModal({{ $glaze_inside->toJson() }})"
                                                    class="text-blue-600 hover:text-blue-700 p-1">
                                                    <span class="material-symbols-outlined">edit</span>
                                                </button>
                                                <button
                                                    @click="DeleteGlazeInsideModal = true; glazeInsideIdToDelete = {{ $glaze_inside->id }}; itemCodeToDelete = '{{ $glaze_inside->glaze_inside_code }}'"
                                                    class="text-red-500 hover:text-red-700 p-1">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                                            @if (request('inside_search'))
                                                No results found for "{{ request('inside_search') }}"
                                            @else
                                                No glaze inside found
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Inside pagination -->
                        <div class="mt-4 flex justify-end">
                            {{ $glaze_insides->links('vendor.pagination.tailwind-custom') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Glaze Outer -->
            <div>
                <!-- Outer Filters -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-3">
                    <form method="GET" action="{{ route('glaze.inside.outer.index') }}"
                        class="flex flex-wrap items-end gap-4">
                        <!-- Preserve inside search params -->
                        <input type="hidden" name="inside_search" value="{{ request('inside_search') }}">
                        <input type="hidden" name="inside_per_page" value="{{ request('inside_per_page') }}">
                        <input type="hidden" name="inside_page" value="{{ request('inside_page') }}">

                        <!-- Search -->
                        <div class="flex-1 min-w-64">
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                                <input type="text" name="outer_search" value="{{ request('outer_search') }}"
                                    placeholder="Search Outer Code..."
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                            </div>
                        </div>
                        <!-- Search and Reset buttons -->
                        <div class="flex gap-2">
                            <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hoverScale hover:bg-green-700 transition">
                                <span class="material-symbols-outlined">search</span>
                            </button>

                            <a href="{{ route('glaze.inside.outer.index', [
                                'inside_search' => request('inside_search'),
                                'inside_per_page' => request('inside_per_page'),
                                'inside_page' => request('inside_page')
                            ]) }}"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hoverScale hover:bg-gray-300 transition">
                                <span class="material-symbols-outlined">refresh</span>
                            </a>
                        </div>
                        <!-- Per Page -->
                        <div>
                            <select name="outer_per_page" onchange="this.form.submit()"
                                class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="5" {{ request('outer_per_page') == 5 ? 'selected' : '' }}>5 Items
                                </option>
                                <option value="10"
                                    {{ request('outer_per_page') == 10 || !request('outer_per_page') ? 'selected' : '' }}>
                                    10 Items</option>
                                <option value="25" {{ request('outer_per_page') == 25 ? 'selected' : '' }}>25 Items
                                </option>
                                <option value="50" {{ request('outer_per_page') == 50 ? 'selected' : '' }}>50 Items
                                </option>
                                <option value="100" {{ request('outer_per_page') == 100 ? 'selected' : '' }}>100 Items
                                </option>
                            </select>
                        </div>
                        <!-- Add Outer button -->
                        <div class="ml-auto">
                            <button type="button" @click="openCreateOuterModal()"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                                <span class="material-symbols-outlined">add</span>
                                <span>Add Outer</span>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- Outer Table -->
                <div class=" rounded-xl p-3 shadow-md bg-white">
                    <div class="overflow-x-auto rounded-xl">
                        <table class="w-full text-sm text-left text-gray-600">
                            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Code</th>
                                    <th class="px-4 py-3">Colors</th>
                                    <th class="px-4 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($glaze_outers as $glaze_outer)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">
                                            {{ $glaze_outer->glaze_outer_code }}
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="flex gap-1 flex-wrap">
                                                @forelse ($glaze_outer->colors ?? [] as $color)
                                                    <span class="w-4 h-4 rounded-full border border-gray-300"
                                                        style="background-color: {{ $color->color_code }}"
                                                        title="{{ $color->color_name }}"></span>
                                                @empty
                                                    <span class="text-gray-400 text-xs">No colors</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <div class="flex justify-end gap-1">
                                                <button @click="openEditOuterModal({{ $glaze_outer->toJson() }})"
                                                    class="text-blue-600 hover:text-blue-700 p-1">
                                                    <span class="material-symbols-outlined">edit</span>
                                                </button>
                                                <button
                                                    @click="DeleteGlazeOuterModal = true; glazeOuterIdToDelete = {{ $glaze_outer->id }}; itemCodeToDelete = '{{ $glaze_outer->glaze_outer_code }}'"
                                                    class="text-red-500 hover:text-red-700 p-1">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-4 py-8 text-center text-gray-500">
                                            @if (request('outer_search'))
                                                No results found for "{{ request('outer_search') }}"
                                            @else
                                                No glaze outer found
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Outer pagination -->
                        <div class="mt-4 flex justify-end">
                            {{ $glaze_outers->links('vendor.pagination.tailwind-custom') }}
                        </div>
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
