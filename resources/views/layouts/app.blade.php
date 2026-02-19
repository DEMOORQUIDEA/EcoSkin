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
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* Estilos generales */
        body {
            font-family: 'Nunito', sans-serif;
            background: #f5f7fa;
        }

        /* Navbar moderna */
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 0.75rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: translateY(-2px);
        }

        .navbar-brand-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand-icon i {
            font-size: 1.5rem;
        }

        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.2);
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .navbar-nav .nav-link {
            color: white !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
        }

        .navbar-nav .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
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
            background: rgba(255, 255, 255, 0.15);
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            animation: cartBounce 0.5s ease;
        }

        @keyframes cartBounce {
            0%, 100% { transform: translate(-50%, 0) scale(1); }
            50% { transform: translate(-50%, -5px) scale(1.1); }
        }

        /* Modal del carrito */
        .modal-content {
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .list-group-item {
            transition: all 0.3s ease;
        }

        .list-group-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* User Dropdown */
        .user-dropdown {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 0.25rem 0.75rem;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .user-dropdown:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .navbar-nav .nav-link.dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-menu {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 0.75rem;
            margin-top: 0.5rem;
            min-width: 200px;
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .dropdown-item i {
            font-size: 1.1rem;
            width: 20px;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateX(5px);
        }

        /* Main content */
        main {
            min-height: calc(100vh - 76px);
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 0;
            margin-top: auto;
        }

        footer p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        footer a {
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        footer a:hover {
            opacity: 0.8;
        }

        /* Scrollbar personalizado */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.25rem;
            }

            .user-dropdown {
                margin-top: 1rem;
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <!-- Page-specific styles -->
    @stack('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-custom">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div class="navbar-brand-icon">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <span>{{ config('app.name', 'Jesus\'s page') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Carrito de Compras -->
                        <li class="nav-item me-3">
                            <a class="nav-link position-relative" href="#" id="cartIcon" onclick="toggleCart(event)">
                                <i class="bi bi-cart3" style="font-size: 1.5rem;"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartCount" style="display: none; font-size: 0.7rem;">
                                    0
                                </span>
                            </a>
                        </li>

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="bi bi-box-arrow-in-right me-1"></i>
                                        {{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">
                                        <i class="bi bi-person-plus me-1"></i>
                                        {{ __('Register') }}
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
                                    <a class="dropdown-item" href="{{ route('home') }}">
                                        <i class="bi bi-house-door"></i>
                                        <span>Inicio</span>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('products.index') }}">
                                        <i class="bi bi-box-seam"></i>
                                        <span>Productos</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
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

        <!-- Modal del Carrito -->
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content" style="border-radius: 15px; border: none;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
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
                    <div class="modal-footer" style="background: #f8f9fa;">
                        <div class="w-100">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Total:</h5>
                                <h4 class="mb-0" id="cartTotal" style="color: #667eea; font-weight: 700;">$0.00</h4>
                            </div>
                            <button type="button" class="btn btn-secondary w-100 mb-2" data-bs-dismiss="modal">
                                <i class="bi bi-arrow-left me-2"></i>Seguir Comprando
                            </button>
                            <button type="button" class="btn w-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;" onclick="checkout()">
                                <i class="bi bi-credit-card me-2"></i>Proceder al Pago
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="container text-center">
                <p>
                    <i class="bi bi-heart-fill me-2"></i>
                    Hecho con amor por Jesus's Team © {{ date('Y') }}
                </p>
            </div>
        </footer>
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
        function getCart() {
            const cart = localStorage.getItem('cart');
            return cart ? JSON.parse(cart) : [];
        }

        function saveCart(cart) {
            localStorage.setItem('cart', JSON.stringify(cart));
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
                            <div class="fw-bold" style="color: #667eea;">$${itemTotal.toFixed(2)}</div>
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
            const bgColor = type === 'success' ? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' : type === 'error' ? 'linear-gradient(135deg, #f56565 0%, #e53e3e 100%)' : 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)';

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
