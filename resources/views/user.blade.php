@extends('layouts.sidebar')
@section('title', __('sidebar.user_management'))
@section('header', __('sidebar.user_management'))
@section('content')
    <main class="flex-1 bg-gray-50 dark:bg-gray-900" x-data="userPage()" x-init="initSelect2()">
        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-3 
            dark:bg-gray-800 dark:shadow-gray-900/50">
            <form method="GET" action="{{ route('user') }}" class="flex flex-wrap items-end gap-4">
                <!-- Search Input -->
                <div class="flex-1 min-w-64">
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('content.search_by') }}{{ __('content.name') }},{{__('content.email')}}{{ __('content.etc') }}"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent
                            dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100" />
                    </div>
                </div>
                <!-- Search and Reset buttons -->
                <div class="flex gap-2">
                    <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hoverScale hover:bg-green-700">
                        <span class="material-symbols-outlined">search</span>
                        <span>{{ __('content.search') }}</span>
                    </button>

                    <a href="{{ route('user') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hoverScale hover:bg-gray-300
                        dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500">
                        <span class="material-symbols-outlined">refresh</span>
                        <span>{{ __('content.reset') }}</span>
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
                <!-- Add User button -->
                @if ($hasManageUser)
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
                <table class="w-full text-sm text-left text-gray-600
                    dark:text-gray-400">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b dark:border-gray-700
                        dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-3 py-3 w-[180px]">{{ __('content.name') }}</th>
                            <th class="px-3 py-3 w-[240px]">{{ __('content.email') }}</th>
                            <th class="px-3 py-3 w-[180px]">{{ __('auth.role') }}</th>
                            <th class="px-3 py-3 w-[436px]">{{ __('auth.permission') }}</th>
                            <th class="px-3 py-3">{{ __('content.department') }}</th>
                            <th class="px-3 py-3">{{ __('content.requestor') }}</th>
                            <th class="px-3 py-3">{{ __('content.customer') }}</th>
                            <th class="px-3 py-3 text-right max-w-[80px]">{{ __('content.action') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            <tr class="bg-white border-b max-h-[60px] hover:bg-gray-50
                                dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                                <td class="px-3 py-3 font-medium text-gray-900 dark:text-gray-100">{{ Str::limit($user->name, 20) }}</td>
                                <td class="px-3 py-3 font-medium text-gray-900 dark:text-gray-100">{{ Str::limit($user->email, 30) }}</td>
                                <td class="px-3 py-3">
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full
                                            dark:bg-blue-900 dark:text-blue-300">
                                            {{ __('auth.' . $role->name) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-3 py-3">
                                    @foreach ($user->permissions as $perm)
                                        <span
                                            class="inline-block {{ $permissionColors[$perm->name] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }} text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ __('auth.' . $perm->name) }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-3 py-3 dark:text-gray-300">{{ $user->department?->name ?? '' }}</td>
                                <td class="px-3 py-3 dark:text-gray-300">{{ $user->requestor?->name ?? '' }}</td>
                                <td class="px-3 py-3 dark:text-gray-300">{{ $user->customer?->name ?? '' }}</td>
                                @php
                                    $currentUser = Auth::user();
                                    $currentRole = $currentUser->roles->pluck('name')->first();
                                    $rowRole = $user->roles->pluck('name')->first();
                                @endphp
 
                                @if ($hasManageUser&& ($currentRole === 'superadmin' || $rowRole !== 'superadmin') && $user->id !== auth()->id())
                                    <td class="text-right space-x-2 max-w-[80px]">
                                        <button @click="openEditModal({{ $user->toJson() }})"
                                            class="text-blue-600 hover:text-blue-700">
                                            <span class="material-symbols-outlined">edit</span>
                                        </button>

                                        <button
                                            @click="DeleteUserModal = true; userIdToDelete = {{ $user->id }}; userNameToDelete = '{{ $user->name }}'"
                                            class="text-red-500 hover:text-red-700">
                                            <span class="material-symbols-outlined mr-2">delete</span>
                                        </button>
                                    </td>
                                @else
                                    <td class="text-right max-w-[80px]"></td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-6 py-4 text-sm text-gray-500 text-center
                                    dark:text-gray-400">
                                    @if (request('search'))
                                        {{ __('content.not_found') }} "{{ request('search') }}".
                                    @else
                                        {{ __('content.not_found') }}
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Pagination -->
        <div class="mt-4 flex justify-end pb-2">
            {{ $users->links('vendor.pagination.tailwind-custom') }}
        </div>

        {{-- include modal --}}
        @include('components.Create-modals.create-user')
        @include('components.Edit-modals.edit-user')
        <x-modals.delete-modal 
            show="DeleteUserModal"
            itemName="userNameToDelete"
            deleteFunction="deleteUser"
        />    
    </main>
@endsection
