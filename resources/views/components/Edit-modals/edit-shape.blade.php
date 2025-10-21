<!-- Edit Shape Modal -->
<script src="{{ asset('js/modals/edit-shape-modal.js') }}"></script>

<div id="EditShapeModal" x-show="EditShapeModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-gray-100">Edit Shape</h2>
        <hr class="mb-3 border-gray-200 dark:border-gray-600">
        <form @submit.prevent="submitEditForm" class="space-y-4" x-data="{
            ...editShapeModal(),
            errors: {},
            loading: false,
            generalErrors: []
        }" x-init="init()">

            <!-- Dynamic Error Display Area -->
            <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 rounded-md">
                <h4 class="text-red-800 dark:text-red-200 font-semibold">Please correct the following errors</h4>
                <ul class="mt-2 text-red-700 dark:text-red-300 text-sm list-disc list-inside">
                    <template x-for="(error, field) in errors" :key="field">
                        <li x-text="error[0] || error"></li>
                    </template>
                </ul>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">ITEM CODE</label>
                <input type="text" name="item_code" x-model="shapeToEdit.item_code"
                    :class="errors.item_code ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                    class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400
                        focus:ring-2 focus:ring-blue-500 focus:border-transparent" required />
                <p x-show="errors.item_code"
                    x-text="errors.item_code ? (Array.isArray(errors.item_code) ? errors.item_code[0] : errors.item_code) : ''"
                    class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description (TH)</label>
                    <input type="text" name="item_description_thai" x-model="shapeToEdit.item_description_thai"
                        :class="errors.item_description_thai ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.item_description_thai"
                        x-text="errors.item_description_thai ? (Array.isArray(errors.item_description_thai) ? errors.item_description_thai[0] : errors.item_description_thai) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description (EN)</label>
                    <input type="text" name="item_description_eng" x-model="shapeToEdit.item_description_eng"
                        :class="errors.item_description_eng ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                    <p x-show="errors.item_description_eng"
                        x-text="errors.item_description_eng ? (Array.isArray(errors.item_description_eng) ? errors.item_description_eng[0] : errors.item_description_eng) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                    <select name="shape_type_id" x-model="shapeToEdit.shape_type_id"
                        :class="errors.shape_type_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($shapeTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.shape_type_id"
                        x-text="errors.shape_type_id ? (Array.isArray(errors.shape_type_id) ? errors.shape_type_id[0] : errors.shape_type_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status_id" x-model="shapeToEdit.status_id"
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
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Collection</label>
                    <select name="shape_collection_id" x-model="shapeToEdit.shape_collection_id"
                        :class="errors.shape_collection_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($shapeCollections as $collection)
                            <option value="{{ $collection->id }}">{{ $collection->collection_code }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.shape_collection_id"
                        x-text="errors.shape_collection_id ? (Array.isArray(errors.shape_collection_id) ? errors.shape_collection_id[0] : errors.shape_collection_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Process</label>
                    <select name="process_id" x-model="shapeToEdit.process_id"
                        :class="errors.process_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">-</option>
                        @foreach ($processes as $process)
                            <option value="{{ $process->id }}">{{ $process->process_name }}</option>
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
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Group</label>
                    <select name="item_group_id" x-model="shapeToEdit.item_group_id"
                        :class="errors.item_group_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">-</option>
                        @foreach ($itemGroups as $group)
                            <option value="{{ $group->id }}">{{ $group->item_group_name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.item_group_id"
                        x-text="errors.item_group_id ? (Array.isArray(errors.item_group_id) ? errors.item_group_id[0] : errors.item_group_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Customer</label>
                    <select name="customer_id" x-model="shapeToEdit.customer_id"
                        :class="errors.customer_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
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
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Requestor</label>
                    <select name="requestor_id" x-model="shapeToEdit.requestor_id"
                        :class="errors.requestor_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
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
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Designer</label>
                    <select name="designer_id" x-model="shapeToEdit.designer_id"
                        :class="errors.designer_id ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100">
                        <option value="">-</option>
                        @foreach ($designers as $designer)
                            <option value="{{ $designer->id }}">{{ $designer->designer_name }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.designer_id"
                        x-text="errors.designer_id ? (Array.isArray(errors.designer_id) ? errors.designer_id[0] : errors.designer_id) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <!-- Volume & Weight -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Volume</label>
                    <input type="text" name="volume" x-model="shapeToEdit.volume"
                        :class="errors.volume ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.volume"
                        x-text="errors.volume ? (Array.isArray(errors.volume) ? errors.volume[0] : errors.volume) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Weight</label>
                    <input type="text" name="weight" x-model="shapeToEdit.weight"
                        :class="errors.weight ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.weight"
                        x-text="errors.weight ? (Array.isArray(errors.weight) ? errors.weight[0] : errors.weight) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>
            <!-- Diameter & Height -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Long Diameter</label>
                    <input type="text" name="long_diameter" x-model="shapeToEdit.long_diameter"
                        :class="errors.long_diameter ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.long_diameter"
                        x-text="errors.long_diameter ? (Array.isArray(errors.long_diameter) ? errors.long_diameter[0] : errors.long_diameter) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Short Diameter</label>
                    <input type="text" name="short_diameter" x-model="shapeToEdit.short_diameter"
                        :class="errors.short_diameter ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.short_diameter"
                        x-text="errors.short_diameter ? (Array.isArray(errors.short_diameter) ? errors.short_diameter[0] : errors.short_diameter) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Height Long</label>
                    <input type="text" name="height_long" x-model="shapeToEdit.height_long"
                        :class="errors.height_long ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.height_long"
                        x-text="errors.height_long ? (Array.isArray(errors.height_long) ? errors.height_long[0] : errors.height_long) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Height Short</label>
                    <input type="text" name="height_short" x-model="shapeToEdit.height_short"
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
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Body</label>
                    <input type="text" name="body" x-model="shapeToEdit.body"
                        :class="errors.body ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-400" />
                    <p x-show="errors.body"
                        x-text="errors.body ? (Array.isArray(errors.body) ? errors.body[0] : errors.body) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Approval Date</label>
                    <input type="date" name="approval_date" x-model="shapeToEdit.approval_date"
                        :class="errors.approval_date ? 'border-red-500' : 'border-gray-300 dark:border-gray-600'"
                        class="mt-1 w-full border rounded-md px-3 py-2 dark:bg-gray-700 dark:text-gray-100" />
                    <p x-show="errors.approval_date"
                        x-text="errors.approval_date ? (Array.isArray(errors.approval_date) ? errors.approval_date[0] : errors.approval_date) : ''"
                        class="text-red-500 dark:text-red-400 text-xs mt-1"></p>
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditShapeModal = false; errors = {}"
                    class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-600 dark:text-gray-100 hoverScale hover:bg-red-500 hover:text-white">Cancel</button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 rounded-md bg-blue-600 text-white hoverScale hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Save</span>
                    <span x-show="loading">Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>
