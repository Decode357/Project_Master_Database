<!-- Modal Overlay -->
<div x-show="BackstampDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="BackstampDetailModal = false" style="display: none;" x-data="{ zoomImage: false, activeTab: 'basic' }">

    <!-- Modal Content -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-hidden h-[90vh] flex flex-col">

        <!-- Header -->
        <div
            class="bg-gradient-to-r from-blue-600 to-blue-800 text-white p-6 flex justify-between items-center flex-shrink-0">
            <div>
                <h2 class="text-2xl font-bold" x-text="backstampToView?.backstamp_code || 'Backstamp Details'"></h2>
                <p class="text-blue-100 text-sm mt-1" x-text="backstampToView?.name || 'Backstamp Details'"></p>
            </div>
            <button @click="BackstampDetailModal = false"
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
                        <template x-if="backstampToView?.image?.file_path">
                            <img :src="`{{ asset('storage') }}/${backstampToView.image.file_path}`"
                                :alt="backstampToView.backstamp_code"
                                class="rounded-lg shadow-lg cursor-zoom-in mx-auto h-48 object-contain w-full"
                                @click="zoomImage = true">
                        </template>
                        <template x-if="!backstampToView?.image?.file_path">
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
                        <template x-if="backstampToView?.status">
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium"
                                :class="backstampToView.status.status === 'Active' ? 'bg-green-100 text-green-800' :
                                    backstampToView.status.status === 'Inactive' ? 'bg-red-100 text-red-800' :
                                    'bg-yellow-100 text-yellow-800'">
                                <span class="w-2 h-2 rounded-full mr-2"
                                    :class="backstampToView.status.status === 'Active' ? 'bg-green-500' :
                                        backstampToView.status.status === 'Inactive' ? 'bg-red-500' :
                                        'bg-yellow-500'"></span>
                                <span x-text="backstampToView.status.status"></span>
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
                                <!-- Backstamp Code -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">tag</span>
                                        <span class="font-semibold text-gray-700">Backstamp Code</span>
                                    </div>
                                    <p class="text-lg font-mono text-gray-900 break-words"
                                        x-text="backstampToView?.backstamp_code || '-'"></p>
                                </div>

                                <!-- Name -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">label</span>
                                        <span class="font-semibold text-gray-700">Name</span>
                                    </div>
                                    <p class="text-lg text-gray-900 break-words" x-text="backstampToView?.name || '-'">
                                    </p>
                                </div>

                                <!-- Duration -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">timer</span>
                                        <span class="font-semibold text-gray-700">Duration</span>
                                    </div>
                                    <p class="text-gray-900 break-words" x-text="backstampToView?.duration || '-'"></p>
                                </div>

                                <!-- Approval Date -->
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center mb-2">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">event</span>
                                        <span class="font-semibold text-gray-700">Approval Date</span>
                                    </div>
                                    <p class="text-gray-900 break-words"
                                        x-text="backstampToView?.approval_date ? new Date(backstampToView.approval_date).toLocaleDateString('th-TH') : '-'">
                                    </p>
                                </div>

                                <!-- Application Types Section -->
                                <div class="bg-gray-50 rounded-lg p-4 sm:col-span-2">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">colorize</span>
                                        <span class="font-semibold text-gray-700">Application Types</span>
                                    </div>
                                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                        <!-- In Glaze -->
                                        <div class="flex items-center">
                                            <template x-if="backstampToView?.in_glaze">
                                                <div class="flex items-center text-green-700">
                                                    <span
                                                        class="material-symbols-outlined text-green-600 mr-1">check_circle</span>
                                                    <span class="text-sm font-medium">In Glaze</span>
                                                </div>
                                            </template>
                                            <template x-if="!backstampToView?.in_glaze">
                                                <div class="flex items-center text-gray-400">
                                                    <span
                                                        class="material-symbols-outlined text-gray-400 mr-1">cancel</span>
                                                    <span class="text-sm">In Glaze</span>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- On Glaze -->
                                        <div class="flex items-center">
                                            <template x-if="backstampToView?.on_glaze">
                                                <div class="flex items-center text-green-700">
                                                    <span
                                                        class="material-symbols-outlined text-green-600 mr-1">check_circle</span>
                                                    <span class="text-sm font-medium">On Glaze</span>
                                                </div>
                                            </template>
                                            <template x-if="!backstampToView?.on_glaze">
                                                <div class="flex items-center text-gray-400">
                                                    <span
                                                        class="material-symbols-outlined text-gray-400 mr-1">cancel</span>
                                                    <span class="text-sm">On Glaze</span>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Under Glaze -->
                                        <div class="flex items-center">
                                            <template x-if="backstampToView?.under_glaze">
                                                <div class="flex items-center text-green-700">
                                                    <span
                                                        class="material-symbols-outlined text-green-600 mr-1">check_circle</span>
                                                    <span class="text-sm font-medium">Under Glaze</span>
                                                </div>
                                            </template>
                                            <template x-if="!backstampToView?.under_glaze">
                                                <div class="flex items-center text-gray-400">
                                                    <span
                                                        class="material-symbols-outlined text-gray-400 mr-1">cancel</span>
                                                    <span class="text-sm">Under Glaze</span>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Air Dry -->
                                        <div class="flex items-center">
                                            <template x-if="backstampToView?.air_dry">
                                                <div class="flex items-center text-green-700">
                                                    <span
                                                        class="material-symbols-outlined text-green-600 mr-1">check_circle</span>
                                                    <span class="text-sm font-medium">Air Dry</span>
                                                </div>
                                            </template>
                                            <template x-if="!backstampToView?.air_dry">
                                                <div class="flex items-center text-gray-400">
                                                    <span
                                                        class="material-symbols-outlined text-gray-400 mr-1">cancel</span>
                                                    <span class="text-sm">Air Dry</span>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Relations Section -->
                        <div class="mb-1">
                            <h3 class="text-sm font-medium text-blue-600 mb-4 flex items-center border-b pb-2">
                                <span class="material-symbols-outlined text-sm mr-1">group</span>
                                Relations
                            </h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                                <!-- Customer -->
                                <div
                                    class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-blue-600 mr-2">business</span>
                                        <span class="font-semibold text-gray-700">Customer</span>
                                    </div>
                                    <p class="text-lg font-medium text-blue-800 break-words"
                                        x-text="backstampToView?.customer?.name || '-'"></p>
                                </div>

                                <!-- Requestor -->
                                <div
                                    class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                                    <div class="flex items-center mb-3">
                                        <span class="material-symbols-outlined text-red-600 mr-2">person</span>
                                        <span class="font-semibold text-gray-700">Requestor</span>
                                    </div>
                                    <p class="text-lg font-medium text-red-800 break-words"
                                        x-text="backstampToView?.requestor?.name || '-'"></p>
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
                                            x-text="backstampToView?.updater?.name || 'System'"></p>
                                    </div>
                                    <div>
                                        <p class="text-gray-600">Updated At:</p>
                                        <p class="font-medium"
                                            x-text="backstampToView?.updated_at ? new Date(backstampToView.updated_at).toLocaleString('th-TH') : '-'">
                                        </p>
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
                    x-text="backstampToView?.created_at ? new Date(backstampToView.created_at).toLocaleDateString('th-TH') : '-'"></span>
            </div>
            <button @click="BackstampDetailModal = false"
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
            <template x-if="backstampToView?.image?.file_path">
                <img :src="`{{ asset('storage') }}/${backstampToView.image.file_path}`"
                    :alt="backstampToView.backstamp_code"
                    class="max-h-[95vh] max-w-[95vw] object-contain rounded-lg shadow-2xl cursor-zoom-out"
                    @click="zoomImage = false">
            </template>
            <template x-if="!backstampToView?.image?.file_path">
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
