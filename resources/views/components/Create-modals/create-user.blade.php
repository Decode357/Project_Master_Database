<!-- Create User Modal -->
<script src="{{ asset('js/modals/create-user-modal.js') }}"></script>

<div x-show="CreateUserModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-xl p-6">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{__('content.create_user')}}</h2>
        <hr class="mb-3 border-gray-200 dark:border-gray-600">

        <form id="CreateUserForm" @submit.prevent="loading = true; submitUserForm()" class="space-y-4" x-data="{
            newUser: { department_id: '', requestor_id: '', customer_id: '' },
            role: 'user',
            permissions: ['view'],
            allPermissions: ['view', 'edit', 'delete', 'create', 'file import', 'manage users'],
            currentUserRole: '{{ Auth::user()->roles->pluck('name')->first() }}',
            loading: false,
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
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.username')}}</label>
                <input type="text" name="name" placeholder="{{__('content.enter')}}{{__('content.username')}}"
                    class="mt-1 w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <p x-show="errors.name" x-text="errors.name ? (Array.isArray(errors.name) ? errors.name[0] : errors.name) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.email')}}</label>
                <input type="email" name="email" placeholder="{{__('content.enter')}}{{__('content.email')}}"
                    class="mt-1 w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <p x-show="errors.email" x-text="errors.email ? (Array.isArray(errors.email) ? errors.email[0] : errors.email) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Password -->
            <div x-data="{ show: false }" class="relative">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.password')}}</label>
                <input :type="show ? 'text' : 'password'" name="password" placeholder="{{__('content.enter')}}{{__('content.password')}}"
                    class="mt-1 w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 rounded-md px-3 py-2 pr-10 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
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
                    <div class="grid grid-cols-2 items-end">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.department') }}</label>
                        <label class="block text-xs font-medium text-green-700 dark:text-green-300 text-end">{{__('content.can_add')}}</label>                 
                    </div>
                    <select name="department_id" x-model="newUser.department_id" class="select2 w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded px-2 py-1">
                        <option value="">-</option>
                        @foreach ($departments as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.department_id" x-text="errors.department_id ? (Array.isArray(errors.department_id) ? errors.department_id[0] : errors.department_id) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>

                <div class="flex-1">
                    <div class="grid grid-cols-2 items-end">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.requestor') }}</label>
                        <label class="block text-xs font-medium text-green-700 dark:text-green-300 text-end">{{__('content.can_add')}}</label>                 
                    </div>                    
                    <select name="requestor_id" x-model="newUser.requestor_id" class="select2 w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded px-2 py-1">
                        <option value="">-</option>
                        @foreach ($requestors as $req)
                            <option value="{{ $req->id }}">{{ $req->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.requestor_id" x-text="errors.requestor_id ? (Array.isArray(errors.requestor_id) ? errors.requestor_id[0] : errors.requestor_id) : ''" class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>

                <div class="flex-1">
                    <div class="grid grid-cols-2 items-end">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.customer') }}</label>
                        <label class="block text-xs font-medium text-red-700 dark:text-red-300 text-end">{{__('content.select_only')}}</label>
                    </div>                    
                    <select name="customer_id" x-model="newUser.customer_id" class="select2 w-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded px-2 py-1">
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
                                'text-gray-500 dark:text-gray-400 cursor-not-allowed opacity-50': r === 'superadmin' &&
                                    currentUserRole === 'admin'
                            }"
                            class="flex-1 items-center justify-center rounded-full px-4 py-2 text-sm font-medium transition-colors flex cursor-pointer">
                            <input type="radio" name="role" :value="r" class="sr-only" x-model="role"
                                :disabled="r === 'superadmin' && currentUserRole === 'admin'"
                                @change="updatePermissions()" />
                            <span x-text="{
                                'user': '{{ __('auth.user') }}',
                                'admin': '{{ __('auth.admin') }}',
                                'superadmin': '{{ __('auth.superadmin') }}'
                            }[r]"></span>                        
                        </label>
                    </template>
                </div>
            </div>

            <!-- Permissions -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-2">{{__('auth.permission')}}</label>
                <div class="flex flex-wrap gap-2 mt-1">
                    @php
                        $permColors = [
                            'view' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                            'edit' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                            'delete' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                            'create' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                            'file import' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
                            'manage users' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
                        ];
                    @endphp
                    @foreach (['view', 'edit', 'delete', 'create', 'file import', 'manage users'] as $perm)
                        <label class="flex items-center gap-1 cursor-pointer" :class="getOpacity('{{ $perm }}')">
                            <input type="checkbox" name="permissions[]" value="{{ $perm }}" class="sr-only peer"
                                x-model="permissions" :disabled="isDisabled('{{ $perm }}')" />
                            <span
                                class="inline-block {{ $permColors[$perm] }} text-xs font-medium px-2.5 py-0.5 rounded-full
                                peer-checked:ring-2 cursor-pointer"
                                :class="getRingColor('{{ $perm }}')">
                                {{ __('auth.' . $perm) }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="CreateUserModal = false"
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
