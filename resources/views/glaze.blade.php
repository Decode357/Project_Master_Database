@extends('layouts.sidebar')
@section('title', __('sidebar.glazes'))
@section('header', __('sidebar.glazes'))
@section('content')
    <main class="flex-1 bg-gray-50 dark:bg-gray-900" x-data="glazePage()" x-init="initSelect2()">
        <!-- Filters -->
        <div class="dark:bg-gray-800 dark:shadow-gray-900/50 bg-white p-6 rounded-lg shadow-md mb-3">
            <form method="GET" action="{{ route('glaze.index') }}" class="flex flex-wrap items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1 min-w-64">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('content.search_by') }}{{ __('content.glaze_code') }}{{ __('content.etc') }}"
                            class="dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    </div>
                </div>
                <!-- Search and Reset buttons -->
                <div class="flex gap-2">
                    <button type="submit" 
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hoverScale hover:bg-green-700">
                        <span class="material-symbols-outlined">search</span>
                        <span>{{ __('content.search') }}</span>
                    </button>

                    <a href="{{ route('glaze.index') }}" 
                            class="dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500 flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hoverScale hover:bg-gray-300">
                        <span class="material-symbols-outlined">refresh</span>
                        <span>{{ __('content.reset') }}</span>
                    </a>
                </div>        
                <!-- Items per page select -->
                <div>
                    <select name="per_page" onchange="this.form.submit()" 
                            class="dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 w-32 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5 {{ __('content.items') }}</option>
                        <option value="10" {{ request('per_page') == 10 || !request('per_page') ? 'selected' : '' }}>10 {{ __('content.items') }}</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 {{ __('content.items') }}</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 {{ __('content.items') }}</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 {{ __('content.items') }}</option>
                    </select>
                </div>
                <!-- Add Glaze button -->
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
        <div class="dark:shadow-gray-900/50 dark:bg-gray-800 rounded-xl shadow-md bg-white">
            <div class="overflow-x-auto rounded-xl">
                <table class="min-w-full text-sm">
                    <thead class="dark:bg-gray-700 dark:border-gray-700 text-xs text-gray-500 uppercase bg-gray-50 border-b">
                        <tr class="dark:text-gray-400 text-gray-700">
                            <th class="px-4 py-3 text-left">{{ __('content.glaze_code') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('content.inside_color_code') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('content.outside_color_code') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('content.effect_code') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('content.fire_temp') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('content.status') }}</th>
                            <th class="px-4 py-3 text-right">{{ __('content.updated_by') }}</th>
                            <th class="px-4 py-3 text-end w-[80px]">{{ __('content.action') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($glazes as $glaze)
                            @php
                                $statusText = $glaze->status->status ?? 'Unknown';
                                $statusColor = match ($statusText) {
                                    'Pending' => 'bg-yellow-100 text-yellow-800',
                                    'Rejected' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <tr class="dark:text-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 bg-white border-b border-gray-200 hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $glaze->glaze_code }}</td>
                                <td class="px-4 py-3">{{ $glaze->glazeInside->glaze_inside_code ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $glaze->glazeOuter->glaze_outer_code ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $glaze->effect->effect_code ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    {{ $glaze->fire_temp ? $glaze->fire_temp . ' °C' : '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="{{ $statusColor }} px-2 py-1 rounded-full text-xs font-semibold">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $glaze->updater->name ?? 'System' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-1">
                                        <button @click="openDetailModal({{ $glaze->toJson() }})"
                                            class="flex items-center gap-1 px-2 py-1 text-sm font-medium text-white bg-blue-500 rounded-lg shadow-sm hover:bg-green-600 hover:shadow-md hoverScale">
                                            <span class="material-symbols-outlined text-white">feature_search</span>
                                        </button>
                                        @if ($hasEdit)
                                            <button @click="openEditModal({{ $glaze->toJson() }})"
                                                class="text-blue-600 hover:text-blue-700">
                                                <span class="material-symbols-outlined">edit</span>
                                            </button>
                                        @endif
                                        @if ($hasDelete)
                                            <button @click="DeleteGlazeModal = true; glazeIdToDelete = {{ $glaze->id }}; itemCodeToDelete = '{{ $glaze->glaze_code }}'"
                                                class="text-red-500 hover:text-red-700">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-4 text-sm text-center text-gray-500 dark:text-gray-400">
                                    @if(request('search'))
                                        No glazes found for "{{ request('search') }}".
                                    @else
                                        No glazes found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4 flex justify-end pb-2">
                    {{ $glazes->links('vendor.pagination.tailwind-custom') }}
                </div>
            </div>
        </div>
        {{-- include modal --}}
        @include('components.Create-modals.create-glaze')
        @include('components.Edit-modals.edit-glaze')
        @include('components.Detail-modals.detail-glaze')
        <x-modals.delete-modal 
            show="DeleteGlazeModal"
            itemName="itemCodeToDelete"
            deleteFunction="deleteGlaze"
        />    
    </main>
@endsection
