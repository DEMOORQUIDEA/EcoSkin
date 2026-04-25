<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ config('app.name', 'Orquidea') }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.css">

    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-cream: #FFADC2;
            --color-surface: #F889A5;
            --color-tan: #FFFFFF;
            --color-sage: #FFE3EA;
            --color-forest: #FFFFFF;
            --color-charcoal: #FFFFFF;
            --color-border: #FFD4DE;
        }

        /* Estilos generales */
        body {
            background: var(--color-cream);
            font-family: 'Jost', sans-serif;
            color: var(--color-charcoal) !important;
        }
        
        h1, h2, h3, h4, h5, h6, p, span, div, th, td {
            color: var(--color-charcoal) !important;
        }

        .card, .table {
            background-color: var(--color-surface) !important;
            color: var(--color-charcoal) !important;
        }
        .table td, .table th {
            background-color: transparent !important;
            color: var(--color-charcoal) !important;
            border-color: var(--color-border) !important;
        }
        
        .form-control, .form-select, input, select, textarea {
            background-color: var(--color-cream) !important;
            color: var(--color-charcoal) !important;
            border: 1px solid var(--color-border) !important;
        }
        ::placeholder {
            color: var(--color-sage) !important;
            opacity: 1 !important;
        }

        /* Navbar */
        .navbar-custom {
            background: var(--color-charcoal);
            box-shadow: 0 2px 16px rgba(45, 45, 38, 0.18);
            padding: 0.85rem 0;
        }

        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            font-size: 1.6rem;
            letter-spacing: 0.04em;
            color: var(--color-cream) !important;
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

        .navbar-brand-icon img {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            filter: brightness(0) invert(1);
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
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28230, 234, 221, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* User Dropdown */
        .user-dropdown {
            background: rgba(230, 234, 221, 0.12);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            border: 1.5px solid rgba(186, 155, 114, 0.3);
        }

        .user-dropdown:hover {
            background: rgba(186, 155, 114, 0.15);
        }

        .navbar-nav .nav-link.dropdown-toggle {
            color: var(--color-cream) !important;
            font-weight: 400;
            letter-spacing: 0.03em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .navbar-nav .nav-link.dropdown-toggle::after {
            margin-left: 0.5rem;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid var(--color-tan);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .dropdown-menu {
            border-radius: 10px;
            border: 1px solid rgba(162, 165, 141, 0.2);
            box-shadow: 0 12px 40px rgba(45, 45, 38, 0.12);
            padding: 0.5rem;
            margin-top: 0.5rem;
            min-width: 220px;
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

        .dropdown-divider {
            margin: 0.4rem 0;
            border-color: rgba(162, 165, 141, 0.3);
        }

        /* Main content */
        main {
            min-height: calc(100vh - 76px);
        }

        /* Footer */
        footer {
            background: var(--color-charcoal);
            color: var(--color-cream);
            padding: 2rem 0;
            margin-top: 3rem;
        }

        footer p {
            margin: 0;
            opacity: 0.85;
            letter-spacing: 0.02em;
            font-size: 0.9rem;
        }

        footer a {
            color: var(--color-tan);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        footer a:hover {
            color: var(--color-cream);
        }

        /* ── BOOTSTRAP OVERRIDES (FORZAR VERDE) ──────────────── */
        .btn-primary {
            background-color: var(--color-forest) !important;
            border-color: var(--color-forest) !important;
            color: var(--color-cream) !important;
        }

        /* botones personalizados para activar/desactivar coherentes */
        .btn-activate {
            background: var(--color-forest) !important;
            color: var(--color-surface) !important;
        }
        .btn-activate:hover {
            filter: brightness(0.9);
        }
        .btn-deactivate {
            background: var(--color-forest) !important;
            color: var(--color-surface) !important;
        }
        .btn-deactivate:hover {
            filter: brightness(0.9);
        }

        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: var(--color-charcoal) !important;
            border-color: var(--color-charcoal) !important;
            box-shadow: 0 4px 12px rgba(45, 45, 38, 0.25) !important;
        }

        .btn-outline-primary {
            color: var(--color-forest) !important;
            border-color: var(--color-forest) !important;
        }
        .btn-outline-primary:hover {
            background-color: var(--color-forest) !important;
            color: var(--color-cream) !important;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--color-sage) !important;
            box-shadow: 0 0 0 0.25rem rgba(162, 165, 141, 0.25) !important;
        }

        .text-primary { color: var(--color-forest) !important; }
        .bg-primary { background-color: var(--color-forest) !important; }

        .page-item.active .page-link {
            background-color: var(--color-forest) !important;
            border-color: var(--color-forest) !important;
        }
        .page-link { color: var(--color-forest); }
        .page-link:hover { color: var(--color-charcoal); }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: var(--color-cream); }
        ::-webkit-scrollbar-thumb { background: var(--color-sage); border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--color-forest); }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.3rem;
            }

            .user-dropdown {
                margin-top: 1rem;
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <!-- Slot para CSS personalizado -->
    @yield('css')
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-custom">
            <div class="container">
                <!-- Brand -->
                <a class="navbar-brand d-flex align-items-center" href="{{ auth()->check() && auth()->user()->hasRole('admin') ? route('admin.dashboard') : url('/') }}">
                    <div class="logo-ec-container me-2">
                        <span class="logo-ec">O</span>
                    </div>
                    <span class="brand-text">
                        <span>Orquidea</span>
                    </span>
                </a>

                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navbar Content -->
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown user-dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="user-avatar" src="{{ asset('images/avatar.png') }}" alt="Avatar">
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2"></i>
                                        <span>Panel</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('products.index') }}">
                                        <i class="bi bi-box-seam"></i>
                                        <span>Productos</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-person-circle"></i>
                                        <span>Mi Perfil</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-gear"></i>
                                        <span>Configuración</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                        <i class="bi bi-box-arrow-left"></i>
                                        <span>Cerrar Sesión</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <div class="container text-center">
            <h5 class="mt-2 fw-bold" style="font-family: 'Cormorant Garamond', serif; letter-spacing: 0.15em; color: var(--color-tan); font-size: 1.4rem;">
                SOMOS ORQUIDEA COSMETICS
            </h5>
            <div class="col-md-4 text-center text-md-end footer-right pt-3 pt-md-0">
                Orquidea Cosmetics © {{ date('Y') }}
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>

    <!-- Slot para JS personalizado -->
    @yield('js')
</body>

</html>
