<nav aria-label="..." class="float-right">


    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><a class="page-link" >上一页</a></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">上一页</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><a class="page-link" >{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link" href="#">{{ $page }} <span class="sr-only" ></span></a></li>
                    @elseif($page != 0)
                        <li class="page-item" ><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a></li>
        @else
            <li class="page-item disabled"><a class="page-link" >下一页</a></li>
        @endif
    </ul>


</nav>
