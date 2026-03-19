@extends('layouts.app')

@section('content')
<style>
    .product-detail-container {
        padding: 4rem 0;
        background: var(--color-cream);
        min-height: 80vh;
    }
    .product-main {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: row;
    }
    .product-image-side {
        flex: 1;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    .product-image-side img {
        max-width: 100%;
        max-height: 500px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .product-info-side {
        flex: 1;
        padding: 3rem;
        display: flex;
        flex-direction: column;
    }
    .category-badge {
        display: inline-block;
        background: rgba(142, 166, 121, 0.1);
        color: var(--color-forest);
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    .product-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        color: var(--color-charcoal);
        margin-bottom: 1rem;
        line-height: 1.1;
    }
    .product-price {
        font-size: 2rem;
        color: var(--color-forest);
        font-weight: 600;
        margin-bottom: 2rem;
    }
    .product-description {
        color: #666;
        line-height: 1.8;
        margin-bottom: 2.5rem;
        font-size: 1.1rem;
    }
    .rating-summary {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        color: var(--color-tan);
    }
    .rating-summary span {
        color: #888;
        font-weight: 400;
        margin-left: 0.5rem;
    }

    /* Comments Section */
    .comments-section {
        margin-top: 4rem;
    }
    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem;
        margin-bottom: 2rem;
        border-bottom: 2px solid var(--color-sage);
        padding-bottom: 0.5rem;
        display: inline-block;
    }
    .comment-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
    }
    .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .user-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .user-avatar {
        width: 40px;
        height: 40px;
        background: var(--color-forest);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
    .rating-stars {
        color: var(--color-tan);
    }

    /* Form */
    .comment-form-box {
        background: white;
        border-radius: 15px;
        padding: 2.5rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        margin-bottom: 3rem;
    }
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .star-rating input { display: none; }
    .star-rating label {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
        transition: color 0.2s;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: var(--color-tan);
    }

    @media (max-width: 992px) {
        .product-main { flex-direction: column; }
        .product-info-side { padding: 2rem; }
    }
</style>

<div class="product-detail-container">
    <div class="container">
        <div class="product-main">
            <div class="product-image-side">
                @if($product->hasImage())
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                @else
                    <div style="font-size: 10rem; color: #ddd;"><i class="bi bi-flower2"></i></div>
                @endif
            </div>
            <div class="product-info-side">
                <div>
                    <span class="category-badge">{{ $product->category ?: 'General' }}</span>
                </div>
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="rating-summary">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="bi {{ $i <= $averageRating ? 'bi-star-fill' : ($i - 0.5 <= $averageRating ? 'bi-star-half' : 'bi-star') }}"></i>
                    @endfor
                    <span>({{ $averageRating }} / 5)</span>
                </div>
                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                <p class="product-description">{{ $product->description }}</p>
                
                <div class="mt-auto">
                    <button class="eco-btn eco-btn--primary w-100" 
                            style="padding: 1.25rem; font-size: 1.1rem;"
                            onclick="addToCartFromWelcome({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->hasImage() ? $product->image_url : '' }}')">
                        <i class="bi bi-cart-plus-fill me-2"></i> {{ __('Agregar al Carrito') }}
                    </button>
                </div>
            </div>
        </div>

        <div class="comments-section">
            <h2 class="section-title">{{ __('Opiniones de clientes') }}</h2>

            @auth
                <div class="comment-form-box">
                    <h4 class="mb-4">{{ __('Deja tu comentario') }}</h4>
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="mb-3">
                            <label class="form-label d-block">{{ __('Tu calificación') }}</label>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="5 estrellas"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 estrellas"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 estrellas"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 estrellas"><i class="bi bi-star-fill"></i></label>
                                <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 estrella"><i class="bi bi-star-fill"></i></label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label">{{ __('Tu mensaje') }}</label>
                            <textarea name="content" id="content" rows="4" class="form-control" placeholder="{{ __('Cuéntanos tu experiencia...') }}" required minlength="5"></textarea>
                        </div>

                        <button type="submit" class="eco-btn eco-btn--primary">
                            <i class="bi bi-send-fill me-2"></i> {{ __('Publicar comentario') }}
                        </button>
                    </form>
                </div>
            @else
                <div class="alert alert-info border-0 shadow-sm mb-5" style="border-radius: 12px;">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    {{ __('Debes entrar a tu cuenta para dejar un comentario.') }} 
                    <a href="{{ route('login') }}" class="fw-bold text-decoration-none">{{ __('Iniciar sesión') }}</a>
                </div>
            @endauth

            <div class="comments-list">
                @forelse($comments as $comment)
                    <div class="comment-card">
                        <div class="comment-header">
                            <div class="user-info">
                                <div class="user-avatar">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $comment->user->name }}</h6>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $comment->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="comment-content">
                            <p class="mb-0">{{ $comment->content }}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-chat-left-text" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="mt-3 text-muted">{{ __('Aún no hay comentarios sobre este producto. ¡Sé el primero en opinar!') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
