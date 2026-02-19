@extends('layouts.app')

@section('content')
<style>
    .dashboard-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 76px);
        padding: 3rem 0;
        margin: -1.5rem -0.75rem 0;
    }

    .welcome-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 2rem;
        border: none;
    }

    .welcome-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .welcome-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .welcome-icon i {
        font-size: 2rem;
        color: white;
    }

    .welcome-text h2 {
        margin: 0;
        color: #2d3748;
        font-weight: 700;
        font-size: 1.8rem;
    }

    .welcome-text p {
        margin: 0.5rem 0 0;
        color: #718096;
        font-size: 1rem;
    }

    /* Barra de Búsqueda */
    .search-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .search-wrapper {
        position: relative;
        max-width: 600px;
        margin: 0 auto;
    }

    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #667eea;
        font-size: 1.25rem;
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border: 2px solid #e0e6ed;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }

    .clear-search {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: none;
    }

    .clear-search.show {
        display: block;
    }

    .clear-search:hover {
        background: #c82333;
    }

    .search-help {
        text-align: center;
        margin-top: 0.75rem;
        font-size: 0.9rem;
        color: #718096;
    }

    .search-results {
        text-align: center;
        color: white;
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
        font-weight: 500;
    }

    .search-results strong {
        color: #ffd700;
    }

    .section-title {
        color: white;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 0.75rem;
        font-size: 1.8rem;
    }

    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        height: 100%;
        border: none;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .product-image {
        height: 220px;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.1);
    }

    .product-image .no-image {
        font-size: 4rem;
        color: rgba(0, 0, 0, 0.1);
    }

    .product-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.75rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-description {
        color: #718096;
        font-size: 0.95rem;
        margin-bottom: 1rem;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 60px;
        flex: 1;
    }

    .product-footer {
        margin-top: auto;
    }

    .product-price {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 1rem;
        border-top: 2px solid #f7fafc;
        margin-bottom: 1rem;
    }

    .price-tag {
        font-size: 1.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .price-label {
        font-size: 0.75rem;
        color: #a0aec0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Botón Agregar al Carrito */
    .btn-add-cart {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-weight: 600;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .btn-add-cart::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: translate(-50%, -50%);
        transition: width 0.6s, height 0.6s;
    }

    .btn-add-cart:active::before {
        width: 300px;
        height: 300px;
    }

    .btn-add-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        color: white;
    }

    .btn-add-cart:active {
        transform: translateY(0) scale(0.98);
    }

    .btn-add-cart i {
        font-size: 1.1rem;
        transition: transform 0.3s ease;
    }

    .btn-add-cart:hover i {
        transform: scale(1.2) rotate(10deg);
    }

    .btn-add-cart.added {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%) !important;
        box-shadow: 0 4px 15px rgba(72, 187, 120, 0.4) !important;
    }

    .btn-add-cart.added i {
        animation: cartBounce 0.6s ease;
    }

    @keyframes cartBounce {
        0%, 100% { transform: scale(1); }
        25% { transform: scale(1.3) rotate(-10deg); }
        50% { transform: scale(0.9) rotate(10deg); }
        75% { transform: scale(1.2) rotate(-5deg); }
    }

    .empty-state {
        background: white;
        border-radius: 15px;
        padding: 3rem 2rem;
        text-align: center;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .empty-state-icon {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-state-icon i {
        font-size: 3rem;
        color: white;
    }

    .empty-state h4 {
        color: #2d3748;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: #718096;
        margin: 0 0 1rem 0;
    }

    .btn-clear-search {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-clear-search:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.5rem;
        color: white;
    }

    .stat-icon.purple {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .stat-icon.pink {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .stat-icon.blue {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stat-content h3 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 700;
        color: #2d3748;
    }

    .stat-content p {
        margin: 0.25rem 0 0;
        font-size: 0.9rem;
        color: #718096;
    }

    /* PAGINACIÓN MODERNA Y ELEGANTE */
    .pagination {
        display: flex;
        gap: 0.75rem;
        padding: 3rem 0 2rem;
        margin: 0;
        list-style: none;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .pagination .page-item {
        list-style: none;
    }

    .pagination .page-link {
        min-width: 50px;
        height: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        border: none;
        background: white;
        color: #667eea;
        font-weight: 700;
        font-size: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        padding: 0.75rem 1.25rem;
        text-decoration: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .pagination .page-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 0;
    }

    .pagination .page-link span {
        position: relative;
        z-index: 1;
    }

    .pagination .page-link:hover {
        color: white;
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .pagination .page-link:hover::before {
        opacity: 1;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.5);
        transform: scale(1.1);
    }

    .pagination .page-item.active .page-link::before {
        opacity: 1;
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        background: rgba(255, 255, 255, 0.6);
        color: #a0aec0;
        box-shadow: none;
    }

    .pagination .page-item.disabled .page-link:hover {
        background: rgba(255, 255, 255, 0.6);
        color: #a0aec0;
        transform: none;
        box-shadow: none;
    }

    .pagination .page-item.disabled .page-link::before {
        display: none;
    }

    /* FORZAR OCULTACIÓN DE FLECHAS - MÚLTIPLES MÉTODOS */
    /* Método 1: Ocultar SVG directamente */
    .pagination svg,
    .pagination .page-link svg,
    .pagination .page-item svg,
    nav svg {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        width: 0 !important;
        height: 0 !important;
        position: absolute !important;
        left: -9999px !important;
    }

    /* Método 2: Ocultar aria-hidden spans */
    .pagination span[aria-hidden="true"],
    .pagination .page-link span[aria-hidden="true"] {
        display: none !important;
        visibility: hidden !important;
        font-size: 0 !important;
    }

    /* Método 3: Ocultar cualquier span dentro de Previous/Next */
    .pagination .page-item:first-child span,
    .pagination .page-item:last-child span {
        display: none !important;
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

    /* Ocultar cualquier contenido dentro de Previous/Next */
    .pagination .page-item:first-child .page-link > *,
    .pagination .page-item:last-child .page-link > *,
    .pagination .page-item:first-child .page-link span,
    .pagination .page-item:last-child .page-link span {
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
    .pagination .page-item:first-child .page-link::after {
        content: 'Anterior';
        font-weight: 700;
        font-size: 0.95rem;
        line-height: normal;
        display: inline-block;
        position: relative;
        z-index: 1;
    }

    .pagination .page-item:last-child .page-link::after {
        content: 'Siguiente';
        font-weight: 700;
        font-size: 0.95rem;
        line-height: normal;
        display: inline-block;
        position: relative;
        z-index: 1;
    }

    /* Estilo especial para los botones Previous/Next */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 0.75rem 1.5rem !important;
        min-width: 120px;
        border-radius: 25px;
        font-weight: 700;
    }

    /* Números de página (mantener visibles) */
    .pagination .page-item:not(:first-child):not(:last-child) .page-link {
        font-size: 1rem !important;
        line-height: normal !important;
        border-radius: 50%;
        min-width: 50px;
        height: 50px;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 2rem 0;
        }

        .welcome-header {
            flex-direction: column;
            text-align: center;
        }

        .welcome-icon {
            margin-right: 0;
            margin-bottom: 1rem;
        }

        .product-image {
            height: 180px;
        }

        .stats-container {
            grid-template-columns: 1fr;
        }

        .pagination {
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .pagination .page-link {
            min-width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }

        .pagination .page-item:first-child .page-link::after {
            content: '‹ Ant';
            font-size: 0.85rem !important;
        }

        .pagination .page-item:last-child .page-link::after {
            content: 'Sig ›';
            font-size: 0.85rem !important;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            min-width: 80px;
        }

        .pagination .page-item:not(:first-child):not(:last-child) .page-link {
            min-width: 40px;
            height: 40px;
        }
    }
</style>

<div class="dashboard-container">
    <div class="container">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <div class="welcome-header">
                <div class="welcome-icon">
                    <i class="bi bi-emoji-smile"></i>
                </div>
                <div class="welcome-text">
                    <h2>¡Hola, {{ Auth::user()->name }}! 👋</h2>
                    <p>Bienvenido a tu panel de control. Explora y agrega productos a tu carrito.</p>
                </div>
            </div>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <!-- Search Bar -->
        <div class="search-card">
            <form method="GET" action="{{ route('home') }}" id="searchForm">
                <div class="search-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text"
                           name="search"
                           id="searchInput"
                           class="search-input"
                           placeholder="Buscar productos por nombre, descripción o precio..."
                           value="{{ $search }}"
                           autocomplete="off">
                    <button type="button" class="clear-search {{ $search ? 'show' : '' }}" id="clearSearch">
                        <i class="bi bi-x-lg"></i> Limpiar
                    </button>
                </div>
                <div class="search-help">
                    <i class="bi bi-info-circle-fill"></i>
                    Escribe para buscar productos en tiempo real
                </div>
            </form>
        </div>

        <!-- Search Results -->
        @if($search)
            <div class="search-results">
                <i class="bi bi-filter-circle-fill me-2"></i>
                Resultados para "<strong>{{ $search }}</strong>": {{ $products->total() }} producto(s) encontrado(s)
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $totalProducts }}</h3>
                    <p>Productos Totales</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon pink">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-content">
                    <h3>${{ number_format($avgPrice, 2) }}</h3>
                    <p>Precio Promedio</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="stat-content">
                    <h3>{{ $products->total() }}</h3>
                    <p>{{ $search ? 'Encontrados' : 'Disponibles' }}</p>
                </div>
            </div>
        </div>

        <!-- Products Section -->
        <div class="section-title">
            <i class="bi bi-bag-check-fill"></i>
            <span>{{ $search ? 'Resultados de Búsqueda' : 'Catálogo de Productos' }}</span>
        </div>

        @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="product-card">
                            <div class="product-image">
                                @if($product->hasImage())
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                                @else
                                    <i class="bi bi-image no-image"></i>
                                @endif
                            </div>
                            <div class="product-body">
                                <h5 class="product-title">{{ $product->name }}</h5>
                                <p class="product-description">{{ $product->description }}</p>
                                <div class="product-footer">
                                    <div class="product-price">
                                        <div>
                                            <div class="price-label">Precio</div>
                                            <div class="price-tag">${{ number_format($product->price, 2) }}</div>
                                        </div>
                                    </div>
                                    <button class="btn btn-add-cart" id="addToCartBtn-{{ $product->id }}"
                                            onclick="addToCartWithFeedback(this, {{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->hasImage() ? $product->image_url : '' }}')">
                                        <i class="bi bi-cart-plus-fill"></i>
                                        <span>Agregar al Carrito</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-inbox"></i>
                </div>
                <h4>No se encontraron productos</h4>
                <p>No hay productos que coincidan con tu búsqueda "{{ $search }}"</p>
                <p class="text-muted">Intenta con otras palabras clave o explora el catálogo completo.</p>
                <a href="{{ route('home') }}" class="btn btn-clear-search">
                    <i class="bi bi-arrow-counterclockwise me-2"></i>Ver Todos los Productos
                </a>
            </div>
        @endif
    </div>
</div>

<script>
// FUNCIÓN GLOBAL PARA ELIMINAR FLECHAS
function forceRemoveArrows() {
    // Eliminar todos los SVG de la paginación
    document.querySelectorAll('.pagination svg').forEach(svg => {
        svg.remove();
        svg.style.display = 'none';
    });

    // Eliminar spans con aria-hidden
    document.querySelectorAll('.pagination span[aria-hidden="true"]').forEach(span => {
        span.remove();
    });

    // Limpiar Previous y Next
    const prevButton = document.querySelector('.pagination .page-item:first-child .page-link');
    const nextButton = document.querySelector('.pagination .page-item:last-child .page-link');

    if (prevButton) {
        prevButton.innerHTML = '';
        prevButton.textContent = 'Anterior';
    }

    if (nextButton) {
        nextButton.innerHTML = '';
        nextButton.textContent = 'Siguiente';
    }
}

// Ejecutar inmediatamente
forceRemoveArrows();

// Ejecutar múltiples veces
setTimeout(forceRemoveArrows, 50);
setTimeout(forceRemoveArrows, 100);
setTimeout(forceRemoveArrows, 200);
setTimeout(forceRemoveArrows, 500);
setTimeout(forceRemoveArrows, 1000);

document.addEventListener('DOMContentLoaded', function() {
    // Ejecutar al cargar el DOM
    forceRemoveArrows();
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    const clearButton = document.getElementById('clearSearch');
    let searchTimeout;

    // Búsqueda automática
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const value = this.value.trim();

            // Mostrar/ocultar botón de limpiar
            if (value.length > 0) {
                clearButton.classList.add('show');
            } else {
                clearButton.classList.remove('show');
            }

            // Búsqueda automática después de 500ms
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (value.length >= 3 || value.length === 0) {
                    searchForm.submit();
                }
            }, 500);
        });
    }

    // Limpiar búsqueda
    if (clearButton) {
        clearButton.addEventListener('click', function() {
            searchInput.value = '';
            clearButton.classList.remove('show');
            window.location.href = "{{ route('home') }}";
        });
    }

    // ELIMINAR FLECHAS DE PAGINACIÓN COMPLETAMENTE
    function cleanPagination() {
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

            // Eliminar spans que puedan contener flechas
            const spans = link.querySelectorAll('span');
            spans.forEach(span => {
                if (span.innerHTML.includes('<svg') || span.innerHTML.includes('aria-hidden')) {
                    span.remove();
                }
            });
        });
    }

    // Ejecutar múltiples veces para asegurar limpieza
    cleanPagination();
    setTimeout(cleanPagination, 100);
    setTimeout(cleanPagination, 300);
    setTimeout(cleanPagination, 500);
    setTimeout(cleanPagination, 1000);

    // Observer para detectar cambios en la paginación
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                cleanPagination();
            }
        });
    });

    // Observar cambios en el contenedor de paginación
    const paginationContainer = document.querySelector('.pagination');
    if (paginationContainer) {
        observer.observe(paginationContainer, {
            childList: true,
            subtree: true
        });
    }

    // Ejecutar limpieza cada vez que se hace clic en la paginación
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination')) {
            setTimeout(forceRemoveArrows, 100);
            setTimeout(forceRemoveArrows, 300);
        }
    });
});

