@extends('layouts.app')

@section('content')
<!-- Hero Banner Section -->
<div class="hero-banner" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative; overflow: hidden;">
    <div class="hero-content">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white">
                    <h1 class="display-4 fw-bold mb-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                        Encuentra los mejores productos
                    </h1>
                    <p class="lead mb-4">Miles de productos con las mejores ofertas y envío rápido</p>
                    <div class="d-flex gap-3">
                        <span class="badge bg-warning text-dark px-3 py-2">
                            <i class="bi bi-lightning-fill me-1"></i> Envío gratis
                        </span>
                        <span class="badge bg-success px-3 py-2">
                            <i class="bi bi-shield-check me-1"></i> Compra segura
                        </span>
                        <span class="badge bg-info px-3 py-2">
                            <i class="bi bi-award-fill me-1"></i> Calidad garantizada
                        </span>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-image">
                        <i class="bi bi-bag-check-fill" style="font-size: 15rem; color: rgba(255,255,255,0.2);"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wave-bottom"></div>
</div>

<!-- Search Bar Section -->
<div class="search-section bg-white shadow-sm sticky-top" style="top: 0; z-index: 1020;">
    <div class="container py-4">
        <form method="GET" action="{{ route('welcome') }}" id="searchForm">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="search-container position-relative">
                        <div class="input-group input-group-lg shadow-lg" style="border-radius: 50px; overflow: hidden;">
                            <span class="input-group-text bg-white border-0 ps-4">
                                <i class="bi bi-search" style="color: #667eea; font-size: 1.5rem;"></i>
                            </span>
                            <input type="text"
                                   name="search"
                                   id="searchInput"
                                   class="form-control border-0 px-3"
                                   style="font-size: 1.1rem;"
                                   placeholder="¿Qué estás buscando hoy?"
                                   value="{{ $search }}"
                                   autocomplete="off">
                            @if($search)
                            <a href="{{ route('welcome') }}" class="btn btn-link text-danger px-3" title="Limpiar búsqueda">
                                <i class="bi bi-x-circle-fill" style="font-size: 1.3rem;"></i>
                            </a>
                            @endif
                            <button type="submit" class="btn px-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 600;">
                                <i class="bi bi-search me-2"></i> Buscar
                            </button>
                        </div>
                        <div id="searchLoader" class="spinner-border text-primary position-absolute" role="status" style="display: none; right: 120px; top: 50%; transform: translateY(-50%); width: 1.5rem; height: 1.5rem; z-index: 100;">
                            <span class="visually-hidden">Buscando...</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2 px-3">
                        <small class="text-muted">
                            <i class="bi bi-info-circle-fill me-1"></i> <span id="searchHint">Búsqueda automática después de 3 caracteres</span>
                        </small>
                        @if($search)
                        <small class="badge" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <i class="bi bi-filter-circle-fill me-1"></i> "{{ $search }}"
                        </small>
                        @endif
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Main Content -->
<div class="main-content bg-light py-5">
    <div class="container">

        <!-- Stats Bar -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px; background: white;">
                    <div class="card-body py-3">
                        <div class="row align-items-center text-center">
                            <div class="col-md-3 border-end">
                                <div class="stat-item">
                                    <i class="bi bi-box-seam-fill text-primary" style="font-size: 2rem;"></i>
                                    <h4 class="mb-0 mt-2 fw-bold" id="productCounter">{{ $products->total() }}</h4>
                                    <small class="text-muted">{{ $search ? 'Encontrados' : 'Productos' }}</small>
                                </div>
                            </div>
                            <div class="col-md-3 border-end">
                                <div class="stat-item">
                                    <i class="bi bi-truck text-success" style="font-size: 2rem;"></i>
                                    <h4 class="mb-0 mt-2 fw-bold">Gratis</h4>
                                    <small class="text-muted">Envío rápido</small>
                                </div>
                            </div>
                            <div class="col-md-3 border-end">
                                <div class="stat-item">
                                    <i class="bi bi-shield-check text-info" style="font-size: 2rem;"></i>
                                    <h4 class="mb-0 mt-2 fw-bold">100%</h4>
                                    <small class="text-muted">Seguro</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-item">
                                    <i class="bi bi-star-fill text-warning" style="font-size: 2rem;"></i>
                                    <h4 class="mb-0 mt-2 fw-bold">4.8</h4>
                                    <small class="text-muted">Calificación</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter and Sort Bar -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-primary btn-sm filter-chip active" data-filter="all" style="border-radius: 20px;">
                            <i class="bi bi-grid-fill me-1"></i> Todos
                        </button>
                        <button class="btn btn-outline-primary btn-sm filter-chip" data-filter="bebidas" style="border-radius: 20px;">
                            <i class="bi bi-cup-straw me-1"></i> Bebidas
                        </button>
                        <button class="btn btn-outline-primary btn-sm filter-chip" data-filter="snacks" style="border-radius: 20px;">
                            <i class="bi bi-bag-fill me-1"></i> Snacks
                        </button>
                        <button class="btn btn-outline-primary btn-sm filter-chip" data-filter="ofertas" style="border-radius: 20px;">
                            <i class="bi bi-tag-fill me-1"></i> Ofertas
                        </button>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                        <small class="text-muted">Vista:</small>
                        <button class="btn btn-sm btn-outline-secondary" onclick="toggleViewMode()" title="Cambiar vista" style="border-radius: 10px;">
                            <i class="bi bi-grid-3x3-gap" id="viewIcon"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" id="scrollTopBtn" style="display: none; border-radius: 10px;" onclick="scrollToTop()" title="Volver arriba">
                            <i class="bi bi-arrow-up-circle-fill"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div id="productsContainer">
            @if($products->count() > 0)
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4" id="productsGrid">
                    @foreach($products as $product)
                        <div class="col product-item" data-category="bebidas">
                            <div class="card product-card h-100 border-0 shadow-sm" style="border-radius: 15px; transition: all 0.3s ease;">
                                <!-- Product Badge -->
                                <div class="product-badge-container" style="position: absolute; top: 10px; left: 10px; z-index: 10;">
                                    <span class="badge bg-danger">
                                        <i class="bi bi-fire me-1"></i> HOT
                                    </span>
                                </div>

                                <!-- Favorite Button -->
                                <button class="btn btn-sm btn-favorite position-absolute top-0 end-0 m-2" style="z-index: 10; background: white; border-radius: 50%; width: 40px; height: 40px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);" onclick="toggleFavorite(this)">
                                    <i class="bi bi-heart text-danger"></i>
                                </button>

                                <!-- Product Image -->
                                <div class="card-img-wrapper" style="position: relative; overflow: hidden; height: 250px; background: #f8f9fa;">
                                    @if($product->hasImage())
                                        <img src="{{ $product->image_url }}"
                                             class="card-img-top"
                                             alt="{{ $product->name }}"
                                             style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100">
                                            <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Info -->
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title text-dark fw-bold mb-2" style="min-height: 40px; font-size: 0.95rem;">
                                        {{ Str::limit($product->name, 50) }}
                                    </h6>
                                    <p class="card-text text-muted small mb-3" style="min-height: 60px; font-size: 0.85rem;">
                                        {{ Str::limit($product->description, 80) }}
                                    </p>

                                    <!-- Rating -->
                                    <div class="mb-2">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-half text-warning"></i>
                                        <small class="text-muted ms-1">(4.5)</small>
                                    </div>

                                    <!-- Price and Actions -->
                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <small class="text-muted text-decoration-line-through d-block">${{ number_format($product->price * 1.2, 2) }}</small>
                                                <h5 class="mb-0 text-success fw-bold">${{ number_format($product->price, 2) }}</h5>
                                            </div>
                                            <span class="badge bg-success">-20%</span>
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button class="btn btn-primary btn-add-cart"
                                                    style="border-radius: 10px; font-weight: 600;"
                                                    onclick="addToCartFromWelcome({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->hasImage() ? $product->image_url : '' }}')">
                                                <i class="bi bi-cart-plus-fill me-2"></i> Agregar al carrito
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-inbox" style="font-size: 6rem; color: #dee2e6;"></i>
                    </div>
                    <h4 class="text-muted mb-3">No hay productos disponibles</h4>
                    <p class="text-muted">Estamos trabajando para traerte los mejores productos. ¡Vuelve pronto!</p>
                </div>
            @endif
        </div>

        <!-- No Results Message -->
        <div id="noResultsMessage" class="text-center py-5" style="display: none;">
            <div class="mb-4">
                <i class="bi bi-search" style="font-size: 6rem; color: #dee2e6;"></i>
            </div>
            <h4 class="text-dark mb-3">No encontramos resultados</h4>
            <p class="text-muted mb-4">
                Intenta buscar con otras palabras clave o explora nuestras categorías
            </p>
            <button class="btn btn-primary" onclick="clearSearch()" style="border-radius: 25px; padding: 0.8rem 2rem;">
                <i class="bi bi-arrow-counterclockwise me-2"></i> Ver todos los productos
            </button>
        </div>

        <!-- Pagination -->
        @if($products->count() > 0 && $products->hasPages())
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

