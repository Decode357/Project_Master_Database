<!-- Edit Shape Modal -->
<div id="CreateShapeModal" 
     x-show="CreateShapeModal" 
     x-transition.opacity
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
     style="display: none;">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Create Shape</h2>
        <hr class="mb-3">

        <!-- ERROR SUMMARY -->
        @if ($errors->any())
            <div class="mb-4 p-3 rounded-md bg-red-100 text-red-700">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form method="POST" action="{{ route('shape.store') }}" class="space-y-4">
            @csrf
            <!-- ITEM CODE -->
            <div>
                <label class="block text-sm font-medium text-gray-700">ITEM CODE</label>
                <input name="item_code" type="text" placeholder="Enter item code"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    value="{{ old('item_code') }}" required />
            </div>

            <!-- Description TH & EN -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description (TH)</label>
                    <input name="item_description_thai" type="text" value="{{ old('item_description_thai') }}"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description (EN)</label>
                    <input name="item_description_eng" type="text" value="{{ old('item_description_eng') }}"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
            </div>

            <!-- TYPE, STATUS, COLLECTION, PROCESS -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <select name="shape_type_id" required
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($shapeTypes as $type)
                            <option value="{{ $type->id }}"
                                {{ old('shape_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status_id" required
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->status }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Collection</label>
                    <select name="shape_collection_id" required
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">-</option>
                        @foreach ($shapeCollections as $collection)
                            <option value="{{ $collection->id }}"
                                {{ old('shape_collection_id') == $collection->id ? 'selected' : '' }}>
                                {{ $collection->collection_code }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Process</label>
                    <select name="process_id" required
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 border-gray-300">
                        <option value="">-</option>
                        @foreach ($processes as $process)
                            <option value="{{ $process->id }}"
                                {{ old('process_id') == $process->id ? 'selected' : '' }}>
                                {{ $process->process_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- CUSTOMER, GROUP, DESIGNER, Requestor -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Group</label>
                    <select name="item_group_id"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2 border-gray-300">
                        <option value="">-</option>
                        @foreach ($itemGroups as $group)
                            <option value="{{ $group->id }}"
                                {{ old('item_group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->item_group_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer</label>
                    <select name="customer_id" class="select2 w-full mt-1 border rounded-md px-3 py-2 border-gray-300">
                        <option value="">-</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Requestor</label>
                    <select name="requestor_id" class="select2 w-full mt-1 border rounded-md px-3 py-2 border-gray-300">
                        <option value="">-</option>
                        @foreach ($requestors as $requestor)
                            <option value="{{ $requestor->id }}"
                                {{ old('requestor_id') == $requestor->id ? 'selected' : '' }}>
                                {{ $requestor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Designer</label>
                    <select name="designer_id" class="select2 w-full mt-1 border rounded-md px-3 py-2 border-gray-300">
                        <option value="">-</option>
                        @foreach ($designers as $designer)
                            <option value="{{ $designer->id }}"
                                {{ old('designer_id') == $designer->id ? 'selected' : '' }}>
                                {{ $designer->designer_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Volume & Weight -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Volume</label>
                    <input name="volume" type="text" value="{{ old('volume') }}"
                        class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Weight</label>
                    <input name="weight" type="text" value="{{ old('weight') }}"
                        class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
            </div>

            <!-- Diameter & Height -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Long Diameter</label>
                    <input name="long_diameter" type="text" value="{{ old('long_diameter') }}"
                        class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Short Diameter</label>
                    <input name="short_diameter" type="text" value="{{ old('short_diameter') }}"
                        class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Height Long</label>
                    <input name="height_long" type="text" value="{{ old('height_long') }}"
                        class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Height Short</label>
                    <input name="height_short" type="text" value="{{ old('height_short') }}"
                        class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
            </div>

            <!-- Body, Approval Date -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Body</label>
                    <input name="body" type="text" value="{{ old('body') }}"
                        class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Approval Date</label>
                    <input name="approval_date" type="date" value="{{ old('approval_date') }}"
                        class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="CreateShapeModal = false"
                    class="px-4 py-2 rounded-md bg-gray-200 hoverScale hover:bg-red-500 hover:text-white">Cancel</button>
                <button type="submit"
                    class="px-4 py-2 rounded-md bg-blue-600 text-white hoverScale hover:bg-blue-700">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Select2 CSS & JS CDN -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

