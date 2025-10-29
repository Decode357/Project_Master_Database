<!-- Edit Backstamp Modal -->
<script src="{{ asset('js/modals/edit-backstamp-modal.js') }}"></script>

<div id="EditBackstampModal" x-show="EditBackstampModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('content.edit_backstamp') }}</h2>
        <hr class="mb-3 border-gray-200 dark:border-gray-600">
        <form @submit.prevent="submitEditForm" class="space-y-4" x-data="{
            ...editBackstampModal(),
            errors: {},
            loading: false,
            generalErrors: []
        }" x-init="init()">

            <!-- Dynamic Error Display Area -->
            <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 rounded-md">
                <h4 class="text-red-800 dark:text-red-200 font-semibold">Please correct the following errors</h4>
                <ul class="mt-2 text-red-700 dark:text-red-300 text-sm list-disc list-inside">
                    <template x-for="(error, field) in errors" :key="field">
                        <li x-text="error[0] || error"></li>
                    </template>
                </ul>
            </div>

            <!-- Backstamp Code & Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.backstamp_code') }}</label>
                    <input type="text" name="backstamp_code" x-model="backstampToEdit.backstamp_code" placeholder="{{ __('content.enter') }}{{ __('content.backstamp_code') }}"
                        :class="errors.backstamp_code ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent" required />
                    <p x-show="errors.backstamp_code"
                        x-text="errors.backstamp_code ? (Array.isArray(errors.backstamp_code) ? errors.backstamp_code[0] : errors.backstamp_code) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.backstamp_name') }}</label>
                    <input type="text" name="name" x-model="backstampToEdit.name" placeholder="{{ __('content.enter') }}{{ __('content.backstamp_name') }}"
                        :class="errors.name ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.name"
                        x-text="errors.name ? (Array.isArray(errors.name) ? errors.name[0] : errors.name) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Selects Row 1 -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.customer') }}</label>
                    <select name="customer_id" x-model="backstampToEdit.customer_id"
                        :class="errors.customer_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.customer_id"
                        x-text="errors.customer_id ? (Array.isArray(errors.customer_id) ? errors.customer_id[0] : errors.customer_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.requestor') }}</label>
                    <select name="requestor_id" x-model="backstampToEdit.requestor_id"
                        :class="errors.requestor_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($requestors as $requestor)
                            <option value="{{ $requestor->id }}">{{ $requestor->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.requestor_id"
                        x-text="errors.requestor_id ? (Array.isArray(errors.requestor_id) ? errors.requestor_id[0] : errors.requestor_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.status') }}</label>
                    <select name="status_id" x-model="backstampToEdit.status_id"
                        :class="errors.status_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->status }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.status_id"
                        x-text="errors.status_id ? (Array.isArray(errors.status_id) ? errors.status_id[0] : errors.status_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>                
            </div>

            <!-- Glaze & Application Options -->
            <div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="in_glaze" id="in_glaze" x-model="backstampToEdit.in_glaze"
                            :checked="backstampToEdit.in_glaze"
                            class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="in_glaze" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('content.in_glaze') }}</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="on_glaze" id="on_glaze" x-model="backstampToEdit.on_glaze"
                            :checked="backstampToEdit.on_glaze"
                            class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="on_glaze" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('content.on_glaze') }}</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="under_glaze" id="under_glaze" x-model="backstampToEdit.under_glaze"
                            :checked="backstampToEdit.under_glaze"
                            class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="under_glaze" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('content.under_glaze') }}</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="air_dry" id="air_dry" x-model="backstampToEdit.air_dry"
                            :checked="backstampToEdit.air_dry"
                            class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="air_dry" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('content.air_dry') }}</label>
                    </div>
                </div>
            </div>

            <!-- Approval Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.approval_date') }}</label>
                    <input type="date" name="approval_date" x-model="backstampToEdit.approval_date"
                        :class="errors.approval_date ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.approval_date"
                        x-text="errors.approval_date ? (Array.isArray(errors.approval_date) ? errors.approval_date[0] : errors.approval_date) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditBackstampModal = false; errors = {}"
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