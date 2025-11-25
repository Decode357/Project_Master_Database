<!-- Edit ItemGroup Modal -->
<script src="{{ asset('js/modals/edit-itemGroup-modal.js') }}"></script>

<div id="EditItemGroupModal" x-show="EditItemGroupModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __("content.edit_item_group") }}</h2>
        <hr class="mb-3 border-gray-200 dark:border-gray-600">
        
        <form @submit.prevent="submitEditForm" class="space-y-4" x-data="{
            ...editItemGroupModal(),
            errors: {},
            loading: false,
            handleImageChange(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imagePreview = e.target.result;
                        this.deleteImage = false;
                    };
                    reader.readAsDataURL(file);
                }
            },
            removeCurrentImage() {
                this.currentImage = null;
                this.deleteImage = true;
            },
            removeNewImage() {
                this.imagePreview = null;
                document.querySelector('#EditItemGroupModal input[name=image]').value = '';
            }
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

            <!-- Item Group Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __("content.item_group_name") }}</label>
                <input name="item_group_name" type="text" x-model="itemGroupToEdit.item_group_name"
                    placeholder="{{ __('content.enter') }}{{ __('content.item_group_name') }}"
                    :class="errors.item_group_name ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                        focus:ring-2 focus:ring-blue-500 focus:border-transparent" required/>
                <p x-show="errors.item_group_name"
                    x-text="errors.item_group_name ? (Array.isArray(errors.item_group_name) ? errors.item_group_name[0] : errors.item_group_name) : ''"
                    class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __("content.upload_new_images") }}</label>
                
                <!-- ปุ่มอัพโหลด -->
                <label for="editImageUpload"
                    class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-medium hoverScale rounded-md cursor-pointer hover:bg-blue-700">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12V4m0 0l4 4m-4-4L8 8"/>
                    </svg>
                    {{ __('content.select_images') }}
                </label>
                
                <!-- input file ซ่อน -->
                <input id="editImageUpload" name="image" type="file" accept="image/*" @change="handleImageChange" class="hidden"/>
                
                <p x-show="errors.image"
                    x-text="Array.isArray(errors.image) ? errors.image[0] : errors.image"
                    class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <!-- Images Preview Section -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Current/Existing Image -->
                <div x-show="currentImage">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __("content.existing_images") }}
                    </label>
                    <div class="relative inline-block">
                    <img :src="'{{ asset('images/itemGroup') }}/' + currentImage"
                        alt="Current Image"
                        class="w-32 h-32 object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                        <button type="button" @click="removeCurrentImage"
                                class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div> 
                </div>

                <!-- New Image Preview -->
                <div x-show="imagePreview">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __("content.new_images_preview") }}
                    </label>
                    <div class="relative inline-block">
                        <img :src="imagePreview" alt="New Image Preview" 
                            class="w-32 h-32 object-cover rounded-lg border-2 border-green-500 dark:border-green-400">
                        <button type="button" @click="removeNewImage"
                                class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Hidden field for delete image flag -->
            <input type="hidden" name="delete_image" :value="deleteImage ? '1' : '0'">

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditItemGroupModal = false; errors = {}; imagePreview = null"
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
