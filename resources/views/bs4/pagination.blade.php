<?php
/**
 * @var Illuminate\Contracts\Pagination\LengthAwarePaginator $paginator
 */
// границы
$left=3;
$right=3;

$paginator->appends(request()->input());

// готовим ссылки
$minPage=$paginator->currentPage() - $left;
$maxPage=$paginator->currentPage() + $right;

// корректируем ссылки
if($minPage<0) $minPage = 1;
if($maxPage>$paginator->lastPage()) $maxPage = $paginator->lastPage();

$links = $paginator->getUrlRange($minPage, $maxPage);
?>
@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination">
            @if(!isset($links[1]))
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1)}}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">В начало</span>
                    </a>
                </li>
            @endif

            @foreach($links as $linkKey=>$link)
                @if($linkKey>0)
                    <li class="page-item @if($paginator->currentPage() == $linkKey) active @endif">
                        <a class="page-link" href="{{ $link }}">{{ $linkKey }}</a>
                    </li>
                @endif
            @endforeach

            @if(!isset($links[$paginator->lastPage()]))
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">В конец</span>
                    </a>
                </li>
            @endif
        </ul>
    </nav>
@endif