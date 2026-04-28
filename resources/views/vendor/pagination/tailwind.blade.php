<nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center my-4">
    <ul class="inline-flex items-center gap-1 -space-x-px">
        {{-- Previous Button --}}
        @if ($paginator->onFirstPage())
            <li><span class="btn btn-sm btn-disabled">«</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm !bg-indigo-500 hover:!bg-indigo-600 text-white border-none">«</a></li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li><span class="btn btn-sm btn-disabled">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><span class="btn btn-sm !bg-indigo-500 text-white border-none font-bold" aria-current="page">{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}" class="btn btn-sm !bg-white border-indigo-300 text-indigo-600 hover:!bg-indigo-50 border">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Button --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm !bg-indigo-500 hover:!bg-indigo-600 text-white border-none">»</a></li>
        @else
            <li><span class="btn btn-sm btn-disabled">»</span></li>
        @endif
    </ul>
</nav>