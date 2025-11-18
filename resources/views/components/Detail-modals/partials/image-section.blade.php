<!-- Image Section -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 flex-shrink-0">
    <div class="relative">
        <!-- Main Image Display -->
        <template x-if="{{ $item }}?.images?.length > 0">
            <div>
                <img :src="`{{ asset('storage') }}/${ {{ $item }}.images[currentImageIndex].file_path}`" 
                    :alt="{{ $item }}.images[currentImageIndex].file_name"
                    class="rounded-lg shadow-lg cursor-zoom-in mx-auto h-64 md:h-80 object-contain w-full"
                    @click="zoomImage = true">
                
                <!-- Image Navigation -->
                <div class="flex justify-between items-center mt-3">
                    <button @click="currentImageIndex = (currentImageIndex - 1 + {{ $item }}.images.length) % {{ $item }}.images.length"
                            class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                        <span class="material-symbols-outlined mt-1">arrow_back</span>
                    </button>
                    
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        <span x-text="currentImageIndex + 1"></span>/<span x-text="{{ $item }}.images.length"></span>
                    </span>
                    
                    <button @click="currentImageIndex = (currentImageIndex + 1) % {{ $item }}.images.length"
                            class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-full p-1 hover:bg-gray-300 dark:hover:bg-gray-500">
                        <span class="material-symbols-outlined mt-1">arrow_forward</span>
                    </button>
                </div>
                
                <!-- Thumbnails -->
                <div class="flex gap-1 px-2 py-2 overflow-x-auto pb-2">
                    <template x-for="(image, index) in {{ $item }}.images" :key="index">
                        <img :src="`{{ asset('storage') }}/${image.file_path}`" 
                            :alt="`Thumbnail ${index + 1}`"
                            class="h-12 w-12 object-cover rounded cursor-pointer"
                            :class="currentImageIndex === index ? 'ring-2 {{ $ringColor }}' : ''"
                            @click="currentImageIndex = index">
                    </template>
                </div>
            </div>
        </template>
        
        <template x-if="!{{ $item }}?.images?.length">
            <div class="bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center h-48">
                <div class="text-center text-gray-500 dark:text-gray-400">
                    <span class="material-symbols-outlined text-6xl mb-2 block">image</span>
                    <p>{{ __('content.no_images_available') }}</p>
                </div>
            </div>
        </template>
    </div>
</div>