<!-- Modal Overlay -->
<div x-show="GlazeDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="GlazeDetailModal = false" style="display: none;"
    x-data="{ 
        zoomImage: false, 
        activeTab: 'info',
        currentImageIndex: 0,
        get currentImage() {
            return this.glazeToView?.images && this.glazeToView.images.length > 0 
                ? this.glazeToView.images[this.currentImageIndex] 
                : null;
        }
    }">
    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-visible h-[90vh] flex flex-col">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-800 dark:from-purple-700 dark:to-purple-900 text-white p-6 flex justify-between items-center flex-shrink-0 rounded-t-2xl">
            <div>
                <h2 class="text-2xl font-bold" x-text="glazeToView?.glaze_code || '{{ __('content.details') }} {{ __('content.glaze') }}'"></h2>
                <p class="text-purple-100 dark:text-purple-200 text-sm mt-1" x-text="glazeToView?.glaze_name || '{{ __('content.details') }} {{ __('content.glaze') }}'"></p>
            </div>
            <button @click="GlazeDetailModal = false"
                class="text-white ml-auto hoverScale">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-6 h-full">
                
                <!-- Left Column -->
                <div class="lg:col-span-1 flex flex-col">
                    @include('components.Detail-modals.partials.image-section', [
                        'item' => 'glazeToView',
                        'ringColor' => 'ring-purple-500',
                        'fileNameFormat' => 'glaze',
                    ])
                    
                    @include('components.Detail-modals.partials.status-section', [
                        'item' => 'glazeToView',
                        'showProcess' => false
                    ])
                    
                    @include('components.Detail-modals.partials.update-info', [
                        'item' => 'glazeToView'
                    ])
                </div>

                <!-- Right Column - Your existing tabs content -->
                <div class="lg:col-span-2 flex flex-col overflow-visible">
                    
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-6 flex-shrink-0">
                        <nav class="flex space-x-8">
                            <button @click="activeTab = 'info'"
                                :class="activeTab === 'info' ? 'border-purple-500 text-purple-600 dark:text-purple-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">info</span>
                                {{ __('content.information') }}
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content Container -->
                    <div class="flex-1 min-h-0">
                        <!-- Information Tab -->
                        <div x-show="activeTab === 'info'" class="h-full overflow-y-auto overflow-x-hidden flex flex-col gap-2 font-lg text-lg">
                            
                            <!-- Glaze Code -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">qr_code_2</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.glaze_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.glaze_code || '-'"></span>
                            </div>
                            
                            <!-- Temperature -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-red-600 dark:text-red-400">device_thermostat</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.fire_temp') }}:
                                </label>
                                <span 
                                    class="text-gray-900 dark:text-gray-100"
                                    x-text="glazeToView?.fire_temp ? glazeToView.fire_temp + ' {{ __('content.°C_full') }}' : '-'">
                                </span>

                            </div>

                            <!-- Approval Date -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">Order_Approve</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.approval_date') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.approval_date ? new Date(glazeToView.approval_date).toLocaleDateString('th-TH') : '-'"></span>
                            </div>
                            
                            <hr class="my-3 border-gray-300 dark:border-gray-600">

                            <!-- Glaze Inside -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-indigo-600 dark:text-indigo-400">qr_code</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.inside_color_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.glaze_inside?.glaze_inside_code || '-'"></span>
                            </div>
                            
                            <!-- Inside Color -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-indigo-600 dark:text-indigo-400">Format_Color_Fill</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.inside_color') }}:
                                </label>
                                <template x-if="glazeToView?.glaze_inside?.colors?.length > 0">
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="(color, index) in glazeToView.glaze_inside.colors" :key="index">
                                            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                                <!-- Color Code -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_code || '-'"></span>
                                                <span class="text-gray-400 dark:text-gray-500">|</span>
                                                <!-- Color Name -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_name || '-'"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>                    
                                <template x-if="!glazeToView?.glaze_inside?.colors?.length">
                                    <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('content.no_color') }}</span>
                                </template>
                            </div>

                            <!-- Glaze Outside -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-pink-600 dark:text-pink-400">qr_code</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.outside_color_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.glaze_outer?.glaze_outer_code || '-'"></span>
                            </div>

                            <!-- Outside Color -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-pink-600 dark:text-pink-400">Format_Color_Fill</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.outside_color') }}:
                                </label>
                                <template x-if="glazeToView?.glaze_outer?.colors?.length > 0">
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="(color, index) in glazeToView.glaze_outer.colors" :key="index">
                                            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                                <!-- Color Code -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_code || '-'"></span>
                                                <span class="text-gray-400 dark:text-gray-500">|</span>
                                                <!-- Color Name -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_name || '-'"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>                    
                                <template x-if="!glazeToView?.glaze_outer?.colors?.length">
                                    <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('content.no_color') }}</span>
                                </template>
                            </div>

                            <hr class="my-3 border-gray-300 dark:border-gray-600">

                            <!-- Effect Code-->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">qr_code</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.effect_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.effect?.effect_code || '-'"></span>
                            </div>

                            <!-- Effect Name -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">auto_awesome</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.effect_name') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="glazeToView?.effect?.effect_name || '-'"></span>
                            </div>

                            <!-- Effect Color -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">Format_Color_Fill</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.effect_color') }}:
                                </label>
                                <template x-if="glazeToView?.effect?.colors?.length > 0">
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="(color, index) in glazeToView.effect.colors" :key="index">
                                            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 px-3 rounded-lg border border-gray-200 dark:border-gray-600">
                                                <!-- Color Code -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_code || '-'"></span>
                                                <span class="text-gray-400 dark:text-gray-500">|</span>
                                                <!-- Color Name -->
                                                <span class="text-sm text-gray-900 dark:text-gray-100" x-text="color.color_name || '-'"></span>
                                            </div>
                                        </template>
                                    </div>
                                </template>                    
                                <template x-if="!glazeToView?.effect?.colors?.length">
                                    <span class="text-gray-500 dark:text-gray-400 text-sm">{{ __('content.no_color') }}</span>
                                </template>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('components.Detail-modals.partials.footer', [
            'item' => 'glazeToView',
            'modalName' => 'GlazeDetailModal',
            'buttonColor' => 'purple'
        ])
    </div>

    @include('components.Detail-modals.partials.zoom-modal', [
        'item' => 'glazeToView',
        'itemCode' => 'glaze_code'
    ])
</div>
