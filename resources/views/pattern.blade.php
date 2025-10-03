@extends('layouts.sidebar')
@section('title', 'Pattern')
@section('header', 'Pattern')
@section('content')
    <main x-data="patternPage()" x-init="initSelect2()">
        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-3">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div class="md:col-span-1">
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" placeholder="Search by ITEM CODE or etc.."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                    </div>
                </div>

                <!-- Add Button -->
                <div class="md:col-span-2 flex justify-end items-center gap-4">
                    <button @click="CreatePatternModal = true"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                        <span class="material-symbols-outlined">add</span>
                        <span>Add Pattern</span>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ITEM CODE</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">In Glaze</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">On Glaze</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Under Glaze</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Approval Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">UPDATED BY</th>
                            <th class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">ACTION</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($patterns as $pattern)
                            @php
                                $statusText = $pattern->status->status ?? 'Unknown';
                                $statusColor = match ($statusText) {
                                    'Approved' => 'bg-green-100 text-green-800',
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'Rejected' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp

                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pattern->pattern_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pattern->pattern_name }}</td>

                                <!-- Glaze icons -->
                                <td class="px-6 py-4 text-center">
                                    @if ($pattern->in_glaze)
                                        <span class="material-symbols-outlined text-green-500">radio_button_checked</span>
                                    @else
                                        <span class="material-symbols-outlined text-gray-500">radio_button_unchecked</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($pattern->on_glaze)
                                        <span class="material-symbols-outlined text-green-500">radio_button_checked</span>
                                    @else
                                        <span class="material-symbols-outlined text-gray-500">radio_button_unchecked</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($pattern->under_glaze)
                                        <span class="material-symbols-outlined text-green-500">radio_button_checked</span>
                                    @else
                                        <span class="material-symbols-outlined text-gray-500">radio_button_unchecked</span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="{{ $statusColor }} px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ $statusText }}
                                    </span>
                                </td>

                                <!-- Approval Date -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $pattern->approval_date?->format('d/m/Y') ?? '-' }}
                                </td>
                                <!-- UPDATED BY -->
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pattern->updater->name ?? 'System' }}</td>

                                <!-- Action -->
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <button
                                            class="flex items-center gap-1 px-2 py-1 text-sm font-medium text-white 
                                        bg-blue-500 rounded-lg shadow-sm hover:bg-green-600 hover:shadow-md 
                                        transition-all duration-200 hoverScale">
                                            <span class="material-symbols-outlined text-white">feature_search</span>
                                            <span>Detail</span>
                                        </button>

                                        <button class="text-blue-600 hoverScale hover:text-blue-700">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>

                                        <button @click="DeletePatternModal = true; patternIdToDelete = {{ $pattern->id }}; itemCodeToDelete = '{{ $pattern->pattern_code }}'"
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
                        {{ $patterns->links('vendor.pagination.tailwind-custom') }}
                </div>
            </div>
        </div>

        @include('components.Delete-modals.delete-pattern')
        @include('components.Create-modals.create-pattern')
    </main>
@endsection