// FUNCIÓN MEJORADA PARA AGREGAR AL CARRITO CON FEEDBACK VISUAL
function addToCartWithFeedback(button, productId, productName, productPrice, productImage) {
    // Guardar contenido original
    const originalContent = button.innerHTML;
    const originalClass = button.className;

    // Deshabilitar botón temporalmente
    button.disabled = true;

    // Cambiar a estado "agregando"
    button.innerHTML = '<i class="bi bi-arrow-repeat"></i><span>Agregando...</span>';
    button.style.opacity = '0.8';

    // Agregar al carrito
    const result = addToCart(productId, productName, productPrice, productImage);

    if (result !== false) {
        // Éxito - mostrar feedback positivo
        setTimeout(() => {
            button.className = originalClass + ' added';
            button.innerHTML = '<i class="bi bi-check-circle-fill"></i><span>¡Agregado!</span>';
            button.style.opacity = '1';

            // Crear efecto de partículas (opcional)
            createCartParticles(button);

            // Volver al estado original después de 2 segundos
            setTimeout(() => {
                button.innerHTML = originalContent;
                button.className = originalClass;
                button.disabled = false;
            }, 2000);
        }, 300);
    } else {
        // Error o no logueado
        button.innerHTML = originalContent;
        button.disabled = false;
        button.style.opacity = '1';
    }
}

