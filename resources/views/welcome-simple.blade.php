@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('messages.Welcome') }}</div>

                <div class="card-body">
                    @guest
                        <h4>Bienvenido invitado!!!</h4>
                        {{-- <p class="mb-4">Por favor, inicia sesión para acceder al menú principal.</p> --}}
                        <p class="mt-4">Aquí puedes acceder a la información de contenido público</p>
                    @else
                        <h4>¡Hola, {{ Auth::user()->name }} !</h4>
                        <p class="mb-4">Has iniciado sesión correctamente.</p>
                        <p class="mb-4">En breve serás redireccionado...</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">{{ __('Ir al Menú Principal') }}</a>
                    @endguest
                </div>
            </div>


        </div>
    </div>

    <!-- Sección de Productos -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Catálogo de Productos') }}</h5>
                    <span class="badge bg-primary">{{ $products->total() }} productos disponibles</span>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                            @foreach($products as $product)
                                <div class="col">
                                    <div class="card h-100 product-card">
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
                                                <p class="h5 text-primary mb-2">
                                                    ${{ number_format($product->price, 2) }}
                                                </p>
                                                <button class="btn btn-sm btn-outline-primary w-100" disabled>
                                                    <i class="bi bi-eye"></i> Ver detalles
                                                </button>
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
            </div>
        </div>
    </div>

    <!-- Paginación fuera del card -->
    @if($products->count() > 0)
    <div class="row mt-4">
        <div class="col-12">
            {{ $products->links('vendor.pagination.custom') }}
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .gap-3 {
        gap: 1rem;
    }
    .d-flex {
        display: flex;
    }
    .card {
        transition: all 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* Estilos para productos */
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
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


</style>
@endpush

@push('scripts')
<script>
@auth
    // redireccinar a home en 5 segs
    setTimeout(function() {
        window.location.href = "{{ route('home') }}";
    }, 2000);
@endauth

</script>
@endpush
