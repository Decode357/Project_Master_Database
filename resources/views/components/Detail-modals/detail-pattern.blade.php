<!-- Modal Overlay -->
<div x-show="PatternDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="PatternDetailModal = false" style="display: none;"
    x-data="{ 
        zoomImage: false, 
        activeTab: 'info',
        currentImageIndex: 0,
        get currentImage() {
            return this.patternToView?.images && this.patternToView.images.length > 0 
                ? this.patternToView.images[this.currentImageIndex] 
                : null;
        }
    }">
    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-visible h-[90vh] flex flex-col">
        
        <!-- Header with Exclusive Badge -->
        <div class="bg-gradient-to-r text-white p-6 flex gap-5 rounded-t-2xl"
            :class="patternToView?.exclusive === true ? 'from-red-600 to-green-800 dark:from-red-700 dark:to-green-900' : 'from-green-600 to-green-800 dark:from-green-700 dark:to-green-900'">
            <div>
                <h2 class="text-2xl font-bold" x-text="patternToView?.pattern_code || '{{ __('content.details') }} {{ __('content.pattern') }}'"></h2>
                <p class="text-green-100 dark:text-green-200 text-sm mt-1" x-text="patternToView?.pattern_name || '{{ __('content.details') }} {{ __('content.pattern') }}'"></p>
            </div>
            <template x-if="patternToView?.exclusive === true">
                <div class="flex gap-2 bg-red-500 px-4 py-2 rounded-full shadow-md shadow-red-700/70 items-center">
                    <span class="text-3xl material-symbols-outlined text-white">
                        Loyalty
                    </span>
                    <span class="text-2xl font-semibold text-white">{{ __('content.exclusive') }}</span>                    
                </div>
            </template>                
            <button @click="PatternDetailModal = false"
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
                        'item' => 'patternToView',
                        'ringColor' => 'ring-green-500'
                    ])
                    
                    @include('components.Detail-modals.partials.status-section', [
                        'item' => 'patternToView',
                        'showProcess' => false
                    ])
                    
                    @include('components.Detail-modals.partials.update-info', [
                        'item' => 'patternToView'
                    ])
                </div>

                <!-- Right Column - Your existing tabs content -->
                <div class="lg:col-span-2 flex flex-col overflow-visible">
                    
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-6 flex-shrink-0">
                        <nav class="flex space-x-8">
                            <button @click="activeTab = 'info'"
                                :class="activeTab === 'info' ? 'border-green-500 text-green-600 dark:text-green-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">info</span>
                                {{ __('content.information') }}
                            </button>
                            <button @click="activeTab = 'customer_details'"
                                :class="activeTab === 'customer_details' ? 'border-green-500 text-green-600 dark:text-green-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">Patient_List</span>
                                {{ __('content.customer_details') }}
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content Container -->
                    <div class="flex-1 min-h-0">
                        <!-- Information Tab -->
                        <div x-show="activeTab === 'info'" class="h-full overflow-y-auto overflow-x-hidden flex flex-col gap-2 font-lg text-lg">
                            
                            <!-- Pattern Code -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">qr_code_2</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.pattern_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="patternToView?.pattern_code || '-'"></span>
                            </div>

                            <!-- Pattern Name -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">border_color</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.pattern_name') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="patternToView?.pattern_name || '-'"></span>
                            </div>

                            <!-- Exclusive -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-red-600 dark:text-red-400">
                                    Loyalty
                                </span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.exclusive') }}:
                                </label>
                                <template x-if="patternToView?.exclusive === true">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check</span>
                                </template>
                                <template x-if="patternToView?.exclusive === false">
                                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">close</span>
                                </template>
                            </div>

                            <!-- In Glaze -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">
                                    Vertical_Align_Center
                                </span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.in_glaze') }}:
                                </label>
                                <template x-if="patternToView?.in_glaze === true">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check</span>
                                </template>
                                <template x-if="patternToView?.in_glaze === false">
                                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">close</span>
                                </template>
                            </div>

                            <!-- On Glaze -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">
                                    Vertical_Align_Bottom
                                </span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.on_glaze') }}:
                                </label>
                                <template x-if="patternToView?.on_glaze === true">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check</span>
                                </template>
                                <template x-if="patternToView?.on_glaze === false">
                                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">close</span>
                                </template>
                            </div>

                            <!-- Under Glaze -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">
                                    Vertical_Align_Top
                                </span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.under_glaze') }}:
                                </label>
                                <template x-if="patternToView?.under_glaze === true">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check</span>
                                </template>
                                <template x-if="patternToView?.under_glaze === false">
                                    <span class="material-symbols-outlined text-gray-500 dark:text-gray-400">close</span>
                                </template>
                            </div>

                            <!-- Approval Date -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">Order_Approve</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.approval_date') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="patternToView?.approval_date ? new Date(patternToView.approval_date).toLocaleDateString('th-TH') : '-'"></span>
                            </div>

                            <hr class="mt-3 mb-2 border-gray-300 dark:border-gray-600">
                            
                            <!-- Customer -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">business</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.customer') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100 hoverScale hover:text-blue-600 hover:dark:text-blue-400" @click="activeTab = 'customer_details'" style="cursor: pointer;" 
                                    x-text="patternToView?.customer?.name || '-'">
                                </span>
                            </div>
                            
                            <!-- Designer -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-orange-600 dark:text-orange-400">palette</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.designer') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="patternToView?.designer?.designer_name || '-'"></span>
                            </div>
                            
                            <!-- Requestor -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-red-600 dark:text-red-400">person_raised_hand</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.requestor') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="patternToView?.requestor?.name || '-'"></span>
                            </div>
                        </div>
                        <!-- Customer Detail -->
                        <div x-show="activeTab === 'customer_details'" class="h-full overflow-y-auto overflow-x-visible flex flex-col gap-1 font-lg text-lg">
                            <!-- Code -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">Qr_Code_2</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="patternToView?.customer?.code || '-'"></span>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Name -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">Signature</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.name') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="patternToView?.customer?.name || '-'"></span>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Email -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">Mail</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.email') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="patternToView?.customer?.email || '-'"></span>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Phone -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">call</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.phone') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="patternToView?.customer?.phone || '-'"></span>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('components.Detail-modals.partials.footer', [
            'item' => 'patternToView',
            'modalName' => 'PatternDetailModal',
            'buttonColor' => 'green'
        ])
    </div>

    @include('components.Detail-modals.partials.zoom-modal', [
        'item' => 'patternToView',
        'itemCode' => 'pattern_code'
    ])
</div>
