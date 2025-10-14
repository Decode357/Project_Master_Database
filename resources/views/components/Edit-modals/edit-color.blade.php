<!-- Edit Color Modal -->
<div id="EditColorModal" x-show="EditColorModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Edit Color</h2>
        <hr class="mb-3">
        <form @submit.prevent="submitEditForm" class="space-y-4" x-data="{
            ...editColorModal(),
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- 🎨 Color Picker + HEX Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Color (HEX only)</label>
                    <div class="flex gap-2 items-center">
                        <!-- input text -->
                        <input name="color_code" type="text" x-model="colorToEdit.color_code"
                            maxlength="7"
                            :class="errors.color_code ? 'border-red-500' : 'border-gray-300'"
                            class="mt-1 flex-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500"
                            placeholder="#FFFFFF" required />

                        <!-- color picker -->
                        <input type="color" x-model="colorToEdit.color_code"
                            class="w-12 h-10 p-0 border rounded-md cursor-pointer" />
                    </div>

                    <p class="text-sm text-gray-500 mt-1" x-text="'Selected: ' + (colorToEdit.color_code || '#000000')"></p>
                    <p x-show="errors.color_code"
                        x-text="errors.color_code ? (Array.isArray(errors.color_code) ? errors.color_code[0] : errors.color_code) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>

                <!-- 🏷️ Color Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Color Name</label>
                    <input name="color_name" type="text" x-model="colorToEdit.color_name"
                        placeholder="Enter color name"
                        :class="errors.color_name ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2 
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required />
                    <p x-show="errors.color_name"
                        x-text="errors.color_name ? (Array.isArray(errors.color_name) ? errors.color_name[0] : errors.color_name) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <!-- 👤 Customer -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Customer</label>
                <select name="customer_id" x-model="colorToEdit.customer_id"
                    :class="errors.customer_id ? 'border-red-500' : 'border-gray-300'"
                    class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">-</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
                <p x-show="errors.customer_id"
                    x-text="errors.customer_id ? (Array.isArray(errors.customer_id) ? errors.customer_id[0] : errors.customer_id) : ''"
                    class="text-red-500 text-xs mt-1"></p>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditColorModal = false; errors = {}"
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
