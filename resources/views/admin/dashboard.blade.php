@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-5 align-items-center">
        <div class="col-md-8">
            <h1 class="fw-bold mb-1" style="color: var(--color-forest); font-family: 'Cormorant Garamond', serif; font-size: 2.5rem;">
                Panel de Administración
            </h1>
            <p class="text-muted mb-0" style="font-size: 1.1rem;">
                Bienvenido, {{ Auth::user()->name }}. Gestiona todos los aspectos de Orquidea.
            </p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="d-inline-flex align-items-center gap-2" style="background: rgba(72, 99, 63, 0.1); padding: 0.5rem 1rem; border-radius: 50px; border: 1px solid rgba(72, 99, 63, 0.2);">
                <i class="bi bi-clock-history" style="color: var(--color-forest);"></i>
                <span style="color: var(--color-charcoal); font-weight: 500; font-size: 0.95rem;">
                    {{ now()->translatedFormat('l, d \d\e F') }}
                </span>
            </div>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        <!-- Usuarios -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('users.index') }}" class="text-decoration-none h-100 d-block">
                <div class="card h-100 border-0 shadow-sm admin-module-card" style="border-radius: 16px; overflow: hidden; background: #fff;">
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-center align-items-center h-100 position-relative z-1">
                        <div class="icon-circle mb-3 d-flex justify-content-center align-items-center" style="width: 70px; height: 70px; background: rgba(0, 0, 0, 0.05); border-radius: 50%; color: #000000; font-size: 2rem; transition: all 0.3s ease;">
                            <i class="bi bi-people"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: var(--color-charcoal);">Usuarios</h4>
                        <p class="text-muted small mb-0">Gestionar cuentas de clientes y administradores</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Productos -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('productos.create') }}" class="text-decoration-none h-100 d-block">
                <div class="card h-100 border-0 shadow-sm admin-module-card" style="border-radius: 16px; overflow: hidden; background: #fff;">
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-center align-items-center h-100 position-relative z-1">
                        <div class="icon-circle mb-3 d-flex justify-content-center align-items-center" style="width: 70px; height: 70px; background: rgba(0, 0, 0, 0.05); border-radius: 50%; color: #000000; font-size: 2rem; transition: all 0.3s ease;">
                            <i class="bi bi-cloud-upload"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: var(--color-charcoal);">Subir Productos</h4>
                        <p class="text-muted small mb-0">Agregar, editar o eliminar inventario</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pedidos -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('admin.orders.index') }}" class="text-decoration-none h-100 d-block">
                <div class="card h-100 border-0 shadow-sm admin-module-card" style="border-radius: 16px; overflow: hidden; background: #fff;">
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-center align-items-center h-100 position-relative z-1">
                        <div class="icon-circle mb-3 d-flex justify-content-center align-items-center" style="width: 70px; height: 70px; background: rgba(0, 0, 0, 0.05); border-radius: 50%; color: #000000; font-size: 2rem; transition: all 0.3s ease;">
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: var(--color-charcoal);">Pedidos</h4>
                        <p class="text-muted small mb-0">Revisar ventas y enviar órdenes</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Abandono de Productos -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('admin.abandoned.index') }}" class="text-decoration-none h-100 d-block">
                <div class="card h-100 border-0 shadow-sm admin-module-card" style="border-radius: 16px; overflow: hidden; background: #fff;">
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-center align-items-center h-100 position-relative z-1">
                        <div class="icon-circle mb-3 d-flex justify-content-center align-items-center" style="width: 70px; height: 70px; background: rgba(0, 0, 0, 0.05); border-radius: 50%; color: #000000; font-size: 2rem; transition: all 0.3s ease;">
                            <i class="bi bi-bag-x"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: var(--color-charcoal);">Carritos Abandonados</h4>
                        <p class="text-muted small mb-0">Ver clientes con productos pendientes</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Comentarios -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('admin.comments.index') }}" class="text-decoration-none h-100 d-block">
                <div class="card h-100 border-0 shadow-sm admin-module-card" style="border-radius: 16px; overflow: hidden; background: #fff;">
                    <div class="card-body p-4 text-center d-flex flex-column justify-content-center align-items-center h-100 position-relative z-1">
                        <div class="icon-circle mb-3 d-flex justify-content-center align-items-center" style="width: 70px; height: 70px; background: rgba(0, 0, 0, 0.05); border-radius: 50%; color: #000000; font-size: 2rem; transition: all 0.3s ease;">
                            <i class="bi bi-chat-dots"></i>
                        </div>
                        <h4 class="fw-bold mb-2" style="color: var(--color-charcoal);">Comentarios</h4>
                        <p class="text-muted small mb-0">Moderar reseñas y el muro público</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
    .admin-module-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(72, 99, 63, 0.15);
        position: relative;
    }
    
    .admin-module-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 6px;
        background: var(--color-forest);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
        z-index: 2;
    }

    .admin-module-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(45, 45, 38, 0.1) !important;
        border-color: rgba(72, 99, 63, 0.25);
    }

    .admin-module-card:hover::before {
        transform: scaleX(1);
    }
    
    .admin-module-card:hover .icon-circle {
        background: var(--color-forest) !important;
        color: var(--color-cream) !important;
        transform: scale(1.1);
    }
</style>
@endpush
@endsection
