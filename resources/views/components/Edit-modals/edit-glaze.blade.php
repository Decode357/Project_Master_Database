<!-- Edit Glaze Modal -->
<script src="{{ asset('js/modals/edit-glaze-modal.js') }}"></script>

<div id="EditGlazeModal" x-show="EditGlazeModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" style="display: none;">

    <!-- Modal Content -->
    <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 overflow-y-auto max-h-[90vh]">
        <h2 class="text-xl font-semibold mb-4">Edit Glaze</h2>
        <hr class="mb-3">
        <form @submit.prevent="submitEditForm" class="space-y-4" x-data="{
            ...editGlazeModal(),
            errors: {},
            loading: false,
            generalErrors: []
        }" x-init="init()">

            <!-- Dynamic Error Display Area -->
            <div x-show="Object.keys(errors).length > 0" class="p-4 bg-red-100 border border-red-400 rounded-md">
                <h4 class="text-red-800 font-semibold">Please correct the following errors</h4>
                <ul class="mt-2 text-red-700 text-sm list-disc list-inside">
                    <template x-for="(error, field) in errors" :key="field">
                        <li x-text="error[0] || error"></li>
                    </template>
                </ul>
            </div>

            <!-- Glaze Code & Name -->
            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Glaze Code</label>
                    <input type="text" name="glaze_code" x-model="glazeToEdit.glaze_code"
                        :class="errors.glaze_code ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2" required />
                    <p x-show="errors.glaze_code"
                        x-text="errors.glaze_code ? (Array.isArray(errors.glaze_code) ? errors.glaze_code[0] : errors.glaze_code) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>
            <!-- Glaze Inside & Outside Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Glaze Inside </label>
                    <select name="glaze_inside_id" x-model="glazeToEdit.glaze_inside_id"
                        :class="errors.glaze_inside_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        <option value="">-</option>
                        @foreach ($glazeInsides as $glazeInside)
                            <option value="{{ $glazeInside->id }}">{{ $glazeInside->glaze_inside_code }} :
                                {{ $glazeInside->colors->pluck('color_name')->join(', ') ?: 'No Color' }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.glaze_inside_id"
                        x-text="errors.glaze_inside_id ? (Array.isArray(errors.glaze_inside_id) ? errors.glaze_inside_id[0] : errors.glaze_inside_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Glaze Outer</label>
                    <select name="glaze_outer_id" x-model="glazeToEdit.glaze_outer_id"
                        :class="errors.glaze_outer_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        <option value="">-</option>
                        @foreach ($glazeOuters as $glazeOuter)
                            <option value="{{ $glazeOuter->id }}">{{ $glazeOuter->glaze_outer_code }} :
                                {{ $glazeOuter->colors->pluck('color_name')->join(', ') ?: 'No Color' }}
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.glaze_outer_id"
                        x-text="errors.glaze_outer_id ? (Array.isArray(errors.glaze_outer_id) ? errors.glaze_outer_id[0] : errors.glaze_outer_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
            </div>
            <!-- Status, Effect -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Effect</label>
                    <select name="effect_id" x-model="glazeToEdit.effect_id"
                        :class="errors.effect_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        <option value="">-</option>
                        @foreach ($effects as $effect)
                            <option value="{{ $effect->id }}">{{ $effect->effect_code }} :
                                <p>{{ $effect->effect_name }}</p>
                            </option>
                        @endforeach
                    </select>
                    <p x-show="errors.effect_id"
                        x-text="errors.effect_id ? (Array.isArray(errors.effect_id) ? errors.effect_id[0] : errors.effect_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status_id" x-model="glazeToEdit.status_id"
                        :class="errors.status_id ? 'border-red-500' : 'border-gray-300'"
                        class="select2 w-full mt-1 border rounded-md px-3 py-2">
                        <option value="">-</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}">{{ $status->status }}</option>
                        @endforeach
                    </select>
                    <p x-show="errors.status_id"
                        x-text="errors.status_id ? (Array.isArray(errors.status_id) ? errors.status_id[0] : errors.status_id) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>                
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Approval Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Approval Date</label>
                    <input type="date" name="approval_date" x-model="glazeToEdit.approval_date"
                        :class="errors.approval_date ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2" />
                    <p x-show="errors.approval_date"
                        x-text="errors.approval_date ? (Array.isArray(errors.approval_date) ? errors.approval_date[0] : errors.approval_date) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>
                <!-- Fire Temperature -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fire Temperature</label>
                    <input type="text" name="fire_temp" x-model="glazeToEdit.fire_temp"
                        :class="errors.fire_temp ? 'border-red-500' : 'border-gray-300'"
                        class="mt-1 w-full border rounded-md px-3 py-2" />
                    <p x-show="errors.fire_temp"
                        x-text="errors.fire_temp ? (Array.isArray(errors.fire_temp) ? errors.fire_temp[0] : errors.fire_temp) : ''"
                        class="text-red-500 text-xs mt-1"></p>
                </div>                
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" @click="EditGlazeModal = false; errors = {}"
                    class="px-4 py-2 rounded-md bg-gray-200 hoverScale hover:bg-red-500 hover:text-white">Cancel</button>
                <button type="submit" :disabled="loading"
                    class="px-4 py-2 rounded-md bg-blue-600 text-white hoverScale hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!loading">Save</span>
                    <span x-show="loading">Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>
