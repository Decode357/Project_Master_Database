<!-- Create Shape Modal -->
<script src="{{ asset('js/modals/create-shape-modal.js') }}"></script>

<div id="CreateShapeModal" x-show="CreateShapeModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <!-- Modal Content -->
    <div x-data="shapeModal()" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-4xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('content.create_shape') }}</h2>
        <hr class="mb-3 border-gray-200 dark:border-gray-600">

        <form @submit.prevent="submitShapeForm($event)" class="space-y-4">
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
            <div class="grid grid-cols-3 gap-4">
            <!-- ITEM CODE --><!-- Description TH & EN -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('content.shape_code') }}</label>
                    <input name="item_code" type="text" placeholder="{{ __('content.enter') }}{{ __('content.shape_code') }}"
                        :class="errors.item_code ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                            focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required />
                    <p x-show="errors.item_code"
                        x-text="Array.isArray(errors.item_code) ? errors.item_code[0] : errors.item_code"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.description_th') }}</label>
                    <input name="item_description_thai" type="text" placeholder="{{ __('content.enter') }}{{ __('content.description_th') }}" value="{{ old('item_description_thai') }}"
                        :class="errors.item_description_thai ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.item_description_thai"
                        x-text="errors.item_description_thai ? (Array.isArray(errors.item_description_thai) ? errors.item_description_thai[0] : errors.item_description_thai) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.description_en') }}</label>
                    <input name="item_description_eng" type="text" placeholder="{{ __('content.enter') }}{{ __('content.description_en') }}" value="{{ old('item_description_eng') }}"
                        :class="errors.item_description_eng ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.item_description_eng"
                        x-text="errors.item_description_eng ? (Array.isArray(errors.item_description_eng) ? errors.item_description_eng[0] : errors.item_description_eng) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- TYPE, STATUS, COLLECTION, PROCESS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <div class="grid grid-cols-2 items-end">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.type') }}</label>
                        <label class="block text-xs font-medium text-red-700 dark:text-red-300 text-end">{{__('content.select_only')}}</label>
                    </div>
                    <select name="shape_type_id" :class="errors.shape_type_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($shapeTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ old('shape_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.shape_type_id"
                        x-text="errors.shape_type_id ? (Array.isArray(errors.shape_type_id) ? errors.shape_type_id[0] : errors.shape_type_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <div class="grid grid-cols-2 items-end">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.status') }}</label>
                        <label class="block text-xs font-medium text-red-700 dark:text-red-300 text-end">{{__('content.select_only')}}</label>
                    </div>                    
                    <select name="status_id" :class="errors.status_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->status }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.status_id"
                        x-text="errors.status_id ? (Array.isArray(errors.status_id) ? errors.status_id[0] : errors.status_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <div class="grid grid-cols-2 items-end">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.collection_2') }}</label>
                        <label class="block text-xs font-medium text-red-700 dark:text-red-300 text-end">{{__('content.select_only')}}</label>
                    </div>  
                    <select name="shape_collection_id"
                        :class="errors.shape_collection_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($shapeCollections as $collection)
                            <option value="{{ $collection->id }}"
                                {{ old('shape_collection_id') == $collection->id ? 'selected' : '' }}>
                                {{ $collection->collection_code }} : {{ $collection->collection_name }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.shape_collection_id"
                        x-text="errors.shape_collection_id ? (Array.isArray(errors.shape_collection_id) ? errors.shape_collection_id[0] : errors.shape_collection_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <div class="grid grid-cols-2 items-end">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.process') }}</label>
                        <label class="block text-xs font-medium text-green-700 dark:text-green-300 text-end">{{__('content.can_add')}}</label>
                    </div>  
                    <select name="process_id" :class="errors.process_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">-</option>
                        @foreach ($processes as $process)
                            <option value="{{ $process->id }}"
                                {{ old('process_id') == $process->id ? 'selected' : '' }}>
                                {{ $process->process_name }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.process_id"
                        x-text="errors.process_id ? (Array.isArray(errors.process_id) ? errors.process_id[0] : errors.process_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- CUSTOMER, GROUP, DESIGNER, Requestor -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <div class="grid grid-cols-2 items-end">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.group') }}</label>
                        <label class="block text-xs font-medium text-red-700 dark:text-red-300 text-end">{{__('content.select_only')}}</label>
                    </div>  
                    <select name="item_group_id" :class="errors.item_group_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        <option value="">-</option>
                        @foreach ($itemGroups as $group)
                            <option value="{{ $group->id }}"
                                {{ old('item_group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->item_group_name }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.item_group_id"
                        x-text="errors.item_group_id ? (Array.isArray(errors.item_group_id) ? errors.item_group_id[0] : errors.item_group_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <div class="grid grid-cols-2 items-end">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.customer') }}</label>
                        <label class="block text-xs font-medium text-red-700 dark:text-red-300 text-end">{{__('content.select_only')}}</label>
                    </div> 
                    <select name="customer_id" :class="errors.customer_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        <option value="">-</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->code }} : {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.customer_id"
                        x-text="errors.customer_id ? (Array.isArray(errors.customer_id) ? errors.customer_id[0] : errors.customer_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <div class="grid grid-cols-2 items-end">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.requestor') }}</label>
                        <label class="block text-xs font-medium text-green-700 dark:text-green-300 text-end">{{__('content.can_add')}}</label>
                    </div>  
                    <select name="requestor_id" :class="errors.requestor_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        <option value="">-</option>
                        @foreach ($requestors as $requestor)
                            <option value="{{ $requestor->id }}"
                                {{ old('requestor_id') == $requestor->id ? 'selected' : '' }}>
                                {{ $requestor->name }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.requestor_id"
                        x-text="errors.requestor_id ? (Array.isArray(errors.requestor_id) ? errors.requestor_id[0] : errors.requestor_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>

                <div>
                    <div class="grid grid-cols-2 items-end">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.designer') }}</label>
                        <label class="block text-xs font-medium text-green-700 dark:text-green-300 text-end">{{__('content.can_add')}}</label>
                    </div>  
                    <select name="designer_id" :class="errors.designer_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        <option value="">-</option>
                        @foreach ($designers as $designer)
                            <option value="{{ $designer->id }}"
                                {{ old('designer_id') == $designer->id ? 'selected' : '' }}>
                                {{ $designer->designer_name }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.designer_id"
                        x-text="errors.designer_id ? (Array.isArray(errors.designer_id) ? errors.designer_id[0] : errors.designer_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Volume & Weight -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.volume') }} {{__('content.cc') }}</label>
                    <input name="volume" type="text" value="{{ old('volume') }}" placeholder="{{ __('content.enter') }}{{ __('content.volume') }}"
                        :class="errors.volume ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.volume"
                        x-text="errors.volume ? (Array.isArray(errors.volume) ? errors.volume[0] : errors.volume) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.weight') }} {{__('content.g') }}</label>
                    <input name="weight" type="text" value="{{ old('weight') }}" placeholder="{{ __('content.enter') }}{{ __('content.weight') }}"
                        :class="errors.weight ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.weight"
                        x-text="errors.weight ? (Array.isArray(errors.weight) ? errors.weight[0] : errors.weight) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Diameter & Height -->
            <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.long_diameter') }} {{__('content.mm') }}</label>
                    <input name="long_diameter" type="text" value="{{ old('long_diameter') }}" placeholder="{{ __('content.enter') }}{{ __('content.long_diameter') }}"
                        :class="errors.long_diameter ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.long_diameter"
                        x-text="errors.long_diameter ? (Array.isArray(errors.long_diameter) ? errors.long_diameter[0] : errors.long_diameter) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.short_diameter') }} {{__('content.mm') }}</label>
                    <input name="short_diameter" type="text" value="{{ old('short_diameter') }}" placeholder="{{ __('content.enter') }}{{ __('content.short_diameter') }}"
                        :class="errors.short_diameter ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.short_diameter"
                        x-text="errors.short_diameter ? (Array.isArray(errors.short_diameter) ? errors.short_diameter[0] : errors.short_diameter) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.height_long') }} {{__('content.mm') }}</label>
                    <input name="height_long" type="text" value="{{ old('height_long') }}" placeholder="{{ __('content.enter') }}{{ __('content.height_long') }}"
                        :class="errors.height_long ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.height_long"
                        x-text="errors.height_long ? (Array.isArray(errors.height_long) ? errors.height_long[0] : errors.height_long) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.height_short') }} {{__('content.mm') }}</label>
                    <input name="height_short" type="text" value="{{ old('height_short') }}" placeholder="{{ __('content.enter') }}{{ __('content.height_short') }}"
                        :class="errors.height_short ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.height_short"
                        x-text="errors.height_short ? (Array.isArray(errors.height_short) ? errors.height_short[0] : errors.height_short) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Body, Approval Date -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.body') }} {{__('content.mm') }}</label>
                    <input name="body" type="text" value="{{ old('body') }}" placeholder="{{ __('content.enter') }}{{ __('content.body') }}"
                        :class="errors.body ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.body"
                        x-text="errors.body ? (Array.isArray(errors.body) ? errors.body[0] : errors.body) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{__('content.approval_date') }}</label>
                    <input name="approval_date" type="date" value="{{ old('approval_date') }}"
                        :class="errors.approval_date ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100" />
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
                    <div class="grid grid-cols-2 md:grid-cols-6 gap-2">
                        <template x-for="(file, index) in newImages" :key="index">
                            <div class="relative group">
                                <img :src="URL.createObjectURL(file)" 
                                    class="w-full h-16 object-cover rounded-lg ring-green-500 ring-2" 
                                    :alt="file.name">
                                <button type="button" 
                                        @click="removeNewImage(index)"
                                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1">
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
                <button type="button" @click="CreateShapeModal = false; errors = {}; newImages = []"
                    class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-600 dark:text-gray-100 hoverScale hover:bg-red-500 hover:text-white">{{ __('content.cancel') }}</button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 rounded-md bg-blue-600 text-white hoverScale hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">{{ __('content.save') }}</span>
                    <span x-show="loading">{{ __('content.saving') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
