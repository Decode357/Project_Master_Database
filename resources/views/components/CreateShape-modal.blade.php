<div x-show="CreateShapeModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    style="display: none;">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Create Shape</h2>
        <hr class="mb-3">
        <form class="space-y-4">
            <!--form content-->
            
            <!-- ITEM CODE -->
            <div>
                <label class="block text-sm font-medium text-gray-700">ITEM CODE</label>
                <input type="text" placeholder="Enter item code"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 
                           focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    value="ABC123" />
            </div>

            <!-- Description TH & EN -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description (TH)</label>
                    <input type="text" value="ชามเล็ก"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description (EN)</label>
                    <input type="text" value="Small Bowl"
                        class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
            </div>

            <!-- TYPE, STATUS, COLLECTION -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Type</label>
                    <input type="text" value="Ceramic"
                        class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <input type="text" value="Active"
                        class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Collection</label>
                    <input type="text" value="Classic"
                        class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent" />
                </div>
            </div>

            <!-- CUSTOMER, GROUP, PROCESS, DESIGNER -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer</label>
                    <input type="text" value="Acme Corp" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Group</label>
                    <input type="text" value="Kitchenware" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Process</label>
                    <input type="text" value="Hand-made" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Designer</label>
                    <input type="text" value="John Doe" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
            </div>

            <!-- Volume & Weight -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Volume</label>
                    <input type="text" value="250ml" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Weight</label>
                    <input type="text" value="180g" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
            </div>

            <!-- Diameter & Height -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Long Diameter</label>
                    <input type="text" value="12cm" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Short Diameter</label>
                    <input type="text" value="10cm" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Height Long</label>
                    <input type="text" value="8cm" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Height Short</label>
                    <input type="text" value="7cm" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
            </div>

            <!-- Body, Requestor, Approval Date -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Body</label>
                    <input type="text" value="Porcelain" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Requestor</label>
                    <input type="text" value="Alice" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Approval Date</label>
                    <input type="date" value="2025-09-15" class="mt-1 w-full border rounded-md px-3 py-2 border-gray-300" />
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
