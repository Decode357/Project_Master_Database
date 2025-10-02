@extends('layouts.sidebar')
@section('title', 'User Management')
@section('header', 'User Management')
@section('content')
    <main class="flex-1 bg-gray-50" x-data="{
        CreateUserModal: false,
        DeleteUserModal: false,
        EditUserModal: false,
        userIdToDelete: null,
        userNameToDelete: '',
        userToEdit: {}
    }">

        <!-- Filters -->
        <div class="bg-white p-6 rounded-lg shadow-md mb-3 ">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search -->
                <div class="md:col-span-1">
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input type="text" placeholder="Search by username or role"
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                    </div>
                </div>
                @php
                    use Spatie\Permission\Models\Permission;
                    use Illuminate\Support\Facades\Auth;

                    $user = Auth::user();
                    $hasManageUsers = $user->getDirectPermissions()->pluck('name')->contains('manage users');
                @endphp

                @if ($hasManageUsers)
                    <div class="md:col-span-2 flex flex-wrap items-center justify-end gap-4">
                        <button @click="CreateUserModal = true"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hoverScale hover:bg-blue-700 transition">
                            <span class="material-symbols-outlined">add</span>
                            <span>Create User</span>
                        </button>
                    </div>
                @endif

            </div>
        </div>

        <!-- Table -->
        <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 w-[40px]">ID</th>
                        <th class="px-3 py-3 w-[180px]">Name</th>
                        <th class="px-3 py-3 w-[220px]">Email</th>
                        <th class="px-3 py-3 w-[80px]">Password</th>
                        <th class="px-3 py-3 w-[120px]">Role</th>
                        <th class="px-3 py-3 w-[436px]">Permission</th>
                        <th class="px-3 py-3">Department</th>
                        <th class="px-3 py-3">Requestor</th>
                        <th class="px-3 py-3">Customer</th>
                        <th class="px-3 py-3 text-right max-w-[80px]">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $user)
                        <tr class="bg-white border-b max-h-[60px] hover:bg-gray-50">
                            <td class="px-3 py-3 font-medium text-gray-900">{{ $user->id }}</td>
                            <td class="px-3 py-3 font-medium text-gray-900">{{ Str::limit($user->name, 15) }}</td>
                            <td class="px-3 py-3 font-medium text-gray-900">{{ Str::limit($user->email, 20) }}</td>

                            <td class="px-3 py-3">********</td>
                            <td class="px-3 py-3">
                                @foreach ($user->roles as $role)
                                    <span
                                        class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-3 py-3 space-x-1">
                                @foreach ($user->permissions as $perm)
                                    <span
                                        class="inline-block {{ $permissionColors[$perm->name] ?? 'bg-gray-100 text-gray-800' }} text-xs font-medium px-2.5 py-0.5 rounded-full">
                                        {{ $perm->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-3 py-3">{{ $user->department?->name ?? '' }}</td>
                            <td class="px-3 py-3">{{ $user->requestor?->name ?? '' }}</td>
                            <td class="px-3 py-3">{{ $user->customer?->name ?? '' }}</td>
                            @php
                                $currentUser = Auth::user();
                                $currentRole = $currentUser->roles->pluck('name')->first(); // สมมติผู้ใช้มี role แค่ role เดียว
                                $rowRole = $user->roles->pluck('name')->first();
                            @endphp

                            @if ($hasManageUsers && ($currentRole === 'superadmin' || $rowRole !== 'superadmin') && $user->id !== auth()->id())
                                <td class="text-right space-x-2 max-w-[80px]">
                                    <button
                                        @click="
                                            EditUserModal = true; 
                                            userToEdit = { 
                                                id: {{ $user->id }}, 
                                                name: '{{ addslashes($user->name) }}', 
                                                email: '{{ addslashes($user->email) }}', 
                                                role: '{{ $user->roles->pluck('name')->first() ?? 'user' }}',
                                                permissions: {{ $user->getDirectPermissions()->pluck('name')->toJson() }},
                                                department_id: {{ $user->department_id ?? 'null' }},
                                                requestor_id: {{ $user->requestor_id ?? 'null' }},
                                                customer_id: {{ $user->customer_id ?? 'null' }}
                                            }; 
                                            $nextTick(() => { updatePermissions(); });
                                        "
                                        class="text-blue-600 hoverScale hover:text-blue-700">
                                        <span class="material-symbols-outlined">edit</span>
                                    </button>

                                    <button
                                        @click="DeleteUserModal = true; userIdToDelete = {{ $user->id }}; userNameToDelete = '{{ $user->name }}'"
                                        class="text-red-500 hoverScale hover:text-red-700">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </td>
                            @else
                                <td class="text-right max-w-[80px]"></td>
                            @endif

                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-end">
            {{ $users->links('vendor.pagination.tailwind-custom') }}
        </div>

        {{-- include modal --}}
        @include('components.Delete-modal')
        @include('components.Create-modals.CreateUser-modal')
        @include('components.Edit-modal')
    </main>
@endsection
