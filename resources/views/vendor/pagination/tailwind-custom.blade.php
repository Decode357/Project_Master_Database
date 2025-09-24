@if ($paginator->hasPages())
    <div class="flex flex-col md:flex-row items-center justify-between mt-4">
        {{-- Info ข้อความ: Showing x to y of z results --}}
        <div class="text-sm text-gray-500 mb-2 md:mb-0 mr-12">
            Showing 
            <span class="font-medium">{{ $paginator->firstItem() }}</span> to 
            <span class="font-medium">{{ $paginator->lastItem() }}</span> of 
            <span class="font-medium">{{ $paginator->total() }}</span> results
        </div>

        {{-- Pagination Buttons --}}
        <nav role="navigation" aria-label="Pagination Navigation" class="flex space-x-1 mr-4">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="pl-2 py-1 text-gray-400 bg-gray-200 rounded material-symbols-outlined">
                    Arrow_Back_iOS
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pl-2 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 material-symbols-outlined">
                    Arrow_Back_iOS
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-1 bg-gray-100 rounded">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1 bg-blue-500 text-white rounded">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-3 py-1 bg-gray-200 rounded hover:bg-blue-400">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pl-1 pr-1 py-1 text-white bg-blue-600 rounded hover:bg-blue-700 material-symbols-outlined">
                    Arrow_Forward_iOS
                </a>
            @else
                <span class="pl-1 pr-1 py-1 text-gray-400 bg-gray-200 rounded material-symbols-outlined">
                    Arrow_Forward_iOS
                </span>
            @endif
        </nav>
    </div>
@endif
