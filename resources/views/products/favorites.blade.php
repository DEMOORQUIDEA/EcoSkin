@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="eco-section-heading mb-4">
        <span class="eco-section-heading__line"></span>
        <h2 class="eco-section-heading__title">
            Mis Favoritos: <span class="text-tan">Selección Personal</span>
        </h2>
        <span class="eco-section-heading__line"></span>
    </div>

    @if($products->count() > 0)
        <div class="eco-grid">
            @foreach($products as $product)
                @php
                    $isAvailable = $product->is_active && ($product->stock > 0);
                    $grayscaleStyle = !$isAvailable ? 'filter: grayscale(1); opacity: 0.7;' : '';
                @endphp
                <div class="eco-card" style="{{ $grayscaleStyle }}">
                    <a href="{{ route('products.show', $product) }}" class="eco-card__img-link">
                        <div class="eco-card__img-wrap">
                            @if($product->hasImage())
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="eco-card__img">
                            @else
                                <div class="eco-card__img-placeholder">
                                    <i class="bi bi-flower2"></i>
                                </div>
                            @endif
                            
                            @if($product->stock > 0 && $product->stock <= 5)
                                <span class="eco-card__badge" style="background: #e74c3c; left: auto; right: 12px; font-weight: bold;">¡YA CASI AGOTADOS!</span>
                            @endif
                            
                            @if(!$isAvailable)
                                <span class="eco-card__badge" style="background: #6c757d;">No Disponible</span>
                            @else
                                <span class="eco-card__badge" style="background: rgba(72, 99, 63, 0.85);">{{ $product->stock }} disponibles</span>
                            @endif

                            <button class="eco-card__fav active" onclick="toggleFavoriteWithPersistence({{ $product->id }}, this, event)" title="Quitar de favoritos">
                                <i class="bi bi-heart-fill" style="color: #e74c3c;"></i>
                            </button>
                        </div>
                    </a>

                    <div class="eco-card__body">
                        <h6 class="eco-card__name">
                            <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-dark">
                                {{ Str::limit($product->name, 50) }}
                            </a>
                        </h6>
                        <p class="eco-card__desc">{{ Str::limit($product->description, 75) }}</p>

                        <div class="eco-card__footer">
                            <div class="eco-card__price-block">
                                <span class="eco-card__price">${{ number_format($product->price, 2) }}</span>
                            </div>
                            @if($isAvailable)
                                <button class="eco-card__btn-cart"
                                        onclick="addToCartFromWelcome({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->hasImage() ? $product->image_url : '' }}')">
                                    <i class="bi bi-cart-plus-fill"></i>
                                    <span>{{ __('Agregar') }}</span>
                                </button>
                            @else
                                <button class="eco-card__btn-cart" disabled style="background: #ccc; cursor: not-allowed;">
                                    <i class="bi bi-x-circle"></i>
                                    <span>Agotado</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="eco-empty">
            <div class="eco-empty__icon">
                <i class="bi bi-heart"></i>
            </div>
            <h4>No tienes productos favoritos aún</h4>
            <p>Explora nuestro catálogo y marca los productos que más te gusten.</p>
            <a href="{{ route('welcome') }}" class="eco-btn eco-btn--primary">
                <i class="bi bi-shop me-2"></i>Ir a la tienda
            </a>
        </div>
    @endif
</div>

<style>
/* Reutilizar estilos de welcome-simple si no están globales */
.eco-section-heading { display: flex; align-items: center; gap: 1.5rem; }
.eco-section-heading__line { flex: 1; height: 1px; background: #000; }
.eco-section-heading__title { font-family: 'Cormorant Garamond', serif; font-weight: 500; font-size: 1.9rem; color: #1B2B1B; white-space: nowrap; }
.text-tan { color: var(--color-tan) !important; }

.eco-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1.75rem;
}

.eco-card {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease;
}
.eco-card:hover { transform: translateY(-5px); }

.eco-card__img-wrap {
    position: relative;
    height: 220px;
    background: #f8f9fa;
    overflow: hidden;
}
.eco-card__img { width: 100%; height: 100%; object-fit: cover; }
.eco-card__img-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 4rem; color: #ccc; }

.eco-card__badge {
    position: absolute;
    top: 12px; left: 12px;
    background: #48633F;
    color: white;
    font-size: 0.7rem;
    padding: 0.25rem 0.7rem;
    border-radius: 50px;
    text-transform: uppercase;
}

.eco-card__fav {
    position: absolute;
    top: 10px; right: 10px;
    width: 36px; height: 36px;
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.eco-card__body { padding: 1.25rem; flex: 1; display: flex; flex-direction: column; }
.eco-card__name { font-family: 'Cormorant Garamond', serif; font-size: 1.15rem; font-weight: 600; margin-bottom: 0.5rem; }
.eco-card__name a { color: #1B2B1B; }
.eco-card__desc { font-size: 0.85rem; color: #666; flex: 1; margin-bottom: 1rem; }

.eco-card__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid #eee;
    padding-top: 1rem;
}
.eco-card__price { font-family: 'Cormorant Garamond', serif; font-size: 1.35rem; font-weight: 600; color: #48633F; }

.eco-card__btn-cart {
    background: #48633F;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    cursor: pointer;
}

.eco-empty { text-align: center; padding: 5rem 2rem; background: white; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
.eco-empty__icon { font-size: 3rem; color: #ccc; margin-bottom: 1rem; }
.eco-btn { display: inline-flex; align-items: center; padding: 0.75rem 2rem; border-radius: 50px; text-decoration: none; font-weight: 500; }
.eco-btn--primary { background: #48633F; color: white; }
</style>

<script>
function toggleFavoriteWithPersistence(productId, btn, event) {
    if(event) event.preventDefault();
    let favs = getFavorites();
    const index = favs.indexOf(productId);
    
    if (index > -1) {
        favs.splice(index, 1);
        btn.closest('.eco-card').remove(); // Remover de la vista de favoritos inmediatamente
    } else {
        favs.push(productId);
    }
    
    saveFavorites(favs);
    
    if (favs.length === 0) {
        location.reload(); // Mostrar empty state si ya no quedan favoritos
    }
}
</script>
@endsection
