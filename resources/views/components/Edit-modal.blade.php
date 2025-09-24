<!-- Edit User Modal -->
<div x-show="EditUserModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6" x-data="{
        role: 'user',
        permissions: ['view'],
        allPermissions: ['view', 'edit', 'delete', 'create', 'file import', 'manage users'],
        newUser: {
            department_id: '',
            requestor_id: '',
            customer_id: ''
        },
        updatePermissions() {
            if (!this.permissions.includes('view')) this.permissions.push('view');
            if (this.role === 'user') this.permissions = ['view'];
            else if (this.role === 'superadmin') this.permissions = [...this.allPermissions];
        },
    }" x-init="$watch('userToEdit', value => {
        if (value) {
            role = value.role || 'user';
            permissions = value.permissions || ['view'];
    
            newUser.department_id = value.department_id || '';
            newUser.requestor_id = value.requestor_id || '';
            newUser.customer_id = value.customer_id || '';
    
            updatePermissions();
        }
    })">

        <h2 class="text-xl font-semibold mb-4">Edit User</h2>
        <hr class="mb-3">

        <form :action="`/user/${userToEdit.id}`" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" name="name" x-model="userToEdit.name"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" x-model="userToEdit.email"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
            </div>

            <!-- Department / Requestor / Customer -->
            <div class="flex flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Department</label>
                    <select x-model="userToEdit.department_id" class="w-full border rounded px-2 py-1">
                        <option value="">-</option>
                        @foreach ($departments as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="department_id" :value="userToEdit.department_id">
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Requestor</label>
                    <select x-model="userToEdit.requestor_id" class="w-full border rounded px-2 py-1">
                        <option value="">-</option>
                        @foreach ($requestors as $req)
                            <option value="{{ $req->id }}">{{ $req->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="requestor_id" :value="userToEdit.requestor_id">
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1">Customer</label>
                    <select x-model="userToEdit.customer_id" class="w-full border rounded px-2 py-1">
                        <option value="">-</option>
                        @foreach ($customers as $cust)
                            <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                        @endforeach

                    </select>
                    <input type="hidden" name="customer_id" :value="userToEdit.customer_id">
                </div>
            </div>


            <!-- Role selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Role</label>
                <div class="flex items-center justify-center rounded-full bg-gray-100 p-1">
                    <template x-for="r in ['user','admin','superadmin']" :key="r">
                        <label :class="role === r ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500'"
                            class="flex-1 cursor-pointer items-center justify-center rounded-full px-4 py-2 text-sm font-medium transition-colors flex">
                            <input type="radio" name="role" :value="r" class="sr-only" x-model="role"
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

                    <template x-for="perm in permissions" :key="perm">
                        <input type="hidden" name="permissions[]" :value="perm">
                    </template>

                    @foreach (['view', 'edit', 'delete', 'create', 'file import', 'manage users'] as $perm)
                        <label class="flex items-center gap-1 cursor-pointer"
                            :class="(role === 'user' && '{{ $perm }}'
                                !== 'view') ? 'opacity-50' : ''">
                            <input type="checkbox" class="sr-only peer"
                                :checked="permissions.includes('{{ $perm }}')"
                                @change="
                                if($event.target.checked){
                                    if(!permissions.includes('{{ $perm }}')) permissions.push('{{ $perm }}');
                                } else {
                                    permissions = permissions.filter(p => p !== '{{ $perm }}');
                                }
                            "
                                :disabled="role === 'superadmin' || (role==='user' && '{{ $perm }}'
                                !== 'view') || '{{ $perm }}'
                                === 'view'" />
                            <span
                                class="inline-block {{ $permColors[$perm] }} text-xs font-medium px-2.5 py-0.5 rounded-full peer-checked:ring-2 cursor-pointer"
                                :class="role === 'superadmin' ? 'ring-2 ring-red-500' : ('{{ $perm }}'
                                    === 'view' ? 'ring-2 ring-red-500' : 'ring-blue-500')">
                                {{ $perm }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditUserModal = false"
                    class="px-4 py-2 rounded-md bg-gray-200 hoverScale hover:bg-red-500 hover:text-white">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 rounded-md bg-blue-600 text-white hoverScale hover:bg-blue-700">Save</button>
            </div>

            {{-- <!-- Debug button -->
            <div class="mt-4 flex flex-col gap-2">
                <button type="button" @click="alert(JSON.stringify({role: role, permissions: permissions}, null, 2))"
                    class="px-3 py-1 rounded bg-gray-300 text-sm">🔍 Debug Role & Permissions</button>
                <button type="button" @click="alert(JSON.stringify(newUser, null, 2))"
                    class="px-3 py-1 rounded bg-gray-300 text-sm">🔍 Debug Department/Requestor/Customer</button>
            </div> --}}

        </form>
    </div>