<!-- Trust Section -->
<div class="trust-section bg-white py-5 border-top">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 mb-4 mb-md-0">
                <i class="bi bi-shield-check text-primary" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Compra Segura</h5>
                <p class="text-muted small">Protegemos tus datos y transacciones</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <i class="bi bi-truck text-success" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Envío Gratis</h5>
                <p class="text-muted small">En compras mayores a $500</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <i class="bi bi-arrow-repeat text-info" style="font-size: 3rem;"></i>
                <h5 class="mt-3">30 días de devolución</h5>
                <p class="text-muted small">Si no estás satisfecho</p>
            </div>
            <div class="col-md-3">
                <i class="bi bi-headset text-warning" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Soporte 24/7</h5>
                <p class="text-muted small">Estamos aquí para ayudarte</p>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Hero Banner */
    .hero-banner {
        position: relative;
        min-height: 350px;
    }

    .wave-bottom {
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        overflow: hidden;
        line-height: 0;
    }

    .wave-bottom svg {
        position: relative;
        display: block;
        width: calc(100% + 1.3px);
        height: 60px;
    }

    /* Search Section */
    .search-section {
        position: sticky !important;
        top: 0 !important;
        z-index: 1020 !important;
        margin-top: 0 !important;
        padding-top: 1rem !important;
    }

    .search-container .form-control:focus {
        box-shadow: none;
    }

    .search-container .input-group:focus-within {
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2);
    }

    /* Product Cards */
    .product-card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15) !important;
    }

    .product-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .product-card .card-img-wrapper {
        overflow: hidden;
    }

    .btn-favorite:hover {
        transform: scale(1.1);
    }

    .btn-favorite.active i {
        color: #dc3545;
    }

    .btn-favorite.active i::before {
        content: "\f5a1";
    }

    /* Filter Chips */
    .filter-chip {
        transition: all 0.3s ease;
    }

    .filter-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .filter-chip.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
        border-color: transparent !important;
    }

    /* Add to Cart Button */
    .btn-add-cart {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .product-item {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    .product-item:nth-child(1) { animation-delay: 0.1s; }
    .product-item:nth-child(2) { animation-delay: 0.2s; }
    .product-item:nth-child(3) { animation-delay: 0.3s; }
    .product-item:nth-child(4) { animation-delay: 0.4s; }
    .product-item:nth-child(5) { animation-delay: 0.5s; }
    .product-item:nth-child(6) { animation-delay: 0.6s; }
    .product-item:nth-child(7) { animation-delay: 0.7s; }
    .product-item:nth-child(8) { animation-delay: 0.8s; }

    /* Scrollbar */
    ::-webkit-scrollbar {
        width: 12px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
    }

    /* PAGINACIÓN SIN FLECHAS - MEJORADA Y CORREGIDA */
    .pagination {
        display: flex;
        gap: 0.5rem;
        padding: 1rem 0;
        margin: 0;
        list-style: none;
        justify-content: center;
        align-items: center;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        min-width: 45px;
        height: 45px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        border: 2px solid #e0e6ed;
        background: white;
        color: #2d3748;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
        padding: 0.5rem 1rem;
        text-decoration: none;
        position: relative;
    }

    .pagination .page-link:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: #667eea;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.4;
        cursor: not-allowed;
        background: #f7fafc;
        color: #a0aec0;
        border-color: #e0e6ed;
    }

    .pagination .page-item.disabled .page-link:hover {
        background: #f7fafc;
        color: #a0aec0;
        transform: none;
        box-shadow: none;
    }

    /* OCULTAR COMPLETAMENTE TODAS LAS FLECHAS SVG */
    .pagination .page-link svg,
    .pagination .page-link svg *,
    .pagination svg,
    nav[role="navigation"] svg,
    nav svg {
        display: none !important;
        visibility: hidden !important;
        width: 0 !important;
        height: 0 !important;
        opacity: 0 !important;
    }

    /* Ocultar cualquier icono o span dentro de los botones Previous/Next */
    .pagination .page-item:first-child .page-link > *:not(::before),
    .pagination .page-item:last-child .page-link > *:not(::before) {
        display: none !important;
        visibility: hidden !important;
    }

    /* Limpiar contenido de Previous y Next */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 0 !important;
        line-height: 0 !important;
    }

    /* Agregar texto SOLO con ::before */
    .pagination .page-item:first-child .page-link::before {
        content: 'Anterior';
        font-weight: 600;
        font-size: 0.95rem;
        line-height: normal;
        display: inline-block;
    }

    .pagination .page-item:last-child .page-link::before {
        content: 'Siguiente';
        font-weight: 600;
        font-size: 0.95rem;
        line-height: normal;
        display: inline-block;
    }

    /* Estilo especial para los botones Previous/Next */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 0.5rem 1.25rem !important;
        min-width: auto;
    }

    /* Números de página (mantener visibles) */
    .pagination .page-item:not(:first-child):not(:last-child) .page-link {
        min-width: 45px;
        font-size: 1rem !important;
        line-height: normal !important;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-banner {
            min-height: 250px;
        }

        .search-section {
            position: sticky !important;
            top: 0 !important;
        }

        .pagination {
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .pagination .page-link {
            min-width: 40px;
            height: 40px;
            font-size: 0.9rem;
            padding: 0.4rem 0.75rem;
        }

        .pagination .page-item:first-child .page-link::before {
            content: 'Ant';
            font-size: 0.85rem !important;
        }

        .pagination .page-item:last-child .page-link::before {
            content: 'Sig';
            font-size: 0.85rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
@auth
    // Redireccionar a home en 2 segs
    setTimeout(function() {
        window.location.href = "{{ route('home') }}";
    }, 2000);
@endauth

// ELIMINAR FLECHAS DE PAGINACIÓN COMPLETAMENTE
document.addEventListener('DOMContentLoaded', function() {
    // Función para limpiar la paginación
    function cleanPagination() {
        // Obtener todos los elementos de paginación
        const paginationItems = document.querySelectorAll('.pagination .page-item');

        paginationItems.forEach((item, index) => {
            const link = item.querySelector('.page-link');
            if (!link) return;

            // Si es el primer elemento (Previous/Anterior)
            if (index === 0) {
                // Remover todo el contenido
                link.innerHTML = '';
                // Agregar solo el texto
                link.textContent = 'Anterior';
            }
            // Si es el último elemento (Next/Siguiente)
            else if (index === paginationItems.length - 1) {
                // Remover todo el contenido
                link.innerHTML = '';
                // Agregar solo el texto
                link.textContent = 'Siguiente';
            }

            // Eliminar cualquier SVG que pueda quedar
            const svgs = link.querySelectorAll('svg');
            svgs.forEach(svg => svg.remove());
        });
    }

    // Ejecutar al cargar
    cleanPagination();

    // Ejecutar después de un pequeño delay por si acaso
    setTimeout(cleanPagination, 100);
    setTimeout(cleanPagination, 500);
});

// Búsqueda automática
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    const searchHint = document.getElementById('searchHint');
    const searchLoader = document.getElementById('searchLoader');
    let searchTimeout;

    searchForm.addEventListener('submit', function(e) {
        const searchValue = searchInput.value.trim();

        if (searchValue.length > 0 && searchValue.length < 3) {
            e.preventDefault();
            searchHint.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i> Debes escribir al menos 3 caracteres';
            searchInput.focus();

            setTimeout(() => {
                searchHint.innerHTML = '<i class="bi bi-info-circle-fill me-1"></i> Búsqueda automática después de 3 caracteres';
            }, 3000);
            return false;
        }

        searchLoader.style.display = 'block';
        searchHint.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Buscando productos...';
    });

    searchInput.addEventListener('input', function() {
        const searchValue = this.value.trim();
        clearTimeout(searchTimeout);

        if (searchValue.length === 0) {
            searchHint.innerHTML = '<i class="bi bi-info-circle-fill me-1"></i> Búsqueda automática después de 3 caracteres';
            searchTimeout = setTimeout(() => {
                searchForm.submit();
            }, 500);
        } else if (searchValue.length < 3) {
            searchHint.innerHTML = '<i class="bi bi-info-circle-fill me-1"></i> Escribe ' + (3 - searchValue.length) + ' caracter(es) más';
        } else {
            searchHint.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Buscando...';
            searchLoader.style.display = 'block';

            searchTimeout = setTimeout(() => {
                searchForm.submit();
            }, 700);
        }
    });

    // Filter chips
    const filterChips = document.querySelectorAll('.filter-chip');
    filterChips.forEach(chip => {
        chip.addEventListener('click', function() {
            filterChips.forEach(c => c.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            const products = document.querySelectorAll('.product-item');

            products.forEach(product => {
                if (filter === 'all' || product.dataset.category === filter) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });
    });
});

// Funciones auxiliares
function clearSearch() {
    window.location.href = "{{ route('welcome') }}";
}

function addToCartFromWelcome(productId, productName, productPrice, productImage) {
    @guest
        // Si no está logueado, redirigir al login
        if (confirm('Debes iniciar sesión para agregar productos al carrito. ¿Deseas ir al login?')) {
            window.location.href = "{{ route('login') }}";
        }
        return false;
    @endguest

    const btn = event.target.closest('.btn-add-cart');
    const originalText = btn.innerHTML;

    // Agregar al carrito usando la función global
    if (typeof addToCart === 'function') {
        const result = addToCart(productId, productName, productPrice, productImage);
        if (!result) return; // Si falló (no logueado), salir
    }

    // Feedback visual en el botón
    btn.innerHTML = '<i class="bi bi-check-circle-fill me-2"></i> ¡Agregado!';
    btn.style.background = 'linear-gradient(135deg, #48bb78 0%, #38a169 100%)';
    btn.disabled = true;

    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        btn.disabled = false;
    }, 2000);
}

function toggleFavorite(btn) {
    btn.classList.toggle('active');
    const icon = btn.querySelector('i');

    if (btn.classList.contains('active')) {
        icon.classList.remove('bi-heart');
        icon.classList.add('bi-heart-fill');
        showToast('Agregado a favoritos', 'info');
    } else {
        icon.classList.remove('bi-heart-fill');
        icon.classList.add('bi-heart');
    }
}

function toggleViewMode() {
    const grid = document.getElementById('productsGrid');
    const icon = document.getElementById('viewIcon');

    if (grid.classList.contains('row-cols-lg-4')) {
        grid.classList.remove('row-cols-lg-4');
        grid.classList.add('row-cols-lg-3');
        icon.classList.remove('bi-grid-3x3-gap');
        icon.classList.add('bi-grid');
    } else {
        grid.classList.remove('row-cols-lg-3');
        grid.classList.add('row-cols-lg-4');
        icon.classList.remove('bi-grid');
        icon.classList.add('bi-grid-3x3-gap');
    }
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

window.addEventListener('scroll', function() {
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    if (window.pageYOffset > 300) {
        scrollTopBtn.style.display = 'block';
    } else {
        scrollTopBtn.style.display = 'none';
    }
});

// Toast notifications
function showToast(message, type = 'success') {
    const toastContainer = document.getElementById('toastContainer') || createToastContainer();
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    toast.style.cssText = `
        position: fixed;
        top: 80px;
        right: 20px;
        background: ${type === 'success' ? '#48bb78' : type === 'error' ? '#f56565' : '#667eea'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 9999;
        animation: slideInRight 0.3s ease, fadeOut 0.3s ease 2.7s;
        font-weight: 500;
    `;

    const icon = type === 'success' ? 'check-circle-fill' : type === 'error' ? 'x-circle-fill' : 'info-circle-fill';
    toast.innerHTML = `<i class="bi bi-${icon} me-2"></i>${message}`;

    toastContainer.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toastContainer';
    container.style.cssText = 'position: fixed; top: 0; right: 0; z-index: 9999;';
    document.body.appendChild(container);
    return container;
}

const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
@endpush
