<div id="CreateProductModal" x-show="CreateProductModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Create Product</h2>
        <hr class="mb-3">

        <form @submit.prevent="submitProductForm" class="space-y-4" x-data="{
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

            <!-- Product SKU -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Product SKU</label>
                <input name="product_sku" type="text" placeholder="Enter product SKU"
                    :class="errors.product_sku ? 'border-red-500' : 'border-gray-300'"
                    class="mt-1 w-full border rounded-md px-3 py-2 
                        focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <p x-show="errors.product_sku"
                    x-text="Array.isArray(errors.product_sku) ? errors.product_sku[0] : errors.product_sku"
                    class="text-red-500 text-xs mt-1"></p>
            </div>

            <!-- Product Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Product Name</label>
                <input name="product_name" type="text" placeholder="Enter product name"
                    :class="errors.product_name ? 'border-red-500' : 'border-gray-300'"
                    class="mt-1 w-full border rounded-md px-3 py-2 
                        focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <p x-show="errors.product_name"
                    x-text="Array.isArray(errors.product_name) ? errors.product_name[0] : errors.product_name"
                    class="text-red-500 text-xs mt-1"></p>
            </div>

            <!-- Status & Category -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status_id" :class="errors.status_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">
                                {{ $status->status }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.status_id"
                        x-text="errors.status_id ? (Array.isArray(errors.status_id) ? errors.status_id[0] : errors.status_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="product_category_id"
                        :class="errors.product_category_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.product_category_id"
                        x-text="errors.product_category_id ? (Array.isArray(errors.product_category_id) ? errors.product_category_id[0] : errors.product_category_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Shape, Glaze, Pattern -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Shape</label>
                    <select name="shape_id" :class="errors.shape_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($shapes as $shape)
                            <option value="{{ $shape->id }}">
                                {{ $shape->item_code }} :
                                <p>{{ $shape->item_description_thai }}</p>
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.shape_id"
                        x-text="errors.shape_id ? (Array.isArray(errors.shape_id) ? errors.shape_id[0] : errors.shape_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Glaze</label>
                    <select name="glaze_id" :class="errors.glaze_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($glazes as $glaze)
                            <option value="{{ $glaze->id }}">
                                {{ $glaze->glaze_code }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.glaze_id"
                        x-text="errors.glaze_id ? (Array.isArray(errors.glaze_id) ? errors.glaze_id[0] : errors.glaze_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Pattern</label>
                    <select name="pattern_id" :class="errors.pattern_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($patterns as $pattern)
                            <option value="{{ $pattern->id }}">
                                {{ $pattern->pattern_code }} :
                                <p>{{ $pattern->pattern_name }}</p>
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.pattern_id"
                        x-text="errors.pattern_id ? (Array.isArray(errors.pattern_id) ? errors.pattern_id[0] : errors.pattern_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Backstamp</label>
                    <select name="backstamp_id" :class="errors.backstamp_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($backstamps as $backstamp)
                            <option value="{{ $backstamp->id }}">
                                {{ $backstamp->backstamp_code }} :
                                <p>{{ $backstamp->name }}</p>
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.backstamp_id"
                        x-text="errors.backstamp_id ? (Array.isArray(errors.backstamp_id) ? errors.backstamp_id[0] : errors.backstamp_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="CreateProductModal = false; errors = {}"
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
