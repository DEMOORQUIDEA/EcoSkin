@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero-section" style="background: #4A90E2; padding: 3rem 0; position: relative; overflow: hidden;">
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>
    <div class="container position-relative" style="z-index: 2;">
        <div class="text-center text-white mb-4">
            <h1 class="display-4 fw-bold mb-3" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.1);">
                <i class="bi bi-shop"></i> Nuestro Catálogo
            </h1>
            <p class="lead mb-0">Descubre los mejores productos al mejor precio</p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container-fluid px-0" style="background: #F5F5F5; min-height: 100vh;">
    <div class="container py-5">
    <!-- Sección de Productos -->
    <div class="row mt-3">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="background: #FFFFFF; border-radius: 25px; overflow: hidden;">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap" style="background: #FFD700; border: none; padding: 1.5rem;">
                    <div class="d-flex align-items-center mb-2 mb-md-0">
                        <i class="bi bi-grid-3x3-gap-fill me-2" style="color: #4A90E2; font-size: 1.5rem;"></i>
                        <h5 class="mb-0" style="color: #4A90E2; font-weight: 700; font-size: 1.4rem;">Productos</h5>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="badge pulse" style="background: #4A90E2; padding: 0.6rem 1.2rem; border-radius: 25px; font-size: 0.95rem; box-shadow: 0 4px 10px rgba(74, 144, 226, 0.3);">
                            <i class="bi bi-box-seam me-1"></i>
                            {{ $products->total() }} {{ $search ? 'encontrado' . ($products->total() != 1 ? 's' : '') : 'disponibles' }}
                        </span>
                        <button class="btn btn-sm" style="background: #4A90E2; color: white; border-radius: 20px; padding: 0.4rem 1rem;" onclick="toggleViewMode()">
                            <i class="bi bi-grid-3x3-gap" id="viewIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="padding: 2.5rem; background: #F8F9FA;">
                    <!-- Barra de búsqueda mejorada -->
                    <div class="row mb-4">
                        <div class="col-lg-8 mx-auto">
                            <form method="GET" action="{{ route('welcome') }}" id="searchForm">
                                <div class="search-wrapper position-relative">
                                    <div class="input-group shadow" style="border-radius: 30px; overflow: hidden; border: 3px solid #4A90E2;">
                                        <span class="input-group-text border-0" style="background: #FFFFFF; padding: 0 1rem;">
                                            <i class="bi bi-search" style="color: #4A90E2; font-size: 1.3rem;"></i>
                                        </span>
                                        <input type="text"
                                               name="search"
                                               id="searchInput"
                                               class="form-control border-0"
                                               style="background: #FFFFFF; padding: 0.9rem; font-size: 1.05rem;"
                                               placeholder="¿Qué producto estás buscando?"
                                               value="{{ $search }}"
                                               autocomplete="off">
                                        @if($search)
                                        <a href="{{ route('welcome') }}" class="btn d-flex align-items-center" id="clearSearch" style="background: #FF6B6B; color: white; border: none; padding: 0 1.5rem; transition: all 0.3s;">
                                            <i class="bi bi-x-circle-fill" style="font-size: 1.2rem;"></i>
                                        </a>
                                        @else
                                        <button type="submit" class="btn d-flex align-items-center" style="background: #4A90E2; color: white; border: none; padding: 0 1.5rem; font-weight: 600;">
                                            <i class="bi bi-search me-1"></i> Buscar
                                        </button>
                                        @endif
                                    </div>
                                    <div id="searchLoader" class="spinner-border text-primary position-absolute" role="status" style="display: none; right: 15px; top: 50%; transform: translateY(-50%); width: 1.5rem; height: 1.5rem;">
                                        <span class="visually-hidden">Buscando...</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2 px-2">
                                    <small class="d-block" style="color: #4A90E2; font-weight: 500;">
                                        <i class="bi bi-lightbulb-fill me-1"></i> Presiona Enter para buscar
                                    </small>
                                    @if($search)
                                    <small class="badge" style="background: #4A90E2; color: white;">
                                        Filtrando por: <strong>"{{ $search }}"</strong>
                                    </small>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Filtros rápidos -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-2 justify-content-center">
                                <button class="btn btn-sm filter-chip active" data-filter="all" style="background: #4A90E2; color: white; border-radius: 20px; padding: 0.5rem 1.2rem; border: none; transition: all 0.3s;">
                                    <i class="bi bi-grid-fill me-1"></i> Todos
                                </button>
                                <button class="btn btn-sm filter-chip" data-filter="bebidas" style="background: white; color: #4A90E2; border: 2px solid #4A90E2; border-radius: 20px; padding: 0.5rem 1.2rem; transition: all 0.3s;">
                                    <i class="bi bi-cup-straw me-1"></i> Bebidas
                                </button>
                                <button class="btn btn-sm filter-chip" data-filter="snacks" style="background: white; color: #4A90E2; border: 2px solid #4A90E2; border-radius: 20px; padding: 0.5rem 1.2rem; transition: all 0.3s;">
                                    <i class="bi bi-bag-fill me-1"></i> Snacks
                                </button>
                                <button class="btn btn-sm filter-chip" data-filter="ofertas" style="background: white; color: #4A90E2; border: 2px solid #4A90E2; border-radius: 20px; padding: 0.5rem 1.2rem; transition: all 0.3s;">
                                    <i class="bi bi-tag-fill me-1"></i> Ofertas
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Productos Grid -->
                    <div id="productsContainer">
                    @if($products->count() > 0)
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4" id="productsGrid">
                            @foreach($products as $product)
                                <div class="col product-item" data-category="bebidas">
                                    <div class="card h-100 product-card shadow border-0 position-relative" style="border-radius: 20px; overflow: hidden; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); background: white;">
                                        <div class="product-badge" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                                            <span class="badge" style="background: #4A90E2; color: white; padding: 0.4rem 0.8rem; border-radius: 15px; font-weight: 600; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
                                                <i class="bi bi-star-fill me-1" style="color: #FFD700;"></i> Nuevo
                                            </span>
                                        </div>
                                        <div class="card-img-wrapper">
                                            @if($product->hasImage())
                                                <img src="{{ $product->image_url }}"
                                                     class="card-img-top product-img"
                                                     alt="{{ $product->name }}">
                                            @else
                                                <div class="card-img-top product-img-placeholder d-flex align-items-center justify-content-center bg-light">
                                                    <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title text-truncate" title="{{ $product->name }}">
                                                {{ $product->name }}
                                            </h5>
                                            <p class="card-text text-muted small flex-grow-1" style="height: 60px; overflow: hidden;">
                                                {{ Str::limit($product->description, 80) }}
                                            </p>
                                            <div class="mt-auto">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <p class="h5 mb-0" style="color: #4A90E2; font-weight: 700;">
                                                        ${{ number_format($product->price, 2) }}
                                                    </p>
                                                    <div class="rating">
                                                        <i class="bi bi-star-fill" style="color: #FFD700; font-size: 0.9rem;"></i>
                                                        <i class="bi bi-star-fill" style="color: #FFD700; font-size: 0.9rem;"></i>
                                                        <i class="bi bi-star-fill" style="color: #FFD700; font-size: 0.9rem;"></i>
                                                        <i class="bi bi-star-fill" style="color: #FFD700; font-size: 0.9rem;"></i>
                                                        <i class="bi bi-star-half" style="color: #FFD700; font-size: 0.9rem;"></i>
                                                    </div>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm flex-grow-1 btn-add-cart" style="background: #4A90E2; color: white; font-weight: 600; border: none; border-radius: 12px; padding: 0.6rem; transition: all 0.3s;" onclick="addToCart({{ $product->id }})">
                                                        <i class="bi bi-cart-plus-fill me-1"></i> Agregar
                                                    </button>
                                                    <button class="btn btn-sm btn-favorite" style="background: white; color: #4A90E2; border: 2px solid #4A90E2; border-radius: 12px; padding: 0.6rem 0.8rem; transition: all 0.3s;" onclick="toggleFavorite(this)">
                                                        <i class="bi bi-heart"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
                            <p class="mt-3 text-muted">No hay productos disponibles en este momento.</p>
                        </div>
                    @endif
                    </div>

                    <!-- Mensaje de no resultados -->
                    @if($products->count() == 0 && $search)
                    <div class="text-center py-5 empty-state">
                        <div class="mb-4">
                            <i class="bi bi-search" style="font-size: 5rem; color: #4A90E2; opacity: 0.3;"></i>
                        </div>
                        <h4 style="color: #4A90E2; font-weight: 600;">¡Ups! No encontramos nada</h4>
                        <p class="mt-3 mb-4" style="color: #666;">No se encontraron productos que coincidan con "<strong style="color: #4A90E2;">{{ $search }}</strong>".</p>
                        <a href="{{ route('welcome') }}" class="btn shadow" style="background: #4A90E2; color: white; border: none; border-radius: 25px; padding: 0.8rem 2rem; font-weight: 600; transition: all 0.3s;">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Ver todos los productos
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Paginación fuera del card -->
    @if($products->count() > 0)
    <div class="row mt-4" id="paginationContainer">
        <div class="col-12">
            {{ $products->links('vendor.pagination.custom') }}
        </div>
    </div>
    @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        background: #F5F5F5;
    }

    /* Hero animado */
    .hero-section {
        position: relative;
        overflow: hidden;
    }

    .floating-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .shape {
        position: absolute;
        background: rgba(255, 215, 0, 0.2);
        border-radius: 50%;
        animation: float 20s infinite ease-in-out;
    }

    .shape-1 {
        width: 300px;
        height: 300px;
        top: -150px;
        left: -150px;
        animation-delay: 0s;
    }

    .shape-2 {
        width: 200px;
        height: 200px;
        top: 50%;
        right: -100px;
        animation-delay: 5s;
    }

    .shape-3 {
        width: 150px;
        height: 150px;
        bottom: -75px;
        left: 50%;
        animation-delay: 10s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        33% { transform: translateY(-30px) rotate(120deg); }
        66% { transform: translateY(30px) rotate(240deg); }
    }

    /* Pulse animation para badge */
    @keyframes pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 4px 10px rgba(74, 144, 226, 0.3); }
        50% { transform: scale(1.05); box-shadow: 0 6px 20px rgba(74, 144, 226, 0.5); }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    /* Estilos para productos */
    .product-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        background: white;
        border: 2px solid transparent;
    }

    .product-card:hover {
        transform: translateY(-15px) scale(1.03);
        box-shadow: 0 20px 40px rgba(74, 144, 226, 0.3) !important;
        border-color: #4A90E2;
    }

    .product-card:hover .card-img-wrapper img {
        transform: scale(1.1) rotate(2deg);
    }

    .card-img-wrapper {
        position: relative;
        overflow: hidden;
        height: 200px;
    }

    .product-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .product-img-placeholder {
        width: 100%;
        height: 200px;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .card-text {
        font-size: 0.875rem;
        line-height: 1.4;
    }

    /* Estilos para el input de búsqueda */
    #searchInput {
        transition: all 0.3s ease;
    }

    #searchInput:focus {
        box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.2);
        outline: none;
    }

    #clearSearch:hover {
        background: #FF5252 !important;
        transform: scale(1.1) rotate(90deg);
    }

    .search-wrapper input:focus ~ #searchLoader {
        display: block !important;
    }

    /* Filter chips */
    .filter-chip {
        transition: all 0.3s ease;
    }

    .filter-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(74, 144, 226, 0.3);
    }

    .filter-chip.active {
        background: #4A90E2 !important;
        color: white !important;
        border-color: #4A90E2 !important;
    }

    /* Botones de producto */
    .btn-add-cart:hover {
        background: #3A7BC8 !important;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
    }

    .btn-favorite:hover {
        background: #4A90E2 !important;
        color: white !important;
        border-color: #4A90E2 !important;
        transform: scale(1.1) rotate(10deg);
    }

    .btn-favorite.active {
        background: #FF6B6B !important;
        border-color: #FF6B6B !important;
        color: white !important;
    }

    .btn-favorite.active i {
        color: white;
    }

    .btn-favorite.active i::before {
        content: "\f5a1"; /* heart-fill */
    }

    /* Animación de fade para productos */
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

    /* Scrollbar personalizada */
    ::-webkit-scrollbar {
        width: 12px;
    }

    ::-webkit-scrollbar-track {
        background: #F5F5F5;
    }

    ::-webkit-scrollbar-thumb {
        background: #4A90E2;
        border-radius: 10px;
        border: 3px solid #F5F5F5;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #FFD700;
    }

    /* Empty state animation */
    .empty-state {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    /* Efecto de onda al hacer clic */
    .ripple {
        position: relative;
        overflow: hidden;
    }

    .ripple::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        pointer-events: none;
        background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
        background-repeat: no-repeat;
        background-position: 50%;
        transform: scale(10, 10);
        opacity: 0;
        transition: transform .5s, opacity 1s;
    }

    .ripple:active::after {
        transform: scale(0, 0);
        opacity: .3;
        transition: 0s;
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

// Búsqueda en tiempo real con debounce (envío automático del formulario)
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    const searchLoader = document.getElementById('searchLoader');
    let searchTimeout;

    // Solo buscar al presionar Enter (eliminado auto-submit)
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchLoader.style.display = 'block';
            searchForm.submit();
        }
    });

    // Filter chips functionality
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

    // Añadir efecto ripple a botones
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.classList.add('ripple');
    });
});

// Función para agregar al carrito
function addToCart(productId) {
    const btn = event.target.closest('.btn-add-cart');
    const originalText = btn.innerHTML;

    btn.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Agregado';
    btn.style.background = '#4CAF50';

    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.style.background = '#4A90E2';
    }, 2000);

    // Aquí puedes agregar lógica para agregar al carrito
    console.log('Producto agregado:', productId);
}

// Función para favoritos
function toggleFavorite(btn) {
    btn.classList.toggle('active');
    const icon = btn.querySelector('i');

    if (btn.classList.contains('active')) {
        icon.classList.remove('bi-heart');
        icon.classList.add('bi-heart-fill');
    } else {
        icon.classList.remove('bi-heart-fill');
        icon.classList.add('bi-heart');
    }
}

// Función para cambiar vista
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

</script>
@endpush
