<!-- Create Glaze Inside Modal -->
<script src="{{ asset('js/modals/create-glazeInsideOuter-modal.js') }}"></script>

<div id="CreateGlazeInsideModal" x-show="CreateGlazeInsideModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __("content.create_glaze_inside") }}</h2>
        <hr class="mb-3 dark:border-gray-600">

        <form @submit.prevent="submitGlazeInsideForm" class="space-y-4" x-data="{
            errors: {},
            loading: false
        }">
            @csrf

            <!-- Dynamic Error Display Area -->
            <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 rounded-md">
                <h4 class="text-red-800 dark:text-red-200 font-semibold">{{ __("content.please_correct_errors") }}</h4>
                <ul class="mt-2 text-red-700 dark:text-red-300 text-sm list-disc list-inside">
                    <template x-for="(error, field) in errors" :key="field">
                        <li x-text="error[0] || error"></li>
                    </template>
                </ul>
            </div>

            <!-- Glaze Inside Code -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.inside_color_code') }}</label>
                <input name="glaze_inside_code" type="text" placeholder="{{ __('content.enter') }}{{ __('content.color_code') }}"
                    :class="errors.glaze_inside_code ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                        focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <p x-show="errors.glaze_inside_code"
                    x-text="Array.isArray(errors.glaze_inside_code) ? errors.glaze_inside_code[0] : errors.glaze_inside_code"
                    class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Select Colors -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.color') }} <span
                        class="text-sm text-gray-500 dark:text-gray-400">{{ __('content.optional') }}</span></label>
                <select name="colors[]" multiple :class="errors.colors ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    data-placeholder="{{ __('content.select_colors') }}">
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}">
                            {{ $color->color_name }} : {{ optional($color->customer)->name ?? '-' }}
                        </option>
                    @endforeach
                </select>
                <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">{{ __("content.color_optional") }}</p>
                <p x-show="errors.colors" x-text="Array.isArray(errors.colors) ? errors.colors[0] : errors.colors"
                    class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="CreateGlazeInsideModal = false; errors = {}"
                    class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-600 dark:text-gray-100 hoverScale hover:bg-red-500 hover:text-white">{{ __("content.cancel") }}</button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 rounded-md bg-blue-600 text-white hoverScale hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">{{ __("content.save") }}</span>
                    <span x-show="loading">{{ __("content.saving") }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Create Glaze Outer Modal -->
<div id="CreateGlazeOuterModal" x-show="CreateGlazeOuterModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __("content.create_glaze_outside") }}</h2>
        <hr class="mb-3 dark:border-gray-600">

        <form @submit.prevent="submitGlazeOuterForm" class="space-y-4" x-data="{
            errors: {},
            loading: false
        }">
            @csrf

            <!-- Dynamic Error Display Area -->
            <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 rounded-md">
                <h4 class="text-red-800 dark:text-red-200 font-semibold">{{ __("content.please_correct_errors") }}</h4>
                <ul class="mt-2 text-red-700 dark:text-red-300 text-sm list-disc list-inside">
                    <template x-for="(error, field) in errors" :key="field">
                        <li x-text="error[0] || error"></li>
                    </template>
                </ul>
            </div>

            <!-- Glaze Outer Code -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.outside_color_code') }}</label>
                <input name="glaze_outer_code" type="text" placeholder="{{ __('content.enter') }}{{ __('content.color_code') }}"
                    :class="errors.glaze_outer_code ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                        focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required />
                <p x-show="errors.glaze_outer_code"
                    x-text="Array.isArray(errors.glaze_outer_code) ? errors.glaze_outer_code[0] : errors.glaze_outer_code"
                    class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Select Colors -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.color') }} <span
                        class="text-sm text-gray-500 dark:text-gray-400">{{ __('content.optional') }}</span></label>
                <select name="colors[]" multiple :class="errors.colors ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    data-placeholder="{{ __('content.select_colors') }}">
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}">
                            {{ $color->color_name }} : {{ optional($color->customer)->name ?? '-' }}
                        </option>
                    @endforeach
                </select>
                <p class="text-gray-500 dark:text-gray-400 text-xs mt-1">{{ __("content.color_optional") }}</p>
                <p x-show="errors.colors" x-text="Array.isArray(errors.colors) ? errors.colors[0] : errors.colors"
                    class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="CreateGlazeOuterModal = false; errors = {}"
                    class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-600 dark:text-gray-100 hoverScale hover:bg-red-500 hover:text-white">{{ __("content.cancel") }}</button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 rounded-md bg-blue-600 text-white hoverScale hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">{{ __("content.save") }}</span>
                    <span x-show="loading">{{ __("content.saving") }}</span>
                </button>
            </div>
        </form>
    </div>
</div>


