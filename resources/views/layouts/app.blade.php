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

    <style>
        /* ====================================================
           PALETA EcoSkin Minimalista
           Limpieza, luz, y toques sutiles de verde
        ==================================================== */
        :root {
            --color-cream: #FCFCFC;     /* Fondo principal casi blanco */
            --color-surface: #FFFFFF;    /* Blanco puro para tarjetas/navbar */
            --color-tan: #829D64;        /* Verde suave para acentos sutiles */
            --color-sage: #8A9286;       /* Gris con subtono verde para textos secundarios */
            --color-forest: #4A5B42;     /* Verde oscuro para botones principales */
            --color-charcoal: #2A2F28;   /* Gris antracita para el texto, menos duro que negro */
            --color-border: #EAECE8;     /* Bordes muy tenues */
        }

        /* Estilos generales */
        body {
            font-family: 'Jost', sans-serif;
            background: var(--color-cream);
            color: var(--color-charcoal);
        }

        /* Navbar Minimalista */
        .navbar-custom {
            background: var(--color-surface);
            box-shadow: 0 1px 12px rgba(0, 0, 0, 0.04);
            padding: 1.1rem 0;
            border-bottom: 1px solid var(--color-border);
        }

        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-size: 1.6rem;
            letter-spacing: 0.02em;
            color: var(--color-charcoal) !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--color-tan) !important;
        }

        .navbar-brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--color-forest);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-brand-icon i {
            font-size: 1.3rem;
            color: var(--color-cream);
        }

        .navbar-toggler {
            border: 1.5px solid rgba(230, 234, 221, 0.4);
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.15rem rgba(186, 155, 114, 0.4);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2842, 47, 40, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-nav .nav-link {
            color: var(--color-charcoal) !important;
            font-weight: 400;
            letter-spacing: 0.04em;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            margin: 0 0.4rem;
            font-size: 0.92rem;
            text-transform: uppercase;
        }

        .navbar-nav .nav-link:hover {
            color: var(--color-tan) !important;
            background: rgba(186, 155, 114, 0.08);
            transform: translateY(-1px);
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
        <nav class="navbar navbar-expand-md navbar-custom">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ auth()->check() && auth()->user()->hasRole('admin') ? route('admin.dashboard') : url('/') }}">
                <div class="logo-ec-container me-2">
                    <span class="logo-ec">EC</span>
                </div>
                <span class="brand-text">EcoSkin</span>
            </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @role('admin')
                            {{-- Administrador: Panel y secciones principales --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2 me-1"></i> {{ __('Dashboard') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                    <i class="bi bi-people me-1"></i> {{ __('Users') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('productos.create') ? 'active' : '' }}" href="{{ route('productos.create') }}">
                                    <i class="bi bi-cloud-upload me-1"></i> {{ __('Subir Productos') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('productos.index') ? 'active' : '' }}" href="{{ route('productos.index') }}">
                                    <i class="bi bi-box-seam me-1"></i> {{ __('Productos') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                                    <i class="bi bi-cart-check me-1"></i> {{ __('Orders') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.abandoned.index') ? 'active' : '' }}" href="{{ route('admin.abandoned.index') }}">
                                    <i class="bi bi-bag-x me-1"></i> {{ __('Abandoned Cart') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.comments.index') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                                    <i class="bi bi-chat-dots me-1"></i> {{ __('Comments') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                                    <i class="bi bi-graph-up me-1"></i> {{ __('Reporte de Ventas') }}
                                </a>
                            </li>
                        @else
                            {{-- Cliente/Invitado: Nosotros y Productos --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('nosotros') ? 'active' : '' }}" href="{{ route('nosotros') }}">
                                    <i class="bi bi-people me-1"></i> {{ __('Nosotros') }}
                                </a>
                            </li>
                            @auth
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('productos.create') ? 'active' : '' }}" href="{{ route('productos.create') }}">
                                    <i class="bi bi-cloud-upload me-1"></i> {{ __('Subir Productos') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('productos.index') ? 'active' : '' }}" href="{{ route('productos.index') }}">
                                    <i class="bi bi-box-seam me-1"></i> {{ __('Productos') }}
                                </a>
                            </li>
                            @endauth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdownProductos" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-grid me-1"></i> {{ __('Products') }}
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdownProductos">
                                    <a class="dropdown-item" href="{{ route('welcome') }}">
                                        <i class="bi bi-collection"></i> <span>{{ __('General Products') }}</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('welcome', ['category' => 'Jabones']) }}">
                                        <i class="bi bi-water"></i> <span>Jabones</span>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('welcome', ['category' => 'Mascarillas en polvo']) }}">
                                        <i class="bi bi-magic"></i> <span>Mascarillas en polvo</span>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('welcome', ['category' => 'Bálsamos']) }}">
                                        <i class="bi bi-droplet"></i> <span>Bálsamos</span>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('welcome', ['category' => 'Cremas faciales']) }}">
                                        <i class="bi bi-sparkles"></i> <span>Cremas faciales</span>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('welcome', ['category' => 'Cremas corporales']) }}">
                                        <i class="bi bi-wind"></i> <span>Cremas corporales</span>
                                    </a>
                                </div>
                            </li>
                        @endrole
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto d-flex align-items-center">
                        <!-- Historial de Compras (Solo usuarios autenticados no admin) -->
                        @if(Auth::check() && !Auth::user()->hasRole('admin'))
                        <li class="nav-item me-2 d-flex align-items-center">
                            <a class="nav-link d-flex align-items-center gap-2" href="{{ route('user.orders') }}" title="Mi Historial de Compras" style="padding: 0.5rem 1rem !important; border-radius: 8px; transition: all 0.3s;" onmouseover="this.style.background='rgba(186, 155, 114, 0.15)';" onmouseout="this.style.background='transparent';">
                                <i class="bi bi-clock-history" style="font-size: 1.2rem;"></i>
                                <span style="font-weight: 500; font-size: 0.95rem;">Historial de compras</span>
                            </a>
                        </li>
                        @endif

                        <!-- Carrito de Compras -->
                        @unless(Auth::check() && Auth::user()->hasRole('admin'))
                        <li class="nav-item me-3">
                            @auth
                            <a class="nav-link position-relative" href="{{ route('cart.index') }}" id="cartIcon" title="Ver mi carrito">
                            @else
                            <a class="nav-link position-relative" href="{{ route('login') }}" id="cartIcon" title="Iniciar sesión para ver carrito">
                            @endauth
                                <i class="bi bi-cart3" style="font-size: 1.5rem;"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount" style="display: none; font-size: 0.7rem;">
                                    0
                                </span>
                            </a>
                        </li>
                        @endunless

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.login') }}">
                                    <i class="bi bi-shield"></i>
                                    <span>{{ __('Administrador') }}</span>
                                </a>
                            </li>
                        @endguest

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">
                                    <i class="bi bi-person"></i>
                                    <span>{{ __('Login') }}</span>
                                </a>
                            </li>
                        @endif

                            @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">
                                    <i class="bi bi-person-plus"></i>
                                    <span>{{ __('Register') }}</span>
                                </a>
                            </li>
                        @endif
                        @else
                            <li class="nav-item dropdown user-dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-person-circle"></i>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @role('admin')
                                        {{-- Para Admin: Solo Logout --}}
                                        <div class="dropdown-header text-uppercase small font-weight-bold" style="color: var(--color-sage);">Sesión de Administrador</div>
                                    @else
                                        {{-- Para Cliente: Inicio y Logout --}}
                                        <a class="dropdown-item" href="{{ route('home') }}">
                                            <i class="bi bi-house-door"></i>
                                            <span>Inicio</span>
                                        </a>
                                    @endrole

                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        <i class="bi bi-box-arrow-left"></i>
                                        <span>{{ __('Logout') }}</span>
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
                    <a href="#" class="social-icon-link" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="social-icon-link" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="social-icon-link" title="TikTok">
                        <i class="bi bi-tiktok"></i>
                    </a>
                </div>
                
                <h5 class="mt-2 fw-bold" style="font-family: 'Cormorant Garamond', serif; letter-spacing: 0.15em; color: var(--color-tan); font-size: 1.4rem;">
                    SOMOS ECOSKIN COSMETICS
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
    @stack('scripts')

    <script>
        $(document).ready(function() {
            @guest
                // Redirect if cached page accessed without authentication
                $(window).on('pageshow', function(event) {
                    if (event.originalEvent && event.originalEvent.persisted) {
                        window.location.replace('/');
                    }
                });
            @endguest

            @auth
                // usuarios autentificados, redireccionarlos a su home
                if (window.location.pathname.includes('login') || window.location.pathname.includes('register')) {
                    window.location.replace('/home');
                }
            @endauth

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

        function updateCartCount() {
            const cart = getCart();
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);
            const badge = document.getElementById('cartCount');

            if (count > 0) {
                badge.textContent = count;
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
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
