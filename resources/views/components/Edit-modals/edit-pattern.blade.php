<!-- Edit Pattern Modal -->
<script src="{{ asset('js/modals/edit-pattern-modal.js') }}"></script>

<div id="EditPatternModal" x-show="EditPatternModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Edit Pattern</h2>
        <hr class="mb-3 border-gray-200 dark:border-gray-600">
        <form @submit.prevent="submitEditForm" class="space-y-4" x-data="{
            ...editPatternModal(),
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Pattern Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pattern Code</label>
                    <input type="text" name="pattern_code" x-model="patternToEdit.pattern_code" placeholder="Enter pattern code"
                        :class="errors.pattern_code ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent" required />
                    <p x-show="errors.pattern_code"
                        x-text="errors.pattern_code ? (Array.isArray(errors.pattern_code) ? errors.pattern_code[0] : errors.pattern_code) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>

                <!-- Pattern Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pattern Name</label>
                    <input type="text" name="pattern_name" x-model="patternToEdit.pattern_name" placeholder="Enter pattern name"
                        :class="errors.pattern_name ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent" required />
                    <p x-show="errors.pattern_name"
                        x-text="errors.pattern_name ? (Array.isArray(errors.pattern_name) ? errors.pattern_name[0] : errors.pattern_name) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>


            <!-- Selects Row 1 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                    <select name="customer_id" x-model="patternToEdit.customer_id"
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
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Requestor</label>
                    <select name="requestor_id" x-model="patternToEdit.requestor_id"
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
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status_id" x-model="patternToEdit.status_id"
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
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Designer</label>
                    <select name="designer_id" x-model="patternToEdit.designer_id"
                        :class="errors.designer_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($designers as $designer)
                            <option value="{{ $designer->id }}">{{ $designer->designer_name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.designer_id"
                        x-text="errors.designer_id ? (Array.isArray(errors.designer_id) ? errors.designer_id[0] : errors.designer_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Glaze Options -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Glaze Application</label>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="in_glaze" id="in_glaze" x-model="patternToEdit.in_glaze"
                            :checked="patternToEdit.in_glaze"
                            class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="in_glaze" class="ml-2 text-sm text-gray-700 dark:text-gray-300">In Glaze</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="on_glaze" id="on_glaze" x-model="patternToEdit.on_glaze"
                            :checked="patternToEdit.on_glaze"
                            class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="on_glaze" class="ml-2 text-sm text-gray-700 dark:text-gray-300">On Glaze</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="under_glaze" id="under_glaze"
                            x-model="patternToEdit.under_glaze"
                            :checked="patternToEdit.under_glaze"
                            class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <label for="under_glaze" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Under Glaze</label>
                    </div>
                </div>
            </div>

            <!-- Approval Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Approval Date</label>
                    <input type="date" name="approval_date" x-model="patternToEdit.approval_date"
                        :class="errors.approval_date ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.approval_date"
                        x-text="errors.approval_date ? (Array.isArray(errors.approval_date) ? errors.approval_date[0] : errors.approval_date) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditPatternModal = false; errors = {}"
                    class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-600 dark:text-gray-100 hoverScale hover:bg-red-500 hover:text-white">Cancel</button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 rounded-md bg-blue-600 text-white hoverScale hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Save</span>
                    <span x-show="loading">Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>
