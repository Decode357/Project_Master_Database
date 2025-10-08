<div id="CreatePatternModal" 
     x-show="CreatePatternModal" 
     x-transition.opacity
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
     style="display: none;">
     
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Create Pattern</h2>
        <hr class="mb-3">
        
        <form @submit.prevent="submitPatternForm" class="space-y-4" 
              x-data="{
                  errors: {},
                  loading: false
              }">
            @csrf

            <!-- Dynamic Error Display Area -->
            <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 border border-red-400 rounded-md">
                <h4 class="text-red-800 font-semibold">Please correct the following errors</h4>
                <ul class="mt-2 text-red-700 text-sm list-disc list-inside">
                    <template x-for="(error, field) in errors" :key="field">
                        <li x-text="error[0] || error"></li>
                    </template>
                </ul>
            </div>

            <!-- Pattern Code & Pattern Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Pattern Code</label>
                    <input name="pattern_code" type="text" placeholder="Enter pattern code"
                        :class="errors.pattern_code ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2 
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required />
                    <p x-show="errors.pattern_code" x-text="Array.isArray(errors.pattern_code) ? errors.pattern_code[0] : errors.pattern_code" class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Pattern Name</label>
                    <input name="pattern_name" type="text" placeholder="Enter pattern name"
                        :class="errors.pattern_name ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2 
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required />
                    <p x-show="errors.pattern_name" x-text="Array.isArray(errors.pattern_name) ? errors.pattern_name[0] : errors.pattern_name" class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Customer, Requestor, Status, Designer -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer</label>
                    <select name="customer_id" 
                        :class="errors.customer_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.customer_id" x-text="errors.customer_id ? (Array.isArray(errors.customer_id) ? errors.customer_id[0] : errors.customer_id) : ''" class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Requestor</label>
                    <select name="requestor_id" 
                        :class="errors.requestor_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($requestors as $requestor)
                            <option value="{{ $requestor->id }}">
                                {{ $requestor->name }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.requestor_id" x-text="errors.requestor_id ? (Array.isArray(errors.requestor_id) ? errors.requestor_id[0] : errors.requestor_id) : ''" class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status_id" 
                        :class="errors.status_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">
                                {{ $status->status }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.status_id" x-text="errors.status_id ? (Array.isArray(errors.status_id) ? errors.status_id[0] : errors.status_id) : ''" class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Designer</label>
                    <select name="designer_id" 
                        :class="errors.designer_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($designers as $designer)
                            <option value="{{ $designer->id }}">
                                {{ $designer->designer_name }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.designer_id" x-text="errors.designer_id ? (Array.isArray(errors.designer_id) ? errors.designer_id[0] : errors.designer_id) : ''" class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Duration -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Duration</label>
                <input name="duration" type="number" placeholder="Enter duration"
                    :class="errors.duration ? 'border-red-500' : 'border-gray-300'"
                    class="mt-1 w-full border rounded-md px-3 py-2 
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                <p x-show="errors.duration" x-text="errors.duration ? (Array.isArray(errors.duration) ? errors.duration[0] : errors.duration) : ''" class="text-red-500 text-xs mt-1"></p>
            </div>

            <!-- Glaze Options -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Glaze Application</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center">

                        <input name="in_glaze" type="checkbox" id="in_glaze" value="1">
                        <label for="in_glaze" class="ml-2 text-sm text-gray-700">In Glaze</label>
                    </div>
                    <div class="flex items-center">
           
                        <input name="on_glaze" type="checkbox" id="on_glaze" value="1">
                        <label for="on_glaze" class="ml-2 text-sm text-gray-700">On Glaze</label>
                    </div>
                    <div class="flex items-center">
                 
                        <input name="under_glaze" type="checkbox" id="under_glaze" value="1">
                        <label for="under_glaze" class="ml-2 text-sm text-gray-700">Under Glaze</label>
                    </div>
                </div>
            </div>
            

            <!-- Approval Date & Image -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Approval Date</label>
                    <input name="approval_date" type="date"
                        :class="errors.approval_date ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2 
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.approval_date" x-text="errors.approval_date ? (Array.isArray(errors.approval_date) ? errors.approval_date[0] : errors.approval_date) : ''" class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="CreatePatternModal = false; errors = {}"
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
