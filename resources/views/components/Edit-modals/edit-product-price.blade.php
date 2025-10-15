<!-- Edit Product Price Modal -->
<script src="{{ asset('js/modals/edit-product-price-modal.js') }}"></script>

<div id="EditProductPriceModal" x-show="EditProductPriceModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Edit Product Price</h2>
        <hr class="mb-3">
        <form @submit.prevent="submitEditForm" class="space-y-4" x-data="{
            ...EditProductPriceModal(),
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

            <!-- Product Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Product</label>
                <select name="product_id" x-model="productPriceToEdit.product_id"
                    :class="errors.product_id ? 'border-red-500' : 'border-gray-300'"
                    class="select2 w-full mt-1 border rounded-md px-3 py-2" required>
                    <option value="">Select Product</option>
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->product_sku }} - {{ $product->product_name }}
                        </option>
                    @endforeach
                </select>
                <p x-show="errors.product_id"
                    x-text="errors.product_id ? (Array.isArray(errors.product_id) ? errors.product_id[0] : errors.product_id) : ''"
                    class="text-red-500 text-xs mt-1"></p>
            </div>

            <!-- Price & Currency -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" step="0.01" name="price" x-model="productPriceToEdit.price"
                        :class="errors.price ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2" required />
                    <p x-show="errors.price"
                        x-text="errors.price ? (Array.isArray(errors.price) ? errors.price[0] : errors.price) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700">Currency</label>
                    <select name="currency_id" x-model="productPriceToEdit.currency_id"
                        :class="errors.currency_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2" required>
                        <option value="">Select Currency</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->code }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.currency_id"
                        x-text="errors.currency_id ? (Array.isArray(errors.currency_id) ? errors.currency_id[0] : errors.currency_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Price Tier & Effective Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Price Tier</label>
                    <select name="tier_id" x-model="productPriceToEdit.tier_id"
                        :class="errors.tier_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2" required>
                        <option value="">Select Tier</option>
                        @foreach ($tiers as $tier)
                            <option value="{{ $tier->id }}">{{ $tier->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.tier_id"
                        x-text="errors.tier_id ? (Array.isArray(errors.tier_id) ? errors.tier_id[0] : errors.tier_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Effective Date</label>
                    <input type="date" name="effective_date" x-model="productPriceToEdit.effective_date"
                        :class="errors.effective_date ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2" required />
                    <p x-show="errors.effective_date"
                        x-text="errors.effective_date ? (Array.isArray(errors.effective_date) ? errors.effective_date[0] : errors.effective_date) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditProductPriceModal = false; errors = {}"
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
