<!-- Modal Overlay -->
<div x-show="ShapeDetailModal" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    @click.self="ShapeDetailModal = false" style="display: none;"
    x-data="{ 
        zoomImage: false, 
        activeTab: 'info',
        currentImageIndex: 0,
        get currentImage() {
            return this.shapeToView?.images && this.shapeToView.images.length > 0 
                ? this.shapeToView.images[this.currentImageIndex] 
                : null;
        }
    }">
    <!-- Modal Content -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-6xl mx-4 relative overflow-visible h-[90vh] flex flex-col">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 dark:from-blue-700 dark:to-blue-900 text-white p-6 flex justify-between items-center flex-shrink-0 rounded-t-2xl">
            <div>
                <h2 class="text-2xl font-bold" x-text="shapeToView?.item_code || '{{ __('content.details') }} {{ __('content.shape') }}'"></h2>
                <p class="text-blue-100 dark:text-blue-200 text-sm mt-1"
                    x-text="[
                        shapeToView?.item_description_thai,
                        shapeToView?.item_description_eng
                    ].filter(Boolean).join(' | ') || '{{ __('content.details') }} {{ __('content.shape') }}'">
                </p>
            </div>
            <button @click="ShapeDetailModal = false"
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
                        'item' => 'shapeToView',
                        'ringColor' => 'ring-blue-500'
                    ])
                    
                    @include('components.Detail-modals.partials.status-section', [
                        'item' => 'shapeToView',
                        'showProcess' => true
                    ])
                    
                    @include('components.Detail-modals.partials.update-info', [
                        'item' => 'shapeToView'
                    ])
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-2 flex flex-col overflow-visible">
                    
                    <!-- Tab Navigation -->
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-6 flex-shrink-0">
                        <nav class="flex space-x-8">
                            <button @click="activeTab = 'info'"
                                :class="activeTab === 'info' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">info</span>
                                {{ __('content.information') }}
                            </button>
                            <button @click="activeTab = 'specification'"
                                :class="activeTab === 'specification' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
                                class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm mr-1">straighten</span>
                                {{ __('content.specification') }}
                            </button>
                            <button @click="activeTab = 'customer_details'"
                                :class="activeTab === 'customer_details' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'"
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
                            
                            <!-- Item Code -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">qr_code_2</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.shape_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.item_code || '-'"></span>
                            </div>
                            
                            <!-- Description (TH) -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">translate</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.description_th') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100 " x-text="shapeToView?.item_description_thai || '-'"></span>
                            </div>
                            
                            <!-- Description (EN) -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">language</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.description_en') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.item_description_eng || '-'"></span>
                            </div>
                            
                            <!-- Collection Code -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-pink-600 dark:text-pink-400">qr_code</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.collection_code') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.shape_collection?.collection_code || '-'"></span>
                            </div>
                            
                            <!-- Collection Name -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-pink-600 dark:text-pink-400">folder_special</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.collection_name') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.shape_collection?.collection_name || '-'"></span>
                            </div>
                            
                            <!-- Type -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-indigo-600 dark:text-indigo-400">category</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.type') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.shape_type?.name || '-'"></span>
                            </div>
                            
                            <!-- Group -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-teal-600 dark:text-teal-400">workspaces</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.group') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.item_group?.item_group_name || '-'"></span>
                            </div>

                            <!-- Approval Date -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">Order_Approve</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.approval_date') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.approval_date ? new Date(shapeToView.approval_date).toLocaleDateString('th-TH') : '-'"></span>
                            </div>

                            <hr class="mt-3 mb-2 border-gray-300 dark:border-gray-600">
                            
                            <!-- Customer -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">business</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.customer') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100 hoverScale hover:text-blue-600 hover:dark:text-blue-400" @click="activeTab = 'customer_details'" style="cursor: pointer;" 
                                    x-text="shapeToView?.customer?.name || '-'">
                                </span>
                            </div>
                            
                            <!-- Designer -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-orange-600 dark:text-orange-400">palette</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.designer') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.designer?.designer_name || '-'"></span>
                            </div>
                            
                            <!-- Requestor -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-red-600 dark:text-red-400">person_raised_hand</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.requestor') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.requestor?.name || '-'"></span>
                            </div>
                        </div>

                        <!-- Specification Tab -->
                        <div x-show="activeTab === 'specification'" class="h-full overflow-y-auto overflow-x-visible">
                            <div class="grid grid-cols-2 lg:grid-cols-2 gap-6">
                                
                                <!-- Left Side - Specification Data -->
                                <div class="flex flex-col gap-1 font-lg text-lg">
                                    <!-- Volume -->
                                    <div class="flex flex-col items-start">
                                        <div class="flex flex-row gap-1 items-center">
                                            <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">water_drop</span>
                                            <label class="text-gray-700 dark:text-gray-300">
                                                {{ __('content.volume') }}:
                                            </label>
                                            <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.volume || '-'"></span>
                                        </div>
                                        <label class="text-gray-400 dark:text-gray-500 text-sm ml-6">
                                            {{ __('content.cc_full') }}
                                        </label>
                                    </div>          
                                    <hr class="border-gray-300 dark:border-gray-600">
                                    
                                    <!-- Weight -->
                                    <div class="flex flex-col items-start">
                                        <div class="flex flex-row gap-1 items-center">
                                            <span class="material-symbols-outlined text-base text-purple-600 dark:text-purple-400">scale</span>
                                            <label class="text-gray-700 dark:text-gray-300">
                                                {{ __('content.weight') }}:
                                            </label>
                                            <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.weight || '-'"></span>
                                        </div>
                                        <label class="text-gray-400 dark:text-gray-500 text-sm ml-6">
                                            {{ __('content.g_full') }}
                                        </label>
                                    </div>
                                    <hr class="border-gray-300 dark:border-gray-600">
                                    
                                    <!-- Long Diameter -->
                                    <div class="flex flex-col items-start">
                                        <div class="flex flex-row gap-1 items-center">
                                            <span class="material-symbols-outlined text-base text-green-600 dark:text-green-400">straighten</span>
                                            <label class="text-gray-700 dark:text-gray-300">
                                                {{ __('content.long_diameter') }}:
                                            </label>
                                            <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.long_diameter || '-'"></span>
                                        </div>
                                        <label class="text-gray-400 dark:text-gray-500 text-sm ml-6">
                                            {{ __('content.mm_full') }}
                                        </label>
                                    </div>
                                    <hr class="border-gray-300 dark:border-gray-600">
                                    
                                    <!-- Short Diameter -->
                                    <div class="flex flex-col items-start">
                                        <div class="flex flex-row gap-1 items-center">
                                            <span class="material-symbols-outlined text-base text-orange-600 dark:text-orange-400">width</span>
                                            <label class="text-gray-700 dark:text-gray-300">
                                                {{ __('content.short_diameter') }}:
                                            </label>
                                            <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.short_diameter || '-'"></span>
                                        </div>
                                        <label class="text-gray-400 dark:text-gray-500 text-sm ml-6">
                                            {{ __('content.mm_full') }}
                                        </label>
                                    </div>
                                    <hr class="border-gray-300 dark:border-gray-600">
                                    
                                    <!-- Height Long -->
                                    <div class="flex flex-col items-start">
                                        <div class="flex flex-row gap-1 items-center">
                                            <span class="material-symbols-outlined text-base text-red-600 dark:text-red-400">height</span>
                                            <label class="text-gray-700 dark:text-gray-300">
                                                {{ __('content.height_long') }}:
                                            </label>
                                            <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.height_long || '-'"></span>
                                        </div>
                                        <label class="text-gray-400 dark:text-gray-500 text-sm ml-6">
                                            {{ __('content.mm_full') }}
                                        </label>
                                    </div>
                                    <hr class="border-gray-300 dark:border-gray-600">
                                    
                                    <!-- Height Short -->
                                    <div class="flex flex-col items-start">
                                        <div class="flex flex-row gap-1 items-center">
                                            <span class="material-symbols-outlined text-base text-pink-600 dark:text-pink-400">expand</span>
                                            <label class="text-gray-700 dark:text-gray-300">
                                                {{ __('content.height_short') }}:
                                            </label>
                                            <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.height_short || '-'"></span>
                                        </div>
                                        <label class="text-gray-400 dark:text-gray-500 text-sm ml-6">
                                            {{ __('content.mm_full') }}
                                        </label>
                                    </div>
                                    <hr class="border-gray-300 dark:border-gray-600">
                                    
                                    <!-- Body -->
                                    <div class="flex flex-col items-start">
                                        <div class="flex flex-row gap-1 items-center">
                                            <span class="material-symbols-outlined text-base text-teal-600 dark:text-teal-400">width_full</span>
                                            <label class="text-gray-700 dark:text-gray-300">
                                                {{ __('content.body') }}:
                                            </label>
                                            <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.body || '-'"></span>
                                        </div>
                                        <label class="text-gray-400 dark:text-gray-500 text-sm ml-6">
                                            {{ __('content.mm_full') }}
                                        </label>
                                    </div>
                                    <hr class="border-gray-300 dark:border-gray-600">
                                </div>
                                
                                <!-- Right Side - Specification Image -->
                                <div class="flex items-center justify-center">
                                    <div class="w-full h-full flex items-center justify-center">
                                        <template x-if="shapeToView?.item_group?.item_group_name">
                                            <img :src="`{{ asset('images') }}/${shapeToView.item_group.item_group_name}.jpg`"
                                                alt="Specification Diagram" 
                                                class="max-w-full max-h-full object-contain rounded"
                                                onerror="this.style.display='none'; this.parentElement.innerHTML='<div class=\'text-center text-gray-500 dark:text-gray-400\'><span class=\'material-symbols-outlined text-6xl mb-2 block\'>image</span><p>{{ __('content.no_images_available') }}</p></div>'">
                                        </template>
                                        <template x-if="!shapeToView?.item_group?.item_group_name">
                                            <div class="text-center text-gray-500 dark:text-gray-400">
                                                <span class="material-symbols-outlined text-6xl mb-2 block">image</span>
                                                <p>{{ __('content.no_images_available') }}</p>
                                            </div>
                                        </template>
                                    </div>
                                </div>                 
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
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.customer?.code || '-'"></span>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Name -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">Signature</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.name') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.customer?.name || '-'"></span>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Email -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">Mail</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.email') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.customer?.email || '-'"></span>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                            <!-- Phone -->
                            <div class="flex flex-row gap-2 items-center">
                                <span class="material-symbols-outlined text-base text-blue-600 dark:text-blue-400">call</span>
                                <label class="text-gray-700 dark:text-gray-300">
                                    {{ __('content.phone') }}:
                                </label>
                                <span class="text-gray-900 dark:text-gray-100" x-text="shapeToView?.customer?.phone || '-'"></span>
                            </div>
                            <hr class=" border-gray-300 dark:border-gray-600">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('components.Detail-modals.partials.footer', [
            'item' => 'shapeToView',
            'modalName' => 'ShapeDetailModal',
            'buttonColor' => 'blue'
        ])
    </div>

    @include('components.Detail-modals.partials.zoom-modal', [
        'item' => 'shapeToView',
        'itemCode' => 'item_code'
    ])
</div>