
@if ($paginator->hasPages())
    <nav class="pagination-nav" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
        <ul class="pagination-custom">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item-custom disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link-custom" aria-hidden="true">
                        <i class="fa fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item-custom">
                    <a class="page-link-custom" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <i class="fa fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item-custom disabled" aria-disabled="true"><span class="page-link-custom">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item-custom active" aria-current="page"><span class="page-link-custom">{{ $page }}</span></li>
                        @else
                            <li class="page-item-custom"><a class="page-link-custom" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item-custom">
                    <a class="page-link-custom" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item-custom disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link-custom" aria-hidden="true">
                        <i class="fa fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>

    <style>
    .pagination-nav {
        display: flex;
        justify-content: center;
    }

    .pagination-custom {
        display: flex;
        padding-left: 0;
        list-style: none;
        gap: 0.5rem;
        margin: 0;
    }

    .page-item-custom {
        display: block;
    }

    .page-link-custom {
        position: relative;
        display: block;
        padding: 0.75rem 1rem;
        margin: 0;
        line-height: 1.25;
        color: #1e293b;
        background-color: #ffffff;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        min-width: 45px;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .page-link-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(30, 41, 59, 0.1), transparent);
        transition: left 0.3s ease;
    }

    .page-link-custom:hover {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-color: #1e293b;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 41, 59, 0.3);
    }

    .page-link-custom:hover::before {
        left: 100%;
    }

    .page-item-custom.active .page-link-custom {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        border-color: #1e293b;
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(30, 41, 59, 0.4);
        transform: scale(1.05);
    }

    .page-item-custom.disabled .page-link-custom {
        background: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
        opacity: 0.6;
        transform: none;
        box-shadow: none;
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .page-link-custom {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            min-width: 40px;
        }
        
        .pagination-custom {
            gap: 0.25rem;
            flex-wrap: wrap;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .page-link-custom {
            padding: 0.4rem 0.6rem;
            font-size: 0.8rem;
            min-width: 35px;
        }
    }
    </style>
@endif