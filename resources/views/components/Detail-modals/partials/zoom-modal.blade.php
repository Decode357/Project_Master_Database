<!-- Zoom Image Modal -->
<div x-show="zoomImage" x-transition.opacity
    class="fixed inset-0 bg-black bg-opacity-95 flex items-center justify-center z-60"
    @click.self="zoomImage = false"
    x-init="$watch('zoomImage', value => document.body.style.overflow = value ? 'hidden' : '')">
    <div class="relative max-h-[95vh] max-w-[95vw]">
        <template x-if="{{ $item }}?.images?.length > 0">
            <div class="flex flex-col items-center">
                <!-- Zoomed Image -->
                <img :src="`{{ asset('storage') }}/${ {{ $item }}.images[currentImageIndex].file_path}`" 
                    :alt="{{ $item }}.images[currentImageIndex].file_name"
                    class="max-h-[85vh] max-w-[90vw] object-contain rounded-lg shadow-2xl">
                
                <!-- Image Info -->
                <div class="mt-4 text-white text-center">
                    <p class="text-lg font-semibold" x-text="{{ $item }}.{{ $itemCode }}"></p>
                    <p class="text-sm text-gray-300">
                        <span x-text="currentImageIndex + 1"></span> / <span x-text="{{ $item }}.images.length"></span>
                    </p>
                </div>
                
                <!-- Navigation Arrows -->
                <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 flex justify-between px-4">
                    <button @click="currentImageIndex = (currentImageIndex - 1 + {{ $item }}.images.length) % {{ $item }}.images.length"
                            class="text-gray-500 hoverScale">
                        <span class="material-symbols-outlined">Arrow_Back_iOS</span>
                    </button>
                    <button @click="currentImageIndex = (currentImageIndex + 1) % {{ $item }}.images.length"
                            class="text-gray-500 hoverScale">
                        <span class="material-symbols-outlined">Arrow_Forward_iOS</span>
                    </button>
                </div>
            </div>
        </template>
        
        <template x-if="!{{ $item }}?.images?.length">
            <div class="text-center text-white">
                <span class="material-symbols-outlined text-8xl mb-4 block">image</span>
                <p class="text-xl">{{ __('content.no_images_available') }}</p>
            </div>
        </template>
        
        <!-- Close button -->
        <button @click="zoomImage = false"
            class="absolute top-4 right-4 text-gray-500 hoverScale">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
</div>