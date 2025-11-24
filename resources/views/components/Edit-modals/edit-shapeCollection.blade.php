<!-- Edit Shape Collection Modal -->
<script src="{{ asset('js/modals/edit-shapeCollection-modal.js') }}"></script>

<div id="EditShapeCollectionModal" x-show="EditShapeCollectionModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __("content.edit_collection") }}</h2>
        <hr class="mb-3 border-gray-200 dark:border-gray-600">
        <form @submit.prevent="submitEditForm" class="space-y-4" x-data="{
            ...editShapeCollectionModal(),
            errors: {},
            loading: false,
            generalErrors: []
        }" x-init="init()">

            <!-- Dynamic Error Display Area -->
            <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 rounded-md">
                <h4 class="text-red-800 dark:text-red-200 font-semibold">{{ __('content.please_correct_errors') }}</h4>
                <ul class="mt-2 text-red-700 dark:text-red-300 text-sm list-disc list-inside">
                    <template x-for="(error, field) in errors" :key="field">
                        <li x-text="error[0] || error"></li>
                    </template>
                </ul>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __("content.collection_code") }}</label>
                    <div class="flex gap-2 items-center">
                        <!-- input text -->
                        <input name="collection_code" type="text" x-model="shapeCollectionToEdit.collection_code"
                            :class="errors.collection_code ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                            class="mt-1 flex-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500"
                            placeholder="{{ __('content.enter') }}{{ __('content.collection_code') }}" required />
                    </div>
                </div>

                <!-- 🏷️ Shape Collection Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __("content.collection_name") }}</label>
                    <input name="collection_name" type="text" x-model="shapeCollectionToEdit.collection_name"
                        placeholder="{{ __('content.enter') }}{{ __('content.collection_name') }}"
                        :class="errors.collection_name ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                    <p x-show="errors.collection_name"
                        x-text="errors.collection_name ? (Array.isArray(errors.collection_name) ? errors.collection_name[0] : errors.collection_name) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditShapeCollectionModal = false; errors = {}"
                    class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500 hoverScale hover:bg-red-500 hover:text-white">{{ __("content.cancel") }}</button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 rounded-md bg-blue-600 dark:bg-blue-500 text-white hoverScale hover:bg-blue-700 dark:hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">{{ __("content.save") }}</span>
                    <span x-show="loading">{{ __("content.saving") }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
