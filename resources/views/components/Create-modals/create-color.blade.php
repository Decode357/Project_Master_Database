<!-- Create Color Modal -->
<script src="{{ asset('js/modals/create-color-modal.js') }}"></script>

<div id="CreateColorModal" x-show="CreateColorModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Create Color</h2>
        <hr class="mb-3 border-gray-200 dark:border-gray-600">

        <form @submit.prevent="submitColorForm" class="space-y-4" x-data="{
            errors: {},
            loading: false,
            selectedColor: '#000000', // ค่าเริ่มต้น
            }">
            @csrf

            <!-- Error Display -->
            <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 rounded-md">
                <h4 class="text-red-800 dark:text-red-200 font-semibold">Please correct the following errors</h4>
                <ul class="mt-2 text-red-700 dark:text-red-300 text-sm list-disc list-inside">
                    <template x-for="(error, field) in errors" :key="field">
                        <li x-text="error[0] || error"></li>
                    </template>
                </ul>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- 🎨 Color Picker + HEX Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color (HEX only)</label>
                    <div class="flex gap-2 items-center">
                        <!-- input text -->
                        <input name="color_code" type="text" x-model="selectedColor"
                            maxlength="7"
                            class="mt-1 flex-1 border rounded-md px-3 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500"
                            placeholder="#FFFFFF" required />

                        <!-- color picker -->
                        <input type="color" x-model="selectedColor"
                            class="w-12 h-10 p-0 border rounded-md cursor-pointer dark:border-gray-600" />
                    </div>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-text="'Selected: ' + selectedColor"></p>
                </div>

                <!-- 🏷️ Color Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color Name</label>
                    <input name="color_name" type="text" placeholder="Enter color name"
                        :class="errors.color_name ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required />
                    <p x-show="errors.color_name"
                        x-text="Array.isArray(errors.color_name) ? errors.color_name[0] : errors.color_name"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- 👤 Customer -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                <select name="customer_id" :class="errors.customer_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
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

            <!-- 🔘 Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="$event.target.disabled = true; CreateColorModal = false; errors = {}"
                    class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500 hoverScale hover:bg-red-500 hover:text-white">Cancel</button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 rounded-md bg-blue-600 dark:bg-blue-500 text-white hoverScale hover:bg-blue-700 dark:hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Save</span>
                    <span x-show="loading">Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>
