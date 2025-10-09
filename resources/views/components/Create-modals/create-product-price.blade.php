<div id="CreateProductPriceModal" x-show="CreateProductPriceModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Create Product Price</h2>
        <hr class="mb-3">

        <form @submit.prevent="submitProductPriceForm" class="space-y-4" x-data="{
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

            <!-- Product -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Product</label>
                <select name="product_id" :class="errors.product_id ? 'border-red-500' : 'border-gray-300'"
                    class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required>
                    <option value="">-</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->product_sku }} : {{ $product->product_name }}
                        </option>
                    @endforeach
                </select>
                <p x-show="errors.product_id"
                    x-text="Array.isArray(errors.product_id) ? errors.product_id[0] : errors.product_id"
                    class="text-red-500 text-xs mt-1"></p>
            </div>

            <!-- Price & Currency -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input name="price" type="number" step="0.01" placeholder="0.00"
                        :class="errors.price ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2 
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.price" x-text="Array.isArray(errors.price) ? errors.price[0] : errors.price"
                        class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Currency</label>
                    <select name="currency" :class="errors.currency ? 'border-red-500' : 'border-gray-300'"
                        class="w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        <option value="THB">THB</option>
                        <option value="USD">USD</option>
                        <option value="EUR">EUR</option>
                        <option value="GBP">GBP</option>
                    </select>
                    <p x-show="errors.currency"
                        x-text="errors.currency ? (Array.isArray(errors.currency) ? errors.currency[0] : errors.currency) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Price Tier & Effective Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price Tier</label>
                    <select name="price_tier" :class="errors.price_tier ? 'border-red-500' : 'border-gray-300'"
                        class="w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        <option value="Standard">Standard</option>
                        <option value="Premium">Premium</option>
                        <option value="Wholesale">Wholesale</option>
                        <option value="Retail">Retail</option>
                        <option value="Discount">Discount</option>
                    </select>
                    <p x-show="errors.price_tier"
                        x-text="errors.price_tier ? (Array.isArray(errors.price_tier) ? errors.price_tier[0] : errors.price_tier) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Effective Date</label>
                    <input name="effective_date" type="date"
                        :class="errors.effective_date ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2 
                               focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.effective_date"
                        x-text="errors.effective_date ? (Array.isArray(errors.effective_date) ? errors.effective_date[0] : errors.effective_date) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="CreateProductPriceModal = false; errors = {}"
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
