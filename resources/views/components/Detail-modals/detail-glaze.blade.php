<!-- Modal Overlay -->
<div x-show="GlazeDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="GlazeDetailModal = false" style="display: none;" x-data="{ zoomImage: false, activeTab: 'basic' }">

    <!-- Modal Content -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-hidden h-[90vh] flex flex-col">

        <!-- Header -->
        <div
            class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 flex justify-between items-center flex-shrink-0">
            <div>
                <h2 class="text-2xl font-bold" x-text="glazeToView?.glaze_code || 'Glaze Details'"></h2>
                <p class="text-blue-100 text-sm mt-1" x-text="glazeToView?.name || 'Glaze Details'"></p>
            </div>
            <button @click="GlazeDetailModal = false"
                class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-hidden">
            <!-- Image and Basic Info Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6 h-full">

                <!-- Image Section -->
                <div class="lg:col-span-1 flex flex-col">
                    <div class="bg-gray-50 rounded-xl p-4 text-center flex-shrink-0">
                        <template x-if="glazeToView?.image?.file_path">
                            <img :src="`{{ asset('storage') }}/${glazeToView.image.file_path}`"
                                :alt="glazeToView.glaze_code"
                                class="rounded-lg shadow-lg cursor-zoom-in mx-auto h-48 object-contain w-full"
                                @click="zoomImage = true">
                        </template>
                        <template x-if="!glazeToView?.image?.file_path">
                            <div class="bg-gray-200 rounded-lg flex items-center justify-center h-48">
                                <div class="text-center text-gray-500">
                                    <span class="material-symbols-outlined text-6xl mb-2 block">image</span>
                                    <p>No Image Available</p>
                                </div>
                            </div>
                        </template>
                        <p class="text-sm text-gray-500 mt-3">
                            <span class="material-symbols-outlined text-lg align-middle">zoom_in</span>
                            Click to zoom
                        </p>
                    </div>

                    <!-- Status Badge -->
                    <div class="mt-4 text-center flex-shrink-0">
                        <template x-if="glazeToView?.status">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium"
                                :class="glazeToView.status.status === 'Active' ? 'bg-green-100 text-green-800' :
                                    glazeToView.status.status === 'Inactive' ? 'bg-red-100 text-red-800' :
                                    'bg-yellow-100 text-yellow-800'">
                                <span class="w-2 h-2 rounded-full mr-2"
                                    :class="glazeToView.status.status === 'Active' ? 'bg-green-500' :
                                        glazeToView.status.status === 'Inactive' ? 'bg-red-500' :
                                        'bg-yellow-500'"></span>
                                <span x-text="glazeToView.status.status"></span>
                            </span>
                        </template>
                    </div>
                </div>

                <!-- Content Section -->
                <div class="lg:col-span-2 flex flex-col overflow-hidden">

                    <!-- All Information Container -->
                    <div class="flex-1 min-h-0 overflow-y-auto overflow-x-hidden">
                        <!-- Basic Information Section -->
                        <div class="mb-1">
                            <h3 class="text-sm font-medium text-blue-600 mb-4 flex items-center border-b pb-2">
                                <span class="material-symbols-outlined text-sm mr-1">info</span>
                                Basic Information
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Glaze Code -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">tag</span>
                                        <span class="font-semibold text-gray-700">Glaze Code</span>
                                    </div>
                                    <p class="text-lg font-mono text-gray-900 break-words"
                                        x-text="glazeToView?.glaze_code || '-'"></p>
                                </div>
                                <!-- Temperature -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">thermostat</span>
                                        <span class="font-semibold text-gray-700">Temperature</span>
                                    </div>
                                    <p class="text-gray-900 break-words"
                                        x-text="glazeToView?.fire_temp ? glazeToView.fire_temp + '°C' : '-'"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Glaze Details Section -->
                        <div class="mb-1">
                            <h3 class="text-sm font-medium text-blue-600 mb-4 flex items-center border-b pb-2">
                                <span class="material-symbols-outlined text-sm mr-1">palette</span>
                                Glaze Details
                            </h3>
                            <div class="space-y-3">
                                <!-- Effect Information -->
                                <div
                                    class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                                    <div class="flex items-center mb-3">
                                        <span
                                            class="material-symbols-outlined text-purple-600 mr-2">auto_fix_high</span>
                                        <span class="font-semibold text-gray-700 text-lg">Effect</span>
                                    </div>
                                    <div class="flex flex-row items-center gap-3">
                                        <p class="text-sm font-medium text-purple-700">Name:</p>
                                        <p class="text-lg font-medium text-purple-800 break-words"
                                        x-text="glazeToView?.effect?.effect_name || '-'"></p>
                                    </div>
                                    <template x-if="glazeToView?.effect?.description">

                                        <p class="text-sm text-purple-700 mt-2" x-text="glazeToView.effect.description">
                                        </p>
                                    </template>
                                    <!-- Effect Colors -->
                                    <template
                                        x-if="glazeToView?.effect?.colors && glazeToView.effect.colors.length > 0">
                                        <div class="mt-3 flex-row flex items-center">
                                            <p class="text-sm font-medium text-purple-700 mb-2">Colors:</p>
                                            <div class="flex flex-wrap gap-2 ml-2">
                                                <template x-for="color in glazeToView.effect.colors"
                                                    :key="color.id">
                                                    <span
                                                        class="inline-flex items-center  px-3 py-1 rounded-full text-xs font-medium bg-white text-purple-800">
                                                        <span class="w-3 h-3 rounded-full mr-2 "
                                                            :style="'background-color: ' + (color.color_code || '#10B981')"></span>
                                                        <span x-text="color.color_name"></span>
                                                    </span>
                                                </template>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div>
                                    <!-- Glaze Inside Information -->
                                    <div
                                        class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200 mb-3">
                                        <div class="flex items-center mb-3 ">
                                            <span class="material-symbols-outlined text-green-600 mr-2">layers</span>
                                            <span class="font-semibold text-gray-700 text-lg">Glaze</span>
                                        </div>

                                        <!-- Inside Colors -->
                                        <template
                                            x-if="glazeToView?.glaze_inside?.colors && glazeToView.glaze_inside.colors.length > 0">
                                            <div class="mt-3 flex-row flex">
                                                <p class="text-sm font-medium text-green-700 mb-2">Inside :</p>
                                                <div class="flex flex-wrap gap-2 ml-2 items-center">
                                                    <template x-for="color in glazeToView.glaze_inside.colors"
                                                        :key="color.id">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-green-800">
                                                            <span class="w-3 h-3 rounded-full mr-2 "
                                                                :style="'background-color: ' + (color.color_code || '#10B981')"></span>
                                                            <span x-text="color.color_name"></span>
                                                        </span>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- Outer Colors -->
                                        <template
                                            x-if="glazeToView?.glaze_outer?.colors && glazeToView.glaze_outer.colors.length > 0">
                                            <div class="mt-3 flex-row flex">
                                                <p class="text-sm font-medium text-green-700 mb-2">Outer :</p>
                                                <div class="flex flex-wrap gap-2 ml-2 items-center">
                                                    <template x-for="color in glazeToView.glaze_outer.colors"
                                                        :key="color.id">
                                                        <span
                                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-green-800">
                                                            <span class="w-3 h-3 rounded-full mr-2 "
                                                                :style="'background-color: ' + (color.color_code || '#F97316')"></span>
                                                            <span x-text="color.color_name"></span>
                                                        </span>
                                                    </template>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>



                                <!-- Last Updated Info -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h4 class="font-semibold text-gray-700 mb-3 flex items-center">
                                        <span class="material-symbols-outlined mr-2">history</span>
                                        Update Information
                                    </h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Last Updated By:</p>
                                            <p class="font-medium break-words"
                                                x-text="glazeToView?.updater?.name || 'System'"></p>
                                        </div>
                                        <div>
                                            <p class="text-gray-600">Updated At:</p>
                                            <p class="font-medium"
                                                x-text="glazeToView?.updated_at ? new Date(glazeToView.updated_at).toLocaleString('th-TH') : '-'">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-t flex-shrink-0">
            <div class="text-sm text-gray-500">
                <span class="material-symbols-outlined text-sm mr-1">schedule</span>
                Created: <span
                    x-text="glazeToView?.created_at ? new Date(glazeToView.created_at).toLocaleDateString('th-TH') : '-'"></span>
            </div>
            <button @click="GlazeDetailModal = false"
                class="bg-gray-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg transition-all duration-200 hoverScale">
                <span class="material-symbols-outlined text-sm mr-1 mt-1">close</span>
                Close
            </button>
        </div>
    </div>

    <!-- Zoom Image Modal -->
    <div x-show="zoomImage" x-transition.opacity
        class="fixed inset-0 bg-black bg-opacity-95 flex items-center justify-center z-60"
        @click.self="zoomImage = false">
        <div class="relative max-h-[95vh] max-w-[95vw]">
            <template x-if="glazeToView?.image?.file_path">
                <img :src="`{{ asset('storage') }}/${glazeToView.image.file_path}`" :alt="glazeToView.glaze_code"
                    class="max-h-[95vh] max-w-[95vw] object-contain rounded-lg shadow-2xl cursor-zoom-out"
                    @click="zoomImage = false">
            </template>
            <template x-if="!glazeToView?.image?.file_path">
                <div class="bg-white rounded-lg p-8 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4 block">image</span>
                    <p class="text-gray-600">No Image Available</p>
                </div>
            </template>
            <!-- Close button -->
            <button @click="zoomImage = false"
                class="absolute top-4 right-4 bg-black bg-opacity-50 text-white rounded-full p-2 hover:bg-opacity-70 transition-all">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
    </div>
</div>
