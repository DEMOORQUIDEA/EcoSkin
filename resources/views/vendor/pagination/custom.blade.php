@if ($paginator->hasPages())
<nav aria-label="Paginación" class="pag-nav">

    {{-- Barra de info --}}
    <div class="pag-info">
        <span>
            Mostrando <b>{{ $paginator->firstItem() }}</b>&nbsp;–&nbsp;<b>{{ $paginator->lastItem() }}</b>
            de <b>{{ $paginator->total() }}</b> resultados
        </span>
    </div>

    {{-- Controles --}}
    <div class="pag-controls">

        {{-- Anterior --}}
        @if ($paginator->onFirstPage())
            <span class="pag-btn pag-nav-btn disabled" aria-disabled="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>
                <span class="pag-label">Anterior</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pag-btn pag-nav-btn" rel="prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>
                <span class="pag-label">Anterior</span>
            </a>
        @endif

        {{-- Números de página --}}
        <div class="pag-pages">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pag-btn pag-dots">…</span>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pag-btn pag-page active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pag-btn pag-page">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pag-btn pag-nav-btn" rel="next">
                <span class="pag-label">Siguiente</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>
            </a>
        @else
            <span class="pag-btn pag-nav-btn disabled" aria-disabled="true">
                <span class="pag-label">Siguiente</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>
            </span>
        @endif

    </div>
</nav>

<style>
/* ============================
   PAGINACIÓN PREMIUM
   ============================ */
.pag-nav {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 1rem 0.5rem;
    user-select: none;
}

/* Badge de información */
.pag-info {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    background: white;
    border: 1px solid rgba(162,165,141,0.35);
    border-radius: 50px;
    padding: 0.45rem 1.1rem;
    font-size: 0.82rem;
    color: var(--color-sage);
    font-weight: 500;
    letter-spacing: 0.01em;
}

.pag-info b {
    color: var(--color-forest);
    font-weight: 600;
}

/* Controles: fila completa */
.pag-controls {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    flex-wrap: wrap;
    justify-content: center;
}

/* Grupo de páginas numeradas */
.pag-pages {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    background: white;
    border: 1.5px solid rgba(162,165,141,0.25);
    border-radius: 50px;
    padding: 0.3rem 0.5rem;
    flex-wrap: wrap;
    justify-content: center;
}

/* Base para todos los "botones" */
.pag-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    transition: all 0.22s cubic-bezier(.4,0,.2,1);
    line-height: 1;
    white-space: nowrap;
}

/* Botones Anterior / Siguiente */
.pag-nav-btn {
    padding: 0.6rem 1.15rem;
    background: #ffffff;
    color: #4a5568;
    border: 2px solid #e0e6f0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}

.pag-nav-btn:not(.disabled):hover {
    background: var(--color-forest);
    color: var(--color-cream);
    border-color: transparent;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(88,98,74,0.3);
    text-decoration: none;
}

.pag-nav-btn.disabled {
    opacity: 0.45;
    cursor: not-allowed;
    color: #a0aec0;
    background: #f7fafc;
    border-color: #e2e8f0;
    box-shadow: none;
}

/* Números */
.pag-page {
    min-width: 38px;
    height: 38px;
    border-radius: 8px;
    color: #4a5568;
    background: transparent;
}

.pag-page:not(.active):hover {
    background: var(--color-sage);
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(162,165,141,0.35);
    text-decoration: none;
}

/* Página activa */
.pag-page.active {
    background: var(--color-charcoal);
    color: var(--color-cream);
    box-shadow: 0 4px 14px rgba(45,45,38,0.3);
    cursor: default;
    border-radius: 8px;
}

/* Puntos suspensivos */
.pag-dots {
    color: #a0aec0;
    background: transparent;
    cursor: default;
    min-width: 24px;
    font-size: 1rem;
    letter-spacing: 1px;
}

/* ============================
   RESPONSIVE
   ============================ */
@media (max-width: 640px) {
    .pag-label {
        display: none;
    }

    .pag-nav-btn {
        padding: 0.55rem 0.75rem;
    }

    .pag-pages {
        border-radius: 10px;
        padding: 0.25rem 0.35rem;
    }

    .pag-page {
        min-width: 34px;
        height: 34px;
        font-size: 0.8rem;
    }

    .pag-info {
        font-size: 0.78rem;
        padding: 0.4rem 0.9rem;
    }
}
</style>
@endif
