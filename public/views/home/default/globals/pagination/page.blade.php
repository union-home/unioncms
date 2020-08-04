<div class="pagination-group d-flex justify-content-center mt-3">
    <ul class="list-inline">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="list-inline-item"><a class="" ><i class="fa fa-angle-left"></i></a></li>
        @else
            <li class="list-inline-item"><a class="" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa fa-angle-left"></i></a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="list-inline-item"><a class="" >{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="list-inline-item"><a class="active" href="javascript:;">{{ $page }}</a></li>
                    @elseif($page != 0)
                        <li class="list-inline-item" ><a class="" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="list-inline-item"><a class="" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa fa-angle-right"></i></a></li>
        @else
            <li class="list-inline-item"><a class="" ><i class="fa fa-angle-right"></i></a></li>
        @endif

    </ul>
</div>

