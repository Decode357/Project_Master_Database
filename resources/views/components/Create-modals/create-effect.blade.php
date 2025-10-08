<div id="CreateEffectModal" 
     x-show="CreateEffectModal" 
     x-transition.opacity
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
     style="display: none;">
     
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Create Effect</h2>
        <hr class="mb-3">
        
        <form @submit.prevent="submitEffectForm" class="space-y-4" 
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

            <!-- Effect Code -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Effect Code</label>
                <input name="effect_code" type="text" placeholder="Enter effect code (e.g., EF-001)"
                    :class="errors.effect_code ? 'border-red-500' : 'border-gray-300'"
                    class="mt-1 w-full border rounded-md px-3 py-2 
                        focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <p x-show="errors.effect_code" x-text="Array.isArray(errors.effect_code) ? errors.effect_code[0] : errors.effect_code" class="text-red-500 text-xs mt-1"></p>
            </div>

            <!-- Effect Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Effect Name</label>
                <input name="effect_name" type="text" placeholder="Enter effect name"
                    :class="errors.effect_name ? 'border-red-500' : 'border-gray-300'"
                    class="mt-1 w-full border rounded-md px-3 py-2 
                        focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <p x-show="errors.effect_name" x-text="Array.isArray(errors.effect_name) ? errors.effect_name[0] : errors.effect_name" class="text-red-500 text-xs mt-1"></p>
            </div>

            <!-- Select Colors -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Colors <span class="text-sm text-gray-500">(Optional)</span></label>
                <select name="colors[]" multiple
                    :class="errors.colors ? 'border-red-500' : 'border-gray-300'"
                    class="select2 w-full mt-1 border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    data-placeholder="Select colors">
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}">
                            {{ $color->color_name }} : {{ optional($color->customer)->name ?? '-' }}
                        </option>
                    @endforeach
                </select>
                <p class="text-gray-500 text-xs mt-1">You can select multiple colors or leave empty</p>
                <p x-show="errors.colors" x-text="Array.isArray(errors.colors) ? errors.colors[0] : errors.colors" class="text-red-500 text-xs mt-1"></p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="CreateEffectModal = false; errors = {}"
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