// Función para crear efecto de partículas
function createCartParticles(button) {
    const rect = button.getBoundingClientRect();
    const colors = ['#667eea', '#764ba2', '#48bb78', '#38a169'];

    for (let i = 0; i < 6; i++) {
        const particle = document.createElement('div');
        particle.style.cssText = `
            position: fixed;
            width: 8px;
            height: 8px;
            background: ${colors[Math.floor(Math.random() * colors.length)]};
            border-radius: 50%;
            top: ${rect.top + rect.height / 2}px;
            left: ${rect.left + rect.width / 2}px;
            pointer-events: none;
            z-index: 9999;
            animation: particleFloat ${0.6 + Math.random() * 0.4}s ease-out forwards;
        `;

        const angle = (Math.PI * 2 * i) / 6;
        const distance = 50 + Math.random() * 30;
        const tx = Math.cos(angle) * distance;
        const ty = Math.sin(angle) * distance;

        particle.style.setProperty('--tx', tx + 'px');
        particle.style.setProperty('--ty', ty + 'px');

        document.body.appendChild(particle);

        setTimeout(() => particle.remove(), 1000);
    }

    // Agregar animación CSS si no existe
    if (!document.getElementById('particle-animation')) {
        const style = document.createElement('style');
        style.id = 'particle-animation';
        style.textContent = `
            @keyframes particleFloat {
                0% {
                    transform: translate(0, 0) scale(1);
                    opacity: 1;
                }
                100% {
                    transform: translate(var(--tx), var(--ty)) scale(0);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    }
}

// Ejecutar al cargar la ventana
window.addEventListener('load', function() {
    forceRemoveArrows();
    setTimeout(forceRemoveArrows, 100);
    setTimeout(forceRemoveArrows, 500);
});
</script>
@endsection
