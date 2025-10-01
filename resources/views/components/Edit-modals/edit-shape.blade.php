<!-- Edit Shape Modal -->
<div id="EditShapeModal" 
     x-show="EditShapeModal" 
     x-transition.opacity
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
     style="display: none;">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Edit Shape</h2>
        <hr class="mb-3">
        <form :action="`/shape/${shapeToEdit.id}`" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">ITEM CODE</label>
                <input type="text" name="item_code" x-model="shapeToEdit.item_code" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" required />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description (TH)</label>
                    <input type="text" name="item_description_thai" x-model="shapeToEdit.item_description_thai" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" required />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description (EN)</label>
                    <input type="text" name="item_description_eng" x-model="shapeToEdit.item_description_eng" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" required />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select wire:ignore name="shape_type_id" x-model="shapeToEdit.shape_type_id" class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        @foreach ($shapeTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select wire:ignore name="status_id" x-model="shapeToEdit.status_id" class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->status }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Collection</label>
                    <select wire:ignore name="shape_collection_id" x-model="shapeToEdit.shape_collection_id" class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        @foreach ($shapeCollections as $collection)
                            <option value="{{ $collection->id }}">{{ $collection->collection_code }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Process</label>
                    <select wire:ignore name="process_id" x-model="shapeToEdit.process_id" class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        @foreach ($processes as $process)
                            <option value="{{ $process->id }}">{{ $process->process_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Group</label>
                    <select wire:ignore name="item_group_id" x-model="shapeToEdit.item_group_id" class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        @foreach ($itemGroups as $group)
                            <option value="{{ $group->id }}">{{ $group->item_group_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer</label>
                    <select wire:ignore name="customer_id" x-model="shapeToEdit.customer_id" class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Requestor</label>
                    <select wire:ignore name="requestor_id" x-model="shapeToEdit.requestor_id" class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        @foreach ($requestors as $requestor)
                            <option value="{{ $requestor->id }}">{{ $requestor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Designer</label>
                    <select wire:ignore name="designer_id" x-model="shapeToEdit.designer_id" class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        @foreach ($designers as $designer)
                            <option value="{{ $designer->id }}">{{ $designer->designer_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Volume & Weight -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Volume</label>
                    <input type="text" name="volume" x-model="shapeToEdit.volume" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Weight</label>
                    <input type="text" name="weight" x-model="shapeToEdit.weight" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
            </div>
            <!-- Diameter & Height -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Long Diameter</label>
                    <input type="text" name="long_diameter" x-model="shapeToEdit.long_diameter" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Short Diameter</label>
                    <input type="text" name="short_diameter" x-model="shapeToEdit.short_diameter" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Height Long</label>
                    <input type="text" name="height_long" x-model="shapeToEdit.height_long" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Height Short</label>
                    <input type="text" name="height_short" x-model="shapeToEdit.height_short" class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2" />
                </div>
            </div>
            <!-- Body, Approval Date -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Body</label>
                    <input type="text" name="body" x-model="shapeToEdit.body" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Approval Date</label>
                    <input type="date" name="approval_date" x-model="shapeToEdit.approval_date" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditShapeModal = false" class="px-4 py-2 rounded-md bg-gray-200 hoverScale hover:bg-red-500 hover:text-white">Cancel</button>
                <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white hoverScale hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</div>
