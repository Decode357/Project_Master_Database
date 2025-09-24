<div x-show="CreateUserModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h2 class="text-xl font-semibold mb-4">Create User</h2>
        <hr class="mb-3">

        <form method="POST" action="{{ route('user.store') }}" class="space-y-4" x-data="{
            newUser: { department_id: '', requestor_id: '', customer_id: '' },
            role: 'user',
            permissions: ['view'],
            allPermissions: ['view', 'edit', 'delete', 'create', 'file import', 'manage users'],
            currentUserRole: '{{ Auth::user()->roles->pluck('name')->first() }}', // <-- เพิ่มตรงนี้
            updatePermissions() {
                if (!this.permissions.includes('view')) this.permissions.push('view');
                if (this.role === 'user') this.permissions = ['view'];
                else if (this.role === 'superadmin') this.permissions = [...this.allPermissions];
            },
            isDisabled(permission) {
                return permission === 'view' || this.role === 'superadmin' || this.role === 'user' && permission !== 'view';
            },
            getOpacity(permission) {
                return permission === 'view' ? 'opacity-100' : (this.role === 'user' ? 'opacity-50' : '');
            },
            getRingColor(permission) {
                return permission === 'view' ? 'ring-red-500' : (this.role === 'superadmin' ? 'ring-red-500' : 'ring-blue-500');
            }
        }"
            x-init="updatePermissions()">


            @csrf

            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="name" placeholder="Enter username"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" placeholder="Enter email"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
            </div>

            <!-- Password -->
            <div x-data="{ show: false }" class="relative">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input :type="show ? 'text' : 'password'" name="password" placeholder="Enter password"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 mt-6 text-gray-500 hover:text-gray-700">
                    <span x-show="!show" class="material-symbols-outlined">visibility</span>
                    <span x-show="show" class="material-symbols-outlined">visibility_off</span>
                </button>
            </div>

            <!-- Department / Requestor / Customer -->
            <div class="flex flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Department</label>
                    <select x-model="newUser.department_id" class="w-full border rounded px-2 py-1">
                        <option value="">-</option>
                        @foreach ($departments as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="department_id" :value="newUser.department_id">
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Requestor</label>
                    <select x-model="newUser.requestor_id" class="w-full border rounded px-2 py-1">
                        <option value="">-</option>
                        @foreach ($requestors as $req)
                            <option value="{{ $req->id }}">{{ $req->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="requestor_id" :value="newUser.requestor_id">
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Customer</label>
                    <select x-model="newUser.customer_id" class="w-full border rounded px-2 py-1">
                        <option value="">-</option>
                        @foreach ($customers as $cust)
                            <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="customer_id" :value="newUser.customer_id">
                </div>
            </div>

            <!-- Role selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <div class="flex items-center justify-center rounded-full bg-gray-100 p-1">
                    <template x-for="r in ['user','admin','superadmin']" :key="r">
                        <label
                            :class="{
                                'bg-white text-gray-900 shadow-sm': role === r,
                                'text-gray-500 cursor-not-allowed opacity-50': r === 'superadmin' &&
                                    currentUserRole === 'admin'
                            }"
                            class="flex-1 items-center justify-center rounded-full px-4 py-2 text-sm font-medium transition-colors flex cursor-pointer">
                            <input type="radio" name="role" :value="r" class="sr-only" x-model="role"
                                :disabled="r === 'superadmin' && currentUserRole === 'admin'"
                                @change="updatePermissions()" />
                            <span x-text="r.charAt(0).toUpperCase() + r.slice(1)"></span>
                        </label>
                    </template>
                </div>
            </div>

            <!-- Permissions -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mt-2">Permissions</label>
                <div class="flex flex-wrap gap-2 mt-1">
                    @php
                        $permColors = [
                            'view' => 'bg-yellow-100 text-yellow-800',
                            'edit' => 'bg-blue-100 text-blue-800',
                            'delete' => 'bg-red-100 text-red-800',
                            'create' => 'bg-green-100 text-green-800',
                            'file import' => 'bg-gray-100 text-gray-800',
                            'manage users' => 'bg-purple-100 text-purple-800',
                        ];
                    @endphp
                    @foreach (['view', 'edit', 'delete', 'create', 'file import', 'manage users'] as $perm)
                        <label class="flex items-center gap-1 cursor-pointer"
                            :class="getOpacity('{{ $perm }}')">
                            <input type="checkbox" name="permissions[]" value="{{ $perm }}" class="sr-only peer"
                                x-model="permissions" :disabled="isDisabled('{{ $perm }}')" />
                            <span
                                class="inline-block {{ $permColors[$perm] }} text-xs font-medium px-2.5 py-0.5 rounded-full
                                peer-checked:ring-2 cursor-pointer"
                                :class="getRingColor('{{ $perm }}')">
                                {{ $perm }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="CreateUserModal = false"
                    class="px-4 py-2 rounded-md bg-gray-200 hoverScale hover:bg-red-500 hover:text-white">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 rounded-md bg-blue-600 text-white hoverScale hover:bg-blue-700">Create</button>
            </div>

            <!-- Debug buttons -->
            {{-- <div class="mt-4 flex flex-col gap-2">
                <button type="button" 
                    @click="alert(JSON.stringify({role: role, permissions: permissions}))"
                    class="px-3 py-1 rounded bg-gray-300 text-sm">🔍 Debug Role & Permissions</button>

                <button type="button" 
                    @click="alert(JSON.stringify(newUser))"
                    class="px-3 py-1 rounded bg-gray-300 text-sm">🔍 Debug Department/Requestor/Customer</button>
            </div> --}}

        </form>
    </div>
</div>
