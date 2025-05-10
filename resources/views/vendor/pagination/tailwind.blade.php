@if($paginator->hasPages())
    <section>
        <div class="research-report-pagination justify-content-start d-flex">
            <nav>
                <ul class="pagination customPagination">
                    @if($paginator->onFirstPage())
                        <li class="page-item disabled dissabled-arrow">
                              <span class="page-link" aria-hidden="true">
                                    <i class="fa-solid fa-chevron-right"></i>
                              </span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link prev" href="{{$paginator->previousPageUrl()}}" aria-label="@lang('site.PREVIOUS')">
                                  <span aria-hidden="true">
                                    <i class="fa-solid fa-chevron-right"></i>
                                  </span>
                            </a>
                        </li>
                    @endif

                        @foreach ($elements as $index => $element)
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage() - 3)
                                        <li class="page-item">
                                            <a class="page-link" href="{{$url}}">
                                                ...
                                            </a>
                                        </li>
                                    @elseif($page == $paginator->currentPage() + 3)
                                        <li class="page-item">
                                            <a class="page-link" href="{{$url}}">
                                                ...
                                            </a>
                                        </li>
                                    @endif
                                    @continue($page < $paginator->currentPage() - 2)
                                    @break($page > $paginator->currentPage() + 2)
                                    @if ($page == $paginator->currentPage())
                                        <li class="page-item active disabled">
                                            <span class="page-link">
                                                {{$page}}
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{$url}}">{{$page}}</a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <a class="page-link prev" href="{{$paginator->nextPageUrl()}}" aria-label="@lang('site.NEXT')">
                              <span aria-hidden="true">
                                <i class="fa-solid fa-chevron-left"></i>
                              </span>
                            </a>
                        </li>
                    @else
                        <li class="page-item dissabled-arrow">
                          <span class="page-link" aria-hidden="true">
                            <i class="fa-solid fa-chevron-left"></i>
                          </span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </section>
@endif