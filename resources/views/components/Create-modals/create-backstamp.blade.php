<!-- Create Backstamp Modal -->
<script src="{{ asset('js/modals/create-backstamp-modal.js') }}"></script>

<div id="CreateBackstampModal" x-show="CreateBackstampModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('content.create_backstamp') }}</h2>
        <hr class="mb-3 border-gray-200 dark:border-gray-600">

        <form @submit.prevent="submitBackstampForm($event)" class="space-y-4" x-data="{
            errors: {},
            loading: false,
            
            handleImageUpload(event) {
                const files = event.target.files;
                if (files) {
                    Array.from(files).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            if (file.size <= 5 * 1024 * 1024) {
                                this.newImages.push(file);
                            } else {
                                showToast('Image file size must be less than 5MB', 'error');
                            }
                        } else {
                            showToast('Please select only image files', 'error');
                        }
                    });
                }
                event.target.value = '';
            },
            
            removeNewImage(index) {
                this.newImages.splice(index, 1);
            },

            submitBackstampForm(event) {
                this.loading = true;
                this.errors = {};

                const formData = new FormData();
                formData.append('_token', document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'));
                
                const form = event.target;
                const formElements = form.elements;
                for (let element of formElements) {
                    if (element.name && element.type !== 'submit') {
                        formData.append(element.name, element.value || '');
                    }
                }

                this.newImages.forEach((file, index) => {
                    formData.append(`new_images[${index}]`, file);
                });

                fetch('/backstamp', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.ok) return response.json();
                    return response.json().then(data => Promise.reject(data));
                })
                .then(data => {
                    this.CreateBackstampModal = false;
                    this.errors = {};
                    this.newImages = [];
                    form.reset();
                    if (typeof resetSelect2 === 'function') resetSelect2('#CreateBackstampModal');
                    showToast(data.message, 'success');
                    setTimeout(() => window.location.reload(), 300);
                })
                .catch(error => {
                    if (error.errors) {
                        this.errors = error.errors;
                    } else {
                        showToast(error.message || 'เกิดข้อผิดพลาด', 'error');
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
            }
        }">
            @csrf

            <!-- Dynamic Error Display Area -->
            <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 rounded-md">
                <h4 class="text-red-800 dark:text-red-200 font-semibold">{{__('content.please_correct_errors')}}</h4>
                <ul class="mt-2 text-red-700 dark:text-red-300 text-sm list-disc list-inside">
                    <template x-for="(error, field) in errors" :key="field">
                        <li x-text="error[0] || error"></li>
                    </template>
                </ul>
            </div>

            <!-- Backstamp Code & Name -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.backstamp_code') }}</label>
                    <input name="backstamp_code" type="text" placeholder="{{ __('content.enter') }}{{ __('content.backstamp_code') }}"
                        :class="errors.backstamp_code ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required />
                    <p x-show="errors.backstamp_code"
                        x-text="Array.isArray(errors.backstamp_code) ? errors.backstamp_code[0] : errors.backstamp_code"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.backstamp_name') }}</label>
                    <input name="name" type="text" placeholder="{{ __('content.enter') }}{{ __('content.backstamp_name') }}"
                        :class="errors.name ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                    <p x-show="errors.name" x-text="Array.isArray(errors.name) ? errors.name[0] : errors.name"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Customer, Requestor, Status -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.customer') }}</label>
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

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.requestor') }}</label>
                    <select name="requestor_id" :class="errors.requestor_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($requestors as $requestor)
                            <option value="{{ $requestor->id }}">{{ $requestor->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.requestor_id"
                        x-text="errors.requestor_id ? (Array.isArray(errors.requestor_id) ? errors.requestor_id[0] : errors.requestor_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.status') }}</label>
                    <select name="status_id" :class="errors.status_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->status }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.status_id"
                        x-text="errors.status_id ? (Array.isArray(errors.status_id) ? errors.status_id[0] : errors.status_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Glaze Options -->
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('content.glaze_application') }}</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="flex items-center">
                    <input name="in_glaze" type="checkbox" id="in_glaze" value="1"
                        class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="in_glaze" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('content.in_glaze') }}</label>
                </div>
                <div class="flex items-center">
                    <input name="on_glaze" type="checkbox" id="on_glaze" value="1"
                        class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="on_glaze" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('content.on_glaze') }}</label>
                </div>
                <div class="flex items-center">
                    <input name="under_glaze" type="checkbox" id="under_glaze" value="1"
                        class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="under_glaze" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('content.under_glaze') }}</label>
                </div>
                <div class="flex items-center">
                    <input name="air_dry" type="checkbox" id="air_dry" value="1"
                        class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="air_dry" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('content.air_dry') }}</label>
                </div>
            </div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('content.organic') }}</label>
            <div class="flex items-center">
                <input name="organic" type="checkbox" id="organic" value="1"
                    class="rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <label for="organic" class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('content.organic') }}</label>
            </div>
            <!-- Approval Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.approval_date') }}</label>
                    <input name="approval_date" type="date"
                        :class="errors.approval_date ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.approval_date"
                        x-text="errors.approval_date ? (Array.isArray(errors.approval_date) ? errors.approval_date[0] : errors.approval_date) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div class="text-end">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('content.upload_new_images') }}</label>
                    <!-- ปุ่มแทน input file -->
                    <label 
                        for="newImageUpload"
                        class="inline-flex items-center px-6 py-2 bg-blue-600 text-white text-sm font-medium hoverScale rounded-md cursor-pointer hover:bg-blue-700">
                        <svg  class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12V4m0 0l4 4m-4-4L8 8"/>
                        </svg>
                        {{ __('content.select_images') }}
                    </label>
                    <!-- input file ซ่อน -->
                    <input class="hidden" id="newImageUpload" type="file" multiple accept="image/*" @change="handleImageUpload">
                </div>  
            </div>
            <!-- Existing Images and New Image Previews -->
            <div class="rounded-md grid grid-cols-2 gap-4">
                <!-- แสดงตัวอย่างรูปภาพที่เพิ่งอัพโหลด -->
                <div x-show="newImages.length > 0">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('content.new_images_preview') }}
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        <template x-for="(file, index) in newImages" :key="index">
                            <div class="relative group">
                                <img :src="URL.createObjectURL(file)" 
                                    class="w-full h-32 object-cover rounded-lg" 
                                    :alt="file.name">
                                <button type="button" 
                                        @click="removeNewImage(index)"
                                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="CreateBackstampModal = false; errors = {}; newImages = []"
                    class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-600 dark:text-gray-300 dark:hover:bg-gray-500 hoverScale hover:bg-red-500 hover:text-white">{{ __('content.cancel') }}</button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 rounded-md bg-blue-600 dark:bg-blue-500 text-white hoverScale hover:bg-blue-700 dark:hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">{{ __('content.save') }}</span>
                    <span x-show="loading">{{ __('content.saving') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
