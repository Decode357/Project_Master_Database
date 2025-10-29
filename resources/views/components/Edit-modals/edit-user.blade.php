<!-- Edit User Modal -->
<script src="{{ asset('js/modals/edit-user-modal.js') }}"></script>

<div id="EditUserModal" 
    x-show="EditUserModal" 
    x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
    style="display: none;">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg p-6" 
        x-data="{
            ...editUserModal(),
            errors: {},
            loading: false,
            allPermissions: ['view', 'edit', 'delete', 'create', 'file import', 'manage users'],
            currentUserRole: '{{ Auth::user()->roles->pluck('name')->first() }}', // เพิ่มตรงนี้
            updatePermissions() {
                if (!this.permissions.includes('view')) this.permissions.push('view');
                if (this.role === 'user') this.permissions = ['view'];
                else if (this.role === 'superadmin') this.permissions = [...this.allPermissions];
            },
            isDisabled(permission) {
                return permission === 'view' || this.role === 'superadmin' || (this.role === 'user' && permission !== 'view');
            },
            getOpacity(permission) {
                return permission === 'view' ? 'opacity-100' : (this.role === 'user' ? 'opacity-50' : '');
            },
            getRingColor(permission) {
                return permission === 'view' ? 'ring-red-500' : (this.role === 'superadmin' ? 'ring-red-500' : 'ring-blue-500');
            }
        }" 
        x-init="init();
            $watch('role', (newRole, oldRole) => {
                if (oldRole && newRole !== oldRole) {
                    updatePermissions();
                }
            });
        ">

        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{__('content.edit_user')}}</h2>
        <hr class="mb-3 border-gray-200 dark:border-gray-600">

        <!-- Dynamic Error Display Area -->
        <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 rounded-md mb-4">
            <h4 class="text-red-800 dark:text-red-200 font-semibold">{{__('content.please_correct_errors')}}</h4>
            <ul class="mt-2 text-red-700 dark:text-red-300 text-sm list-disc list-inside">
                <template x-for="(error, field) in errors" :key="field">
                    <li x-text="error[0] || error"></li>
                </template>
            </ul>
        </div>

        <form @submit.prevent="submitEditForm" class="space-y-4">
            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.username')}}</label>
                <input type="text" name="name" x-model="userToEdit.name" placeholder="{{__('content.enter')}}{{__('content.username')}}"
                    :class="errors.name ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <p x-show="errors.name" x-text="errors.name ? (Array.isArray(errors.name) ? errors.name[0] : errors.name) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.email')}}</label>
                <input type="email" name="email" x-model="userToEdit.email" placeholder="{{__('content.enter')}}{{__('content.email')}}"
                    :class="errors.email ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <p x-show="errors.email" x-text="errors.email ? (Array.isArray(errors.email) ? errors.email[0] : errors.email) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Password (Optional) -->
            <div x-data="{ show: false }" class="relative">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.password')}} <span class="text-gray-400 dark:text-gray-500 text-xs">{{__('content.leave_blank')}}</span></label>
                <input :type="show ? 'text' : 'password'" name="password" x-model="userToEdit.password"
                    :class="errors.password ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    class="mt-1 w-full border rounded-md px-3 py-2 pr-10 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="{{__('content.enter')}}{{__('content.new_password_optional')}}" />
                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 mt-6 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                    <span x-show="!show" class="material-symbols-outlined">visibility</span>
                    <span x-show="show" class="material-symbols-outlined">visibility_off</span>
                </button>
                <p x-show="errors.password" x-text="errors.password ? (Array.isArray(errors.password) ? errors.password[0] : errors.password) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Department / Requestor / Customer -->
            <div class="flex flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">{{__('content.department')}}</label>
                    <select name="department_id" x-model="userToEdit.department_id" 
                            :class="errors.department_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                            class="select2 w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">-</option>
                        @foreach ($departments as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.department_id" x-text="errors.department_id ? (Array.isArray(errors.department_id) ? errors.department_id[0] : errors.department_id) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">{{__('content.requestor')}}</label>
                    <select name="requestor_id" x-model="userToEdit.requestor_id" 
                            :class="errors.requestor_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                            class="select2 w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">-</option>
                        @foreach ($requestors as $req)
                            <option value="{{ $req->id }}">{{ $req->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.requestor_id" x-text="errors.requestor_id ? (Array.isArray(errors.requestor_id) ? errors.requestor_id[0] : errors.requestor_id) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">{{__('content.customer')}}</label>
                    <select name="customer_id" x-model="userToEdit.customer_id" 
                            :class="errors.customer_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                            class="select2 w-full border rounded px-2 py-1 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">-</option>
                        @foreach ($customers as $cust)
                            <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.customer_id" x-text="errors.customer_id ? (Array.isArray(errors.customer_id) ? errors.customer_id[0] : errors.customer_id) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Role selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('auth.role')}}</label>
                <div class="flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-600 p-1">
                    <template x-for="r in ['user','admin','superadmin']" :key="r">
                        <label
                            :class="{
                                'bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm': role === r,
                                'text-gray-500 dark:text-gray-400 cursor-not-allowed opacity-50': r === 'superadmin' && currentUserRole === 'admin'
                            }"
                            class="flex-1 items-center justify-center rounded-full px-4 py-2 text-sm font-medium transition-colors flex cursor-pointer">
                            <input type="radio" name="role" :value="r" class="sr-only" x-model="role"
                                :disabled="r === 'superadmin' && currentUserRole === 'admin'" />
                            <span x-text="{
                                'user': '{{ __('auth.user') }}',
                                'admin': '{{ __('auth.admin') }}',
                                'superadmin': '{{ __('auth.superadmin') }}'
                            }[r]"></span>                        
                        </label>
                    </template>
                </div>
                <p x-show="errors.role" x-text="errors.role ? (Array.isArray(errors.role) ? errors.role[0] : errors.role) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Permissions -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">{{__('auth.permission')}}</label>
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
                <div class="flex flex-wrap gap-2 mt-1">
                    @foreach (['view', 'edit', 'delete', 'create', 'file import', 'manage users'] as $perm)
                        <label class="flex items-center gap-1 cursor-pointer"
                            :class="getOpacity('{{ $perm }}')">
                            <input type="checkbox" class="sr-only peer"
                                :checked="permissions.includes('{{ $perm }}')"
                                @change="
                                    if($event.target.checked){
                                        if(!permissions.includes('{{ $perm }}')) permissions.push('{{ $perm }}');
                                    } else {
                                        if('{{ $perm }}' !== 'view') {
                                            permissions = permissions.filter(p => p !== '{{ $perm }}');
                                        }
                                    }
                                "
                                :disabled="isDisabled('{{ $perm }}')" />
                            <span class="inline-block {{ $permColors[$perm] }} text-xs font-medium px-2.5 py-0.5 rounded-full peer-checked:ring-2 cursor-pointer"
                                :class="getRingColor('{{ $perm }}')">
                                {{ __('auth.' . $perm) }}
                            </span>
                        </label>
                    @endforeach
                </div>
                <p x-show="errors.permissions" x-text="errors.permissions ? (Array.isArray(errors.permissions) ? errors.permissions[0] : errors.permissions) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditUserModal = false; errors = {}"
                    class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500 hoverScale hover:bg-red-500 hover:text-white">{{ __('content.cancel') }}</button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 rounded-md bg-blue-600 dark:bg-blue-500 text-white hoverScale hover:bg-blue-700 dark:hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">{{ __('content.save') }}</span>
                    <span x-show="loading">{{ __('content.saving') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>