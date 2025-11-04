<!-- Edit Glaze Modal -->
<script src="{{ asset('js/modals/edit-glaze-modal.js') }}"></script>

<div id="EditGlazeModal" x-show="EditGlazeModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('content.edit_glaze') }}</h2>
        <hr class="mb-3 border-gray-200 dark:border-gray-600">
        <form @submit.prevent="submitEditForm" class="space-y-4" x-data="{
            ...editGlazeModal(),
            errors: {},
            loading: false,
            generalErrors: []
        }" x-init="init()">

            <!-- Dynamic Error Display Area -->
            <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 rounded-md">
                <h4 class="text-red-800 dark:text-red-200 font-semibold">{{__('content.please_correct_errors')}}</h4>
                <ul class="mt-2 text-red-700 dark:text-red-300 text-sm list-disc list-inside">
                    <template x-for="(error, field) in errors" :key="field">
                        <li x-text="error[0] || error"></li>
                    </template>
                </ul>
            </div>

            <!-- Glaze Code -->
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.glaze_code') }}</label>
                    <input type="text" name="glaze_code" x-model="glazeToEdit.glaze_code" placeholder="{{ __('content.enter') }}{{ __('content.glaze_code') }}"
                        :class="errors.glaze_code ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent" required />
                    <p x-show="errors.glaze_code"
                        x-text="errors.glaze_code ? (Array.isArray(errors.glaze_code) ? errors.glaze_code[0] : errors.glaze_code) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Glaze Inside & Outside Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.glaze_inside') }}</label>
                    <select name="glaze_inside_id" x-model="glazeToEdit.glaze_inside_id"
                        :class="errors.glaze_inside_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($glazeInsides as $glazeInside)
                            <option value="{{ $glazeInside->id }}">{{ $glazeInside->glaze_inside_code }} :
                                {{ $glazeInside->colors->pluck('color_name')->join(', ') ?: __('content.no_color') }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.glaze_inside_id"
                        x-text="errors.glaze_inside_id ? (Array.isArray(errors.glaze_inside_id) ? errors.glaze_inside_id[0] : errors.glaze_inside_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.glaze_outside') }}</label>
                    <select name="glaze_outer_id" x-model="glazeToEdit.glaze_outer_id"
                        :class="errors.glaze_outer_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($glazeOuters as $glazeOuter)
                            <option value="{{ $glazeOuter->id }}">{{ $glazeOuter->glaze_outer_code }} :
                                {{ $glazeOuter->colors->pluck('color_name')->join(', ') ?: __('content.no_color') }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.glaze_outer_id"
                        x-text="errors.glaze_outer_id ? (Array.isArray(errors.glaze_outer_id) ? errors.glaze_outer_id[0] : errors.glaze_outer_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Status, Effect -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.effect') }}</label>
                    <select name="effect_id" x-model="glazeToEdit.effect_id"
                        :class="errors.effect_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($effects as $effect)
                            <option value="{{ $effect->id }}">{{ $effect->effect_code }} : {{ $effect->effect_name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.effect_id"
                        x-text="errors.effect_id ? (Array.isArray(errors.effect_id) ? errors.effect_id[0] : errors.effect_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.status') }}</label>
                    <select name="status_id" x-model="glazeToEdit.status_id"
                        :class="errors.status_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Fire Temperature -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.fire_temp') }} {{ __('content.°C') }}</label>
                    <input type="text" name="fire_temp" x-model="glazeToEdit.fire_temp" placeholder="{{ __('content.enter') }}{{ __('content.fire_temp') }}"
                        :class="errors.fire_temp ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.fire_temp"
                        x-text="errors.fire_temp ? (Array.isArray(errors.fire_temp) ? errors.fire_temp[0] : errors.fire_temp) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>                   
                <!-- Approval Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.approval_date') }}</label>
                    <input type="date" name="approval_date" x-model="glazeToEdit.approval_date"
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
                <!-- แสดงรูปภาพที่มีอยู่ -->
                <div x-show="glazeToEdit.images && glazeToEdit.images.length > 0">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('content.existing_images') }}
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                        <template x-for="(image, index) in glazeToEdit.images" :key="image.id">
                            <div class="relative group">
                                <img :src="image.url" 
                                    class="w-full h-32 object-cover rounded-lg" 
                                    :alt="image.file_name">
                                <button type="button" 
                                        @click="removeImage(index)"
                                        class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
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
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditGlazeModal = false; errors = {}"
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
