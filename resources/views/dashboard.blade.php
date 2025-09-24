@extends('layouts.sidebar')
@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('content')
<main class="flex-1 bg-gray-50" x-data="{ CreateEffectModal: false, DeleteModal: false }">
    <!-- Filters -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6 ">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Search -->
            <div class="md:col-span-1">
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                    <input type="text" placeholder="Search by Effect ID or Name"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                </div>
            </div>
            <div class="md:col-span-2 flex flex-wrap items-center justify-end gap-4">
                <button @click="CreateEffectModal = true"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                    <span class="material-symbols-outlined">add</span>
                    <span>Add Effect</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">Effect ID</th>
                    <th class="px-6 py-3">Effect Name</th>
                    <th class="px-6 py-3">Colors</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>

            <!--test table-->
            <tbody>
                @php
                    $effects = [
                        ['id' => 'EF-001', 'name' => 'Glossy', 'colors' => ['red', 'blue', 'green']],
                        ['id' => 'EF-002', 'name' => 'Matte', 'colors' => ['gray', 'black']],
                        ['id' => 'EF-003', 'name' => 'Transparent', 'colors' => ['blue', 'cyan']],
                        ['id' => 'EF-004', 'name' => 'Metallic', 'colors' => ['gold', 'silver']],
                        ['id' => 'EF-005', 'name' => 'Pearl', 'colors' => ['pink', 'white', 'purple']],
                    ];
                @endphp

                @foreach ($effects as $effect)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $effect['id'] }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $effect['name'] }}</td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                @foreach ($effect['colors'] as $color)
                                    <span class="w-5 h-5 rounded-full border border-gray-300"
                                        style="background-color: {{ $color }}"></span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <button class="text-blue-600 hoverScale hover:text-blue-700">
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                            <button @click="DeleteModal = true" class="text-red-500 hoverScale hover:text-red-700">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between pt-4">
        <span class="text-sm text-gray-500">Showing 1 to 5 of 5 results</span>
        <div class="inline-flex items-center -space-x-px">
            <a href="#"
                class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-100 hover:text-gray-700">Previous</a>
            <a href="#"
                class="px-3 py-2 leading-tight text-blue-600 bg-blue-50 border border-gray-300 hover:bg-blue-100">1</a>
            <a href="#"
                class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-100 hover:text-gray-700">Next</a>
        </div>
    </div>
        {{-- include modal --}}
        @include('components.Delete-modal')
        @include('components.CreateEffect-modal')
</main>
@endsection