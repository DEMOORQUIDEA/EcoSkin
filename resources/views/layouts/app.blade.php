<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Jesus\'s page') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">
    @stack('styles')

    <style>
        /* ====================================================
           PALETA Orquidea Clara y Coherente
           Colores claros, detalles morado suave y texto SIEMPRE NEGRO
        ==================================================== */
        :root {
            --color-cream: #FFF0F5;      /* Fondo principal casi blanco, tono lavanda claro */
            --color-surface: #E6C8E6;     /* Barra principal mora/rosa claro (como en la imagen referencial) */
            --color-tan: #000000;        /* Detalles, íconos o acentos en negro */
            --color-sage: #F3E5F5;       /* Fondo secundario claro */
            --color-forest: #000000;     /* Botones negros por defecto para máximo contraste */
            --color-charcoal: #000000;   /* TEXTO 100% NEGRO PARA LEGIBILIDAD EXTREMA */
            --color-border: #D1B3D1;     /* Bordes algo contrastados */
        }

        /* Estilos generales */
        body {
            font-family: 'Jost', sans-serif;
            background: var(--color-cream);
            color: var(--color-charcoal);
        }

        h1, h2, h3, h4, h5, h6, .brand-text, .nav-link, 
        p, th, td, label, span:not(.badge), strong, small, li, div:not(.navbar-toggler-icon) {
            color: #000000 !important;
        }

        h1, h2, h3, h4, h5, h6, .brand-text {
            font-family: 'Cormorant Garamond', serif;
        }

        .card, .table {
            background-color: var(--color-surface);
            border: 1px solid var(--color-border);
        }
        
        .form-control, .form-select, input, select, textarea {
            background-color: #FFFFFF !important;
            color: #000000 !important;
            border: 1px solid var(--color-border) !important;
        }

        .btn-primary, .eco-card__btn-cart, .eco-search__btn, .eco-btn, .btn {
            background-color: #000000 !important;
            border: 1px solid #000000 !important;
            color: #FFFFFF !important;
            border-radius: 50px !important;
            font-weight: 600 !important;
            padding: 0.6rem 1.7rem !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            letter-spacing: 0.05em;
        }
        .btn-primary:hover, .eco-card__btn-cart:hover, .eco-search__btn:hover, .eco-btn:hover, .btn:hover {
            background-color: #333333 !important;
            color: #FFFFFF !important;
            transform: translateY(-2px);
        }

        /* Navbar Estilo Tradicional */
        .navbar-custom {
            background-color: var(--color-surface);
            border-bottom: 2px solid var(--color-border);
            padding: 0.8rem 0;
            z-index: 1050;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 700;
            letter-spacing: 0.1em;
            color: #000000 !important;
        }
            font-weight: 700;
            font-size: 1.4rem !important;
            letter-spacing: 0.15em;
            color: #000000 !important;
            text-transform: uppercase;
        }

        .navbar-brand:hover {
            opacity: 0.8;
            transform: scale(1.02);
        }

        .navbar-nav .nav-link {
            color: #000000 !important;
            font-weight: 500;
            letter-spacing: 0.04em;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-size: 0.92rem;
            margin: 0 0.4rem;
        }

        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
            color: #333333 !important;
            background: rgba(0,0,0,0.05);
            border-radius: 4px;
        }

        /* Carrito de compras */
        #cartIcon {
            position: relative;
            padding: 0.5rem 0.75rem !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #cartIcon:hover {
            background: rgba(186, 155, 114, 0.15);
            transform: scale(1.05);
        }

        #cartCount {
            font-size: 0.65rem !important;
            padding: 0.25rem 0.4rem;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            background: var(--color-tan) !important;
            border: none;
            box-shadow: 0 2px 6px rgba(0,0,0,0.25);
            animation: cartBounce 0.5s ease;
        }

        @keyframes cartBounce {
            0%, 100% { transform: translate(-50%, 0) scale(1); }
            50% { transform: translate(-50%, -5px) scale(1.1); }
        }

        /* Modal del carrito */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(45, 45, 38, 0.2);
        }

        .list-group-item {
            transition: all 0.3s ease;
            border-color: #e8ebe2;
        }

        .list-group-item:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(88, 98, 74, 0.1);
        }

        /* User Dropdown */
        .user-dropdown {
            background: rgba(230, 234, 221, 0.12);
            border-radius: 8px;
            padding: 0.25rem 0.75rem;
            transition: all 0.3s ease;
            border: 1.5px solid rgba(186, 155, 114, 0.3);
        }

        .user-dropdown:hover {
            background: rgba(186, 155, 114, 0.15);
        }

        .navbar-nav .nav-link.dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-menu {
            border-radius: 10px;
            border: 1px solid rgba(162, 165, 141, 0.2);
            box-shadow: 0 12px 40px rgba(45, 45, 38, 0.12);
            padding: 0.5rem;
            margin-top: 0.5rem;
            min-width: 200px;
            background: #fff;
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 0.7rem 1rem;
            font-weight: 400;
            color: var(--color-charcoal);
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
        }

        .dropdown-item i {
            font-size: 1rem;
            width: 18px;
            color: var(--color-sage);
        }

        .dropdown-item:hover {
            background: var(--color-cream);
            color: var(--color-forest);
            transform: translateX(3px);
        }

        .dropdown-item:hover i {
            color: var(--color-tan);
        }

        /* Main content */
        main {
            min-height: calc(100vh - 76px);
        }

        /* Footer Minimalista */
        footer {
            background: var(--color-surface);
            border-top: 1px solid var(--color-border);
            color: var(--color-charcoal);
            padding: 1.75rem 0;
            margin-top: auto;
        }

        footer p {
            margin: 0;
            opacity: 0.85;
            font-size: 0.9rem;
            letter-spacing: 0.02em;
        }

        footer a {
            color: var(--color-tan);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        footer a:hover {
            color: var(--color-cream);
        }

        /* Scrollbar personalizado */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--color-cream);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--color-sage);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--color-forest);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.3rem;
            }

            .user-dropdown {
        .logo-ec-container {
            width: 32px;
            height: 32px;
            border: 1px solid var(--color-forest);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
            margin-right: 0.8rem;
        }

        .logo-ec {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--color-tan);
            letter-spacing: 0.1em;
        }

        .brand-text {
            font-size: 1.5rem;
            font-weight: 300;
        }
    </style>

    <!-- Page-specific styles -->
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- ╔══ NAVBAR FLOATING GLASS ════════════════════════════════════════╗ -->
        <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
            <div class="container">
                <!-- Branding -->
                <a class="navbar-brand d-flex align-items-center" href="{{ auth()->check() && auth()->user()->hasRole('admin') ? route('admin.dashboard') : url('/') }}">
                    <span>DISEÑO ORQUIDEA</span>
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <i class="bi bi-list fs-2 text-dark"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side (Admin specific) -->
                    @role('admin')
                    <ul class="navbar-nav me-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                PANEL
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                USUARIOS
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                PRODUCTOS
                            </a>
                            <div class="dropdown-menu animate-fade-in shadow-sm border-0">
                                <a class="dropdown-item" href="{{ route('productos.index') }}">
                                    <i class="bi bi-box-seam me-2"></i>{{ __('Listado') }}
                                </a>
                                <a class="dropdown-item" href="{{ route('productos.create') }}">
                                    <i class="bi bi-cloud-upload me-2"></i>{{ __('Subir Nuevo') }}
                                </a>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                PEDIDOS
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.abandoned.index') ? 'active' : '' }}" href="{{ route('admin.abandoned.index') }}">
                                CARRITOS ABANDONADOS
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.comments.index') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                                COMENTARIOS
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                                REPORTES
                            </a>
                        </li>
                    </ul>
                    @endrole

                    <!-- Right Side -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        @unless(auth()->check() && auth()->user()->hasRole('admin'))
                        <li class="nav-item mx-2">
                            <a class="nav-link {{ request()->routeIs('welcome') && !request()->has('category') ? 'active' : '' }}" href="{{ route('welcome') }}">
                                TIENDA
                            </a>
                        </li>

                        <!-- Dropdown de Productos por Categoría -->
                        <li class="nav-item dropdown mx-2">
                            <a id="navbarDropdownProductos" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                PRODUCTOS
                            </a>

                            <div class="dropdown-menu animate-fade-in shadow border-0" aria-labelledby="navbarDropdownProductos">
                                <a class="dropdown-item" href="{{ route('welcome') }}">
                                    <i class="bi bi-collection me-2"></i>PRODUCTOS GENERALES
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('welcome', ['category' => 'Jabones']) }}">
                                    <i class="bi bi-water me-2"></i>Jabones
                                </a>
                                <a class="dropdown-item" href="{{ route('welcome', ['category' => 'Mascarillas en polvo']) }}">
                                    <i class="bi bi-magic me-2"></i>Mascarillas en polvo
                                </a>
                                <a class="dropdown-item" href="{{ route('welcome', ['category' => 'Bálsamos']) }}">
                                    <i class="bi bi-droplet me-2"></i>Bálsamos
                                </a>
                                <a class="dropdown-item" href="{{ route('welcome', ['category' => 'Cremas faciales']) }}">
                                    <i class="bi bi-sparkles me-2"></i>Cremas faciales
                                </a>
                                <a class="dropdown-item" href="{{ route('welcome', ['category' => 'Cremas corporales']) }}">
                                    <i class="bi bi-wind me-2"></i>Cremas corporales
                                </a>
                            </div>
                        </li>

                        <li class="nav-item mx-2">
                            <a class="nav-link {{ request()->routeIs('sobre-orquidea') ? 'active' : '' }}" href="{{ route('sobre-orquidea') }}">
                                SOBRE ORQUIDEA
                            </a>
                        </li>
                        @endunless

                        @guest
                            <li class="nav-item mx-2">
                                <a class="nav-link" href="{{ route('admin.login') }}">
                                    <i class="bi bi-shield"></i>
                                    <span>{{ __('Admin') }}</span>
                                </a>
                            </li>
                            <li class="nav-item mx-2">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item ms-2">
                                    <a class="btn btn-auth-nav" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <!-- Cart Icon (Always visible for logged in clients) -->
                            @unless(Auth::user()->hasRole('admin'))
                            <li class="nav-item mx-2">
                                <a class="nav-link position-relative" href="#" onclick="goToFavorites(event)" id="favoritesIcon" title="Mis Favoritos">
                                    <i class="bi bi-heart fs-5"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="favCount" style="display: none; font-size: 0.6rem;">
                                        0
                                    </span>
                                </a>
                            </li>

                            <li class="nav-item mx-2">
                                <a class="nav-link position-relative" href="{{ route('cart.index') }}" id="cartIcon" title="Ver mi carrito">
                                    <i class="bi bi-cart3 fs-5"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount" style="display: none; font-size: 0.6rem;">
                                        0
                                    </span>
                                </a>
                            </li>
                            @endunless

                            <li class="nav-item dropdown ms-3">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="user-avatar-sm me-2">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end animate-fade-in shadow border-0" aria-labelledby="navbarDropdown">
                                    @role('admin')
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                            <i class="bi bi-speedometer2 me-2"></i>{{ __('Panel Admin') }}
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @else
                                        <a class="dropdown-item" href="{{ route('user.orders') }}">
                                            <i class="bi bi-clock-history me-2"></i>{{ __('Mis Compras') }}
                                        </a>
                                    @endrole
                                    
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); Object.keys(localStorage).filter(x => x.startsWith('cart_')).forEach(x => localStorage.removeItem(x)); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i>{{ __('Cerrar Sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>

        @unless(Auth::check() && Auth::user()->hasRole('admin'))
        <!-- Modal del Carrito -->
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content" style="border-radius: 15px; border: none;">
                    <div class="modal-header" style="background: var(--color-surface); border-bottom: 1px solid var(--color-border); color: var(--color-charcoal); border-radius: 16px 16px 0 0;">
                        <h5 class="modal-title" id="cartModalLabel">
                            <i class="bi bi-cart3 me-2"></i>Mi Carrito de Compras
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="cartItems">
                        <div class="text-center py-5" id="emptyCart">
                            <i class="bi bi-cart-x" style="font-size: 4rem; color: #ccc;"></i>
                            <p class="mt-3 text-muted">Tu carrito está vacío</p>
                        </div>
                    </div>
                    <div class="modal-footer" style="background: var(--color-cream);">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Total:</h5>
                                <h4 class="mb-0" id="cartTotal" style="color: var(--color-forest); font-weight: 600; font-family: 'Cormorant Garamond', serif; font-size: 1.6rem;">$0.00</h4>
                            </div>
                            <button type="button" class="btn w-100 mb-2" style="background: var(--color-cream); color: var(--color-charcoal); border: 1.5px solid var(--color-sage); font-weight: 500; letter-spacing: 0.03em;" data-bs-dismiss="modal">
                                <i class="bi bi-arrow-left me-2"></i>Seguir Comprando
                            </button>
                            <button type="button" class="btn w-100" style="background: var(--color-forest); color: var(--color-cream); border: none; font-weight: 500; letter-spacing: 0.05em; transition: background 0.3s;" onmouseover="this.style.background='var(--color-charcoal)'" onmouseout="this.style.background='var(--color-forest)'" onclick="checkout()">
                                <i class="bi bi-credit-card me-2"></i>Proceder al Pago
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endunless

        @unless(Auth::check() && Auth::user()->hasRole('admin'))
        <footer class="py-5" style="background: var(--color-surface); margin-top: 3rem;">
            <div class="container text-center">
                <div class="d-flex justify-content-center gap-4 mb-4">
                    <a href="https://www.instagram.com/alo_solorzano?igsh=N2MzeWg0dno5MHFz" class="social-icon-link" target="_blank" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://www.facebook.com/share/1EBovWtMGF/" class="social-icon-link" target="_blank" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="https://www.tiktok.com/@orquideaa_solorzano?_r=1&_t=ZS-95oWvIAENpk" class="social-icon-link" target="_blank" title="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                </div>
                
                <h5 class="mt-2 fw-bold" style="font-family: 'Cormorant Garamond', serif; letter-spacing: 0.15em; color: var(--color-tan); font-size: 1.4rem;">
                    {{ __('SOMOS DISEÑO ORQUIDEA') }}
                </h5>

                <style>
                    .social-icon-link {
                        color: var(--color-sage);
                        font-size: 1.8rem;
                        transition: all 0.3s ease;
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .social-icon-link:hover {
                        color: var(--color-tan);
                        transform: translateY(-5px);
                    }
                </style>
            </div>
        </footer>
        @endunless
    </div>
    <!-- jQuery and DataTables CDNs -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>

    @stack('scripts')

    <script>
        $(document).ready(function() {
            // Impedir que se cargue contenido en caché al retroceder después de cerrar sesión
            $(window).on('pageshow', function(event) {
                if (event.originalEvent && event.originalEvent.persisted) {
                    window.location.reload();
                }
            });

            @auth
                // Redirigir a home si intenta ir a login/register estando ya autenticado
                if (window.location.pathname.includes('login') || window.location.pathname.includes('register')) {
                    window.location.replace('/home');
                }
            @endauth

            @guest
                // Si el usuario no está autenticado pero está en una ruta que requiere auth (según URL)
                const protectedPaths = ['/home', '/admin', '/checkout', '/my-orders'];
                const currentPath = window.location.pathname;
                if (protectedPaths.some(path => currentPath.startsWith(path))) {
                    window.location.replace('/login');
                }
            @endguest

            // Cargar contador del carrito al iniciar
            updateCartCount();
        });

        // SISTEMA DE CARRITO
        function getCartKey() {
            @auth
                return 'cart_{{ Auth::id() }}';
            @endauth
            return 'cart_guest';
        }

        function getCart() {
            const cartKey = getCartKey();
            const cart = localStorage.getItem(cartKey);
            return cart ? JSON.parse(cart) : [];
        }

        function saveCart(cart) {
            const cartKey = getCartKey();
            localStorage.setItem(cartKey, JSON.stringify(cart));
            updateCartCount();
        }

        // SISTEMA DE FAVORITOS
        function getFavKey() {
            @auth
                return 'fav_{{ Auth::id() }}';
            @endauth
            return 'fav_guest';
        }

        function getFavorites() {
            const favs = localStorage.getItem(getFavKey());
            return favs ? JSON.parse(favs) : [];
        }

        function saveFavorites(favs) {
            localStorage.setItem(getFavKey(), JSON.stringify(favs));
            updateFavCount();
        }

        function updateFavCount() {
            const favs = getFavorites();
            const badge = document.getElementById('favCount');
            const icon = document.querySelector('#favoritesIcon i');

            if (favs.length > 0) {
                if(badge) {
                    badge.textContent = favs.length;
                    badge.style.display = 'block';
                }
                if(icon) {
                    icon.classList.replace('bi-heart', 'bi-heart-fill');
                    icon.style.color = '#e74c3c';
                }
            } else {
                if(badge) badge.style.display = 'none';
                if(icon) {
                    icon.classList.replace('bi-heart-fill', 'bi-heart');
                    icon.style.color = '';
                }
            }
        }

        function goToFavorites(event) {
            if(event) event.preventDefault();
            const favs = getFavorites();
            if (favs.length === 0) {
                showToastNotification('No tienes productos favoritos aún.', 'info');
                return;
            }
            window.location.href = "{{ route('favorites.index') }}?ids=" + favs.join(',');
        }

        function updateCartCount() {
            const cart = getCart();
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);
            const badge = document.getElementById('cartCount');

            if (count > 0) {
                if(badge) {
                    badge.textContent = count;
                    badge.style.display = 'block';
                }
            } else {
                if(badge) badge.style.display = 'none';
            }
        }

        function addToCart(productId, productName, productPrice, productImage = null) {
            @guest
                // Si no está logueado, redirigir al login
                if (confirm('Debes iniciar sesión para agregar productos al carrito. ¿Deseas ir al login?')) {
                    window.location.href = "{{ route('login') }}";
                }
                return false;
            @endguest

            const cart = getCart();
            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: parseFloat(productPrice),
                    quantity: 1,
                    image: productImage
                });
            }

            saveCart(cart);
            showToastNotification('Producto agregado al carrito', 'success');
            return true;
        }

        function removeFromCart(productId) {
            let cart = getCart();
            cart = cart.filter(item => item.id !== productId);
            saveCart(cart);
            renderCart();
            showToastNotification('Producto eliminado del carrito', 'info');
        }

        function updateQuantity(productId, change) {
            const cart = getCart();
            const item = cart.find(item => item.id === productId);

            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    removeFromCart(productId);
                } else {
                    saveCart(cart);
                    renderCart();
                }
            }
        }

        function toggleCart(event) {
            event.preventDefault();
            renderCart();
            const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
            cartModal.show();
        }

        function renderCart() {
            const cart = getCart();
            const cartItemsDiv = document.getElementById('cartItems');
            const emptyCart = document.getElementById('emptyCart');
            const cartTotal = document.getElementById('cartTotal');

            if (cart.length === 0) {
                emptyCart.style.display = 'block';
                cartTotal.textContent = '$0.00';
                return;
            }

            emptyCart.style.display = 'none';

            let total = 0;
            let html = '<div class="list-group">';

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                html += `
                    <div class="list-group-item d-flex align-items-center gap-3 mb-2" style="border-radius: 10px; border: 2px solid #e0e6ed;">
                        ${item.image ? `<img src="${item.image}" alt="${item.name}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">` : '<div style="width: 60px; height: 60px; background: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-image" style="font-size: 1.5rem; color: #999;"></i></div>'}
                        <div class="flex-grow-1">
                            <h6 class="mb-1">${item.name}</h6>
                            <small class="text-muted">$${item.price.toFixed(2)} c/u</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${item.id}, -1)" style="width: 30px; height: 30px; padding: 0; border-radius: 50%;">
                                <i class="bi bi-dash"></i>
                            </button>
                            <span class="fw-bold" style="min-width: 30px; text-align: center;">${item.quantity}</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity(${item.id}, 1)" style="width: 30px; height: 30px; padding: 0; border-radius: 50%;">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <div class="text-end" style="min-width: 80px;">
                            <div class="fw-bold" style="color: var(--color-forest); font-family: 'Cormorant Garamond', serif; font-size: 1.1rem;">$${itemTotal.toFixed(2)}</div>
                            <button class="btn btn-sm btn-link text-danger p-0" onclick="removeFromCart(${item.id})" style="font-size: 0.85rem;">
                                <i class="bi bi-trash"></i> Eliminar
                            </button>
                        </div>
                    </div>
                `;
            });

            html += '</div>';
            cartItemsDiv.innerHTML = html;
            cartTotal.textContent = '$' + total.toFixed(2);
        }

        function checkout() {
            @guest
                alert('Debes iniciar sesión para proceder con la compra');
                window.location.href = "{{ route('login') }}";
                return;
            @endguest

            const cart = getCart();
            if (cart.length === 0) {
                alert('Tu carrito está vacío');
                return;
            }

            // Aquí puedes implementar la lógica de checkout
            alert('Funcionalidad de pago en desarrollo.\n\nProductos en carrito: ' + cart.length);
        }

        function showToastNotification(message, type = 'success') {
            const icon = type === 'success' ? 'cart-check-fill' : type === 'error' ? 'x-circle-fill' : 'info-circle-fill';
            const bgColor = type === 'success' ? 'var(--color-forest)' : type === 'error' ? '#b04a3a' : 'var(--color-sage)';

            const toastHtml = `
                <div class="toast-custom align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true"
                     style="position: fixed; top: 100px; right: 30px; z-index: 9999; background: ${bgColor}; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); min-width: 350px; animation: slideInRight 0.4s ease, fadeOut 0.4s ease 4.6s;">
                    <div class="d-flex align-items-center p-3">
                        <div class="toast-icon me-3" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="bi bi-${icon}" style="font-size: 1.75rem;"></i>
                        </div>
                        <div class="toast-content flex-grow-1">
                            <div class="toast-title" style="font-weight: 700; font-size: 1.1rem; margin-bottom: 0.25rem;">
                                ${type === 'success' ? '¡Éxito!' : type === 'error' ? 'Error' : 'Información'}
                            </div>
                            <div class="toast-message" style="font-size: 0.95rem; opacity: 0.95;">
                                ${message}
                            </div>
                        </div>
                        <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="toast" aria-label="Close" style="opacity: 0.8;"></button>
                    </div>
                    <div class="toast-progress" style="position: absolute; bottom: 0; left: 0; width: 100%; height: 3px; background: rgba(255,255,255,0.3); border-radius: 0 0 15px 15px; overflow: hidden;">
                        <div class="toast-progress-bar" style="height: 100%; background: rgba(255,255,255,0.6); width: 100%; animation: progressBar 5s linear;"></div>
                    </div>
                </div>
            `;

            // Agregar estilos de animación si no existen
            if (!document.getElementById('toast-animations')) {
                const style = document.createElement('style');
                style.id = 'toast-animations';
                style.textContent = `
                    @keyframes slideInRight {
                        from {
                            transform: translateX(400px);
                            opacity: 0;
                        }
                        to {
                            transform: translateX(0);
                            opacity: 1;
                        }
                    }
                    @keyframes fadeOut {
                        from {
                            opacity: 1;
                            transform: translateX(0);
                        }
                        to {
                            opacity: 0;
                            transform: translateX(400px);
                        }
                    }
                    @keyframes progressBar {
                        from {
                            width: 100%;
                        }
                        to {
                            width: 0%;
                        }
                    }
                    .toast-custom:hover .toast-progress-bar {
                        animation-play-state: paused;
                    }
                `;
                document.head.appendChild(style);
            }

            const toastElement = $(toastHtml);
            $('body').append(toastElement);

            const toast = new bootstrap.Toast(toastElement[0], { delay: 5000, animation: true });
            toast.show();

            toastElement.on('hidden.bs.toast', function() {
                toastElement.remove();
            });
        }
    </script>
</body>
</html>
