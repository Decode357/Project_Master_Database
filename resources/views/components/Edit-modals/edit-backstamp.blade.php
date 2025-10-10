<!-- Edit Backstamp Modal -->
<div id="EditBackstampModal" x-show="EditBackstampModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Edit Backstamp</h2>
        <hr class="mb-3">
        <form @submit.prevent="submitEditForm" class="space-y-4" x-data="{
            ...editBackstampModal(),
            errors: {},
            loading: false,
            generalErrors: []
        }" x-init="init()">

            <!-- Dynamic Error Display Area -->
            <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 border border-red-400 rounded-md">
                <h4 class="text-red-800 font-semibold">Please correct the following errors</h4>
                <ul class="mt-2 text-red-700 text-sm list-disc list-inside">
                    <template x-for="(error, field) in errors" :key="field">
                        <li x-text="error[0] || error"></li>
                    </template>
                </ul>
            </div>

            <!-- Backstamp Code & Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Backstamp Code</label>
                    <input type="text" name="backstamp_code" x-model="backstampToEdit.backstamp_code"
                        :class="errors.backstamp_code ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2" required />
                    <p x-show="errors.backstamp_code"
                        x-text="errors.backstamp_code ? (Array.isArray(errors.backstamp_code) ? errors.backstamp_code[0] : errors.backstamp_code) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Backstamp Name</label>
                    <input type="text" name="name" x-model="backstampToEdit.name"
                        :class="errors.name ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2" required />
                    <p x-show="errors.name"
                        x-text="errors.name ? (Array.isArray(errors.name) ? errors.name[0] : errors.name) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Selects Row 1 -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer</label>
                    <select name="customer_id" x-model="backstampToEdit.customer_id"
                        :class="errors.customer_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        <option value="">-</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.customer_id"
                        x-text="errors.customer_id ? (Array.isArray(errors.customer_id) ? errors.customer_id[0] : errors.customer_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Requestor</label>
                    <select name="requestor_id" x-model="backstampToEdit.requestor_id"
                        :class="errors.requestor_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        <option value="">-</option>
                        @foreach ($requestors as $requestor)
                            <option value="{{ $requestor->id }}">{{ $requestor->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.requestor_id"
                        x-text="errors.requestor_id ? (Array.isArray(errors.requestor_id) ? errors.requestor_id[0] : errors.requestor_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status_id" x-model="backstampToEdit.status_id"
                        :class="errors.status_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        <option value="">-</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->status }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.status_id"
                        x-text="errors.status_id ? (Array.isArray(errors.status_id) ? errors.status_id[0] : errors.status_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>                
            </div>

            <!-- Duration -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Duration</label>
                <input type="number" name="duration" x-model="backstampToEdit.duration"
                    :class="errors.duration ? 'border-red-500' : 'border-gray-300'"
                    class="mt-1 w-full border rounded-md px-3 py-2" />
                <p x-show="errors.duration"
                    x-text="errors.duration ? (Array.isArray(errors.duration) ? errors.duration[0] : errors.duration) : ''"
                    class="text-red-500 text-xs mt-1"></p>
            </div>

            <!-- Glaze & Application Options -->
            <div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="in_glaze" id="in_glaze" x-model="backstampToEdit.in_glaze"
                            :checked="backstampToEdit.in_glaze"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="in_glaze" class="ml-2 text-sm text-gray-700">In Glaze</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="on_glaze" id="on_glaze" x-model="backstampToEdit.on_glaze"
                            :checked="backstampToEdit.on_glaze"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="on_glaze" class="ml-2 text-sm text-gray-700">On Glaze</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="under_glaze" id="under_glaze" x-model="backstampToEdit.under_glaze"
                            :checked="backstampToEdit.under_glaze"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="under_glaze" class="ml-2 text-sm text-gray-700">Under Glaze</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="air_dry" id="air_dry" x-model="backstampToEdit.air_dry"
                            :checked="backstampToEdit.air_dry"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="air_dry" class="ml-2 text-sm text-gray-700">Air Dry</label>
                    </div>
                </div>
            </div>

            <!-- Approval Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Approval Date</label>
                    <input type="date" name="approval_date" x-model="backstampToEdit.approval_date"
                        :class="errors.approval_date ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2" />
                    <p x-show="errors.approval_date"
                        x-text="errors.approval_date ? (Array.isArray(errors.approval_date) ? errors.approval_date[0] : errors.approval_date) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditBackstampModal = false; errors = {}"
                    class="px-4 py-2 rounded-md bg-gray-200 hoverScale hover:bg-red-500 hover:text-white">Cancel</button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 rounded-md bg-blue-600 text-white hoverScale hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Save</span>
                    <span x-show="loading">Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>
