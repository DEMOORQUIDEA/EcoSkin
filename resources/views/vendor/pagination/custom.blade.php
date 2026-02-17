@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="custom-pagination">
        <div class="pagination-container">
            {{-- Información de resultados --}}
            <div class="pagination-info">
                <span class="text-muted">
                    Mostrando
                    <strong>{{ $paginator->firstItem() }}</strong>
                    a
                    <strong>{{ $paginator->lastItem() }}</strong>
                    de
                    <strong>{{ $paginator->total() }}</strong>
                    resultados
                </span>
            </div>

            {{-- Enlaces de paginación --}}
            <div class="pagination-links">
                <ul class="pagination-list">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="pagination-item disabled">
                            <span class="pagination-link">Anterior</span>
                        </li>
                    @else
                        <li class="pagination-item">
                            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-link" rel="prev">Anterior</a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="pagination-item disabled">
                                <span class="pagination-link">{{ $element }}</span>
                            </li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="pagination-item active">
                                        <span class="pagination-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="pagination-item">
                                        <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="pagination-item">
                            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-link" rel="next">Siguiente</a>
                        </li>
                    @else
                        <li class="pagination-item disabled">
                            <span class="pagination-link">Siguiente</span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <style>
            .custom-pagination {
                width: 100%;
                padding: 20px 0;
            }

            .pagination-container {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .pagination-info {
                font-size: 14px;
                color: #6c757d;
            }

            .pagination-info strong {
                color: #495057;
                font-weight: 600;
            }

            .pagination-links {
                display: flex;
                justify-content: center;
            }

            .pagination-list {
                display: flex;
                list-style: none;
                padding: 0;
                margin: 0;
                gap: 5px;
                flex-wrap: wrap;
            }

            .pagination-item {
                display: inline-block;
            }

            .pagination-link {
                display: inline-block;
                padding: 8px 14px;
                font-size: 14px;
                font-weight: 500;
                line-height: 1.5;
                color: #007bff;
                text-decoration: none;
                background-color: #ffffff;
                border: 1px solid #dee2e6;
                border-radius: 4px;
                transition: all 0.2s ease;
                cursor: pointer;
                min-width: 40px;
                text-align: center;
            }

            .pagination-link:hover {
                color: #0056b3;
                background-color: #e9ecef;
                border-color: #dee2e6;
            }

            .pagination-item.active .pagination-link {
                color: #ffffff;
                background-color: #007bff;
                border-color: #007bff;
                cursor: default;
            }

            .pagination-item.disabled .pagination-link {
                color: #6c757d;
                background-color: #ffffff;
                border-color: #dee2e6;
                cursor: not-allowed;
                opacity: 0.6;
            }

            .pagination-item.disabled .pagination-link:hover {
                color: #6c757d;
                background-color: #ffffff;
                border-color: #dee2e6;
            }

            /* Responsive */
            @media (max-width: 576px) {
                .pagination-container {
                    gap: 10px;
                }

                .pagination-link {
                    padding: 6px 10px;
                    font-size: 13px;
                    min-width: 35px;
                }

                .pagination-info {
                    font-size: 12px;
                    text-align: center;
                }
            }
        </style>
    </nav>
@endif
