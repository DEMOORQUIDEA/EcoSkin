@extends('layouts.app')

@section('content')

{{-- ====================================================
     ECOSKIN — Página de bienvenida / catálogo público
     Paleta Ecológica: #EBF2E8 · #8DB600 · #8F9D7D · #48633F · #1B2B1B
==================================================== --}}

<!-- ╔══ HERO MINIMALISTA ══════════════════════════════════════════════════════╗ -->
<section class="eco-hero">
    <!-- Decoradores orgánicos suaves -->
    <div class="eco-hero__bg-circle eco-hero__bg-circle--1"></div>
    <div class="eco-hero__bg-circle eco-hero__bg-circle--2"></div>

    <div class="container eco-hero__inner">
        <div class="eco-hero__content">
            <span class="eco-hero__tag">
                <i class="bi bi-flower1 me-1"></i> 100% Natural &amp; Orgánico
            </span>
            <h1 class="eco-hero__title">
                Tu piel en armonía<br>
                <em>con la botánica</em>
            </h1>
            <p class="eco-hero__subtitle">
                {{ __('Descubre la pureza de lo natural. Cosmética premium, formulada para respetar tu piel y cuidar nuestro planeta.') }}
            </p>
            <div class="eco-hero__badges">
                <span class="eco-badge"><i class="bi bi-leaf-fill me-1"></i>{{ __('Sin químicos dañinos') }}</span>
                <span class="eco-badge"><i class="bi bi-heart-fill me-1"></i>{{ __('Cruelty-free') }}</span>
                <span class="eco-badge"><i class="bi bi-recycle me-1"></i>{{ __('Eco-packaging') }}</span>
            </div>
        </div>
        <div class="eco-hero__visual d-none d-lg-flex">
            <!-- Imagen generada de cosmética natural -->
            <div class="eco-hero__visual-circle" style="background: transparent; border: none; box-shadow: none;">
                <img src="{{ asset('img/natural_hero.png') }}" alt="Cosmética Natural" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; box-shadow: 0 20px 50px rgba(0,0,0,0.15);">
            </div>
        </div>
    </div>
</section>

<!-- ╔══ SEARCH ════════════════════════════════════════════════════╗ -->
<div class="eco-search-wrap">
    <div class="container">
        <form method="GET" action="{{ route('welcome') }}" id="searchForm">
            <div class="eco-search">
                <i class="bi bi-search eco-search__icon"></i>
                <input type="text"
                       name="search"
                       id="searchInput"
                       class="eco-search__input"
                       placeholder="Buscar productos naturales…"
                       value="{{ $search }}"
                       autocomplete="off">
                @if($search)
                    <a href="{{ route('welcome') }}" class="eco-search__clear" title="Limpiar">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
                <button type="submit" class="eco-search__btn">
                    <i class="bi bi-search me-1"></i> {{ __('Search') }}
                </button>
            </div>
            @if($search)
                <p class="eco-search__hint">
                    <i class="bi bi-filter-circle me-1"></i>
                    Resultados para "<strong>{{ $search }}</strong>": {{ $products->total() }} producto(s)
                </p>
            @else
                <p class="eco-search__hint">
                    <i class="bi bi-info-circle me-1"></i> Búsqueda automática desde 3 caracteres
                </p>
            @endif
        </form>
    </div>
</div>

<!-- ╔══ STATS BAR ═════════════════════════════════════════════════╗ -->
<div class="eco-stats-bar">
    <div class="container">
        <div class="eco-stats">
            <div class="eco-stat">
                <i class="bi bi-box-seam"></i>
                <div>
                    <strong id="productCounter">{{ $products->total() }}</strong>
                    <span>{{ $search ? 'Encontrados' : 'Productos' }}</span>
                </div>
            </div>
            <div class="eco-stat-divider"></div>
            <div class="eco-stat">
                <i class="bi bi-truck"></i>
                <div>
                    <strong>Gratis</strong>
                    <span>Envío rápido</span>
                </div>
            </div>
            <div class="eco-stat-divider"></div>
            <div class="eco-stat">
                <i class="bi bi-shield-check"></i>
                <div>
                    <strong>100%</strong>
                    <span>Ingredientes naturales</span>
                </div>
            </div>
            <div class="eco-stat-divider"></div>
            <div class="eco-stat">
                <i class="bi bi-award"></i>
                <div>
                    <strong>4.9 ★</strong>
                    <span>Valoración</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ╔══ PRODUCTS ══════════════════════════════════════════════════╗ -->
<section class="eco-catalog">
    <div class="container">

        <!-- Cabecera de sección -->
        <div class="eco-section-heading">
            <span class="eco-section-heading__line"></span>
            <h2 class="eco-section-heading__title">
                @if($search)
                    <i class="bi bi-search me-2"></i>Resultados de búsqueda
                @elseif(isset($currentCategory) && !empty($currentCategory))
                    @switch($currentCategory)
                        @case('Jabones')
                            Jabones Artesanales: <span class="text-tan">Limpieza que Nutre</span>
                            @break
                        @case('Mascarillas en polvo')
                            Mascarillas Botánicas: <span class="text-tan">El Poder del Polvo</span>
                            @break
                        @case('Bálsamos')
                            Bálsamos Hidratantes: <span class="text-tan">Caricia de la Naturaleza</span>
                            @break
                        @case('Cremas faciales')
                            Cuidado Facial: <span class="text-tan">Revela tu Brillo Natural</span>
                            @break
                        @case('Cremas corporales')
                            Cuidado Corporal: <span class="text-tan">Suavidad que Perdura</span>
                            @break
                        @default
                            Sección {{ $currentCategory }}: <span class="text-tan">Lo Natural</span>
                    @endswitch
                @else
                    Nuestros Productos: <span class="text-tan">Esencia Natural</span>
                @endif
            </h2>
            <span class="eco-section-heading__line"></span>
        </div>

        @if($products->count() > 0)
            <div class="eco-grid" id="productsGrid">
                @foreach($products as $product)
                    <div class="eco-card product-item">

                        <a href="{{ route('products.show', $product) }}" class="eco-card__img-link">
                            <div class="eco-card__img-wrap">
                                @if($product->hasImage())
                                    <img src="{{ $product->image_url }}"
                                        alt="{{ $product->name }}"
                                        class="eco-card__img">
                                @else
                                    <div class="eco-card__img-placeholder">
                                        <i class="bi bi-flower2"></i>
                                    </div>
                                @endif

                                <!-- Badge natural -->
                                <span class="eco-card__badge">Natural</span>

                                <!-- Botón favorito -->
                                <button class="eco-card__fav" onclick="toggleFavorite(this, event)" title="Favorito">
                                    <i class="bi bi-heart"></i>
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

                            <!-- Estrellas -->
                            <div class="eco-card__stars">
                                @php
                                    $rating = $product->comments_avg_rating ?: 0;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $rating ? 'bi-star-fill' : ($i - 0.5 <= $rating ? 'bi-star-half' : 'bi-star') }}"></i>
                                @endfor
                                <small>({{ number_format($rating, 1) }})</small>
                            </div>

                            <!-- Precio -->
                            <div class="eco-card__footer">
                                <div class="eco-card__price-block">
                                    <span class="eco-card__price-old">${{ number_format($product->price * 1.15, 2) }}</span>
                                    <span class="eco-card__price">${{ number_format($product->price, 2) }}</span>
                                </div>
                                <button class="eco-card__btn-cart"
                                        onclick="addToCartFromWelcome({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->hasImage() ? $product->image_url : '' }}')">
                                    <i class="bi bi-cart-plus-fill"></i>
                                    <span>{{ __('Agregar') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="eco-pagination-wrap">
                {{ $products->links('vendor.pagination.custom') }}
            </div>

        @else
            <!-- Empty State -->
            <div class="eco-empty">
                <div class="eco-empty__icon">
                    <i class="bi bi-search"></i>
                </div>
                <h4>Sin resultados para "{{ $search }}"</h4>
                <p>Intenta con otras palabras clave o explora todo nuestro catálogo.</p>
                <a href="{{ route('welcome') }}" class="eco-btn eco-btn--primary">
                    <i class="bi bi-arrow-counterclockwise me-2"></i>Ver todos los productos
                </a>
            </div>
        @endif
    </div>
</section>

<!-- ╔══ CARACTERÍSTICAS ════════════════════════════════════════════╗ -->
<section class="eco-features">
    <div class="container">
        <div class="eco-features__grid">
            <div class="eco-feature">
                <div class="eco-feature__icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h5>Ingredientes seguros</h5>
                <p>Formulaciones dermatológicamente probadas, sin sulfatos ni parabenos.</p>
            </div>
            <div class="eco-feature">
                <div class="eco-feature__icon">
                    <i class="bi bi-truck"></i>
                </div>
                <h5>Envío rápido</h5>
                <p>Recibe tu pedido en casa. Envío gratis en compras mayores a $500.</p>
            </div>
            <div class="eco-feature">
                <div class="eco-feature__icon">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
                <h5>30 días de garantía</h5>
                <p>Si no estás satisfecha, te devolvemos tu dinero sin preguntas.</p>
            </div>
            <div class="eco-feature">
                <div class="eco-feature__icon">
                    <i class="bi bi-leaf"></i>
                </div>
                <h5>Eco-friendly</h5>
                <p>Empaques biodegradables y compromiso con el medio ambiente.</p>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
/* ══════════════════════════════════════════════════════════════
   ECOSKIN — Estilos de la página de bienvenida
   Paleta Ecológica: #EBF2E8 · #8DB600 · #8F9D7D · #48633F · #1B2B1B
══════════════════════════════════════════════════════════════ */

.text-tan { color: var(--color-tan) !important; }

/* ── HERO MINIMALISTA ─────────────────────────────────────── */
.eco-hero {
    position: relative;
    background: #EBF2EB; /* Minimalist soft green background */
    overflow: hidden;
    padding: 6rem 0 5rem;
    margin: -1.5rem -0.75rem 0;
    border-bottom: 1px solid var(--color-border);
}

.eco-hero__bg-circle {
    position: absolute;
    border-radius: 50%;
    opacity: 0.2;
    background: var(--color-cream);
    pointer-events: none;
}
.eco-hero__bg-circle--1 {
    width: 600px; height: 600px;
    top: -200px; right: -100px;
    background: radial-gradient(circle, rgba(130, 157, 100, 0.08) 0%, rgba(255,255,255,0) 70%);
}
.eco-hero__bg-circle--2 {
    width: 300px; height: 300px;
    bottom: -80px; left: -60px;
    background: radial-gradient(circle, rgba(138, 146, 134, 0.06) 0%, rgba(255,255,255,0) 70%);
    opacity: 0.8;
}

.eco-hero__inner {
    display: flex;
    align-items: center;
    gap: 4rem;
    position: relative;
    z-index: 1;
}

.eco-hero__content {
    flex: 1;
}

.eco-hero__tag {
    display: inline-flex;
    align-items: center;
    background: rgba(130, 157, 100, 0.08); /* Verde claro */
    color: var(--color-forest);
    border: 1px solid rgba(130, 157, 100, 0.2);
    border-radius: 50px;
    padding: 0.4rem 1.1rem;
    font-size: 0.8rem;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.eco-hero__title {
    font-family: 'Cormorant Garamond', serif;
    font-weight: 400;
    font-size: clamp(2.5rem, 5vw, 4rem);
    color: var(--color-charcoal);
    line-height: 1.15;
    margin-bottom: 1.25rem;
}
.eco-hero__title em {
    font-style: italic;
    color: var(--color-tan);
}

.eco-hero__subtitle {
    color: var(--color-sage);
    font-size: 1.1rem;
    line-height: 1.7;
    max-width: 480px;
    margin-bottom: 2rem;
    font-weight: 300;
}

.eco-hero__badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
}

.eco-badge {
    background: var(--color-cream);
    border: 1px solid var(--color-border);
    color: var(--color-forest);
    border-radius: 50px;
    padding: 0.4rem 1.1rem;
    font-size: 0.8rem;
    letter-spacing: 0.03em;
    transition: all 0.3s ease;
}
.eco-badge:hover {
    background: rgba(130, 157, 100, 0.05);
    border-color: var(--color-tan);
}

/* Visual decorativo */
.eco-hero__visual {
    position: relative;
    width: 320px;
    height: 320px;
    flex-shrink: 0;
    align-items: center;
    justify-content: center;
}

.eco-hero__visual-circle {
    width: 280px;
    height: 280px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: ecoFloat 6s ease-in-out infinite;
}

@keyframes ecoFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}

/* ── BÚSQUEDA MINIMALISTA ────────────── */

/* ── SEARCH ───────────────────────────────────────────────── */
.eco-search-wrap {
    background: white;
    padding: 1.5rem 0 1rem;
    box-shadow: 0 4px 20px rgba(45,45,38,0.08);
    position: sticky;
    top: 0;
    z-index: 800;
}

.eco-search {
    display: flex;
    align-items: center;
    background: var(--color-cream);
    border: 1.5px solid rgba(162,165,141,0.4);
    border-radius: 50px;
    padding: 0.2rem 0.3rem 0.2rem 1.1rem;
    gap: 0.6rem;
    max-width: 620px;
    margin: 0 auto;
    transition: all 0.4s ease;
}
.eco-search:focus-within {
    border-color: var(--color-sage);
    box-shadow: 0 0 0 3px rgba(162,165,141,0.18);
}

.eco-search__icon {
    color: var(--color-sage);
    font-size: 1.1rem;
    flex-shrink: 0;
}

.eco-search__input {
    flex: 1;
    border: none;
    background: transparent;
    font-family: 'Jost', sans-serif;
    font-size: 0.98rem;
    color: var(--color-charcoal);
    outline: none;
}
.eco-search__input::placeholder { color: var(--color-sage); }

.eco-search__clear {
    color: var(--color-sage);
    display: flex;
    align-items: center;
    text-decoration: none;
    transition: color 0.2s;
}
.eco-search__clear:hover { color: var(--color-charcoal); }

.eco-search__btn {
    background: var(--color-forest);
    color: var(--color-cream);
    border: none;
    border-radius: 50px;
    padding: 0.5rem 1.25rem;
    font-family: 'Jost', sans-serif;
    font-size: 0.82rem;
    font-weight: 500;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.3s;
    flex-shrink: 0;
}
.eco-search__btn:hover {
    background: var(--color-charcoal);
    transform: translateY(-1px);
}

.eco-search__hint {
    text-align: center;
    color: var(--color-sage);
    font-size: 0.82rem;
    margin: 0.6rem 0 0;
    letter-spacing: 0.02em;
}
.eco-search__hint strong { color: var(--color-tan); }

/* ── STATS BAR MINIMALISTA ────────────────────────────────────────────── */
.eco-stats-bar {
    background: var(--color-surface);
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--color-border);
}

.eco-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 0.5rem 2.5rem;
}

.eco-stat {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: var(--color-charcoal);
}
.eco-stat i {
    font-size: 1.3rem;
    color: var(--color-tan);
    background: rgba(130, 157, 100, 0.1);
    width: 40px; height: 40px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}
.eco-stat strong {
    display: block;
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.25rem;
    line-height: 1;
    font-weight: 600;
}
.eco-stat span {
    font-size: 0.75rem;
    color: var(--color-sage);
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
.eco-stat-divider {
    width: 1px;
    height: 40px;
    background: var(--color-border);
}

/* ── CATALOG ──────────────────────────────────────────────── */
.eco-catalog {
    padding: 4rem 0 3rem;
}

.eco-section-heading {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    margin-bottom: 2.5rem;
}
.eco-section-heading__line {
    flex: 1;
    height: 1px;
    background: rgba(162,165,141,0.35);
}
.eco-section-heading__title {
    font-family: 'Cormorant Garamond', serif;
    font-weight: 500;
    font-size: 1.9rem;
    color: var(--color-charcoal);
    white-space: nowrap;
    letter-spacing: 0.02em;
}

/* Grid */
.eco-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 1.75rem;
}

/* Card */
.eco-card {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(45,45,38,0.06);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    animation: ecoFadeUp 0.5s ease forwards;
    opacity: 0;
    display: flex;
    flex-direction: column;
}
.eco-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 32px rgba(45,45,38,0.12);
}

.eco-card__img-wrap {
    position: relative;
    height: 220px;
    background: var(--color-cream);
    overflow: hidden;
}
.eco-card__img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}
.eco-card:hover .eco-card__img { transform: scale(1.06); }

.eco-card__img-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 4rem;
    color: var(--color-sage);
    opacity: 0.5;
    background: linear-gradient(135deg, var(--color-cream) 0%, #d8ddd2 100%);
}

.eco-card__badge {
    position: absolute;
    top: 12px; left: 12px;
    background: var(--color-forest);
    color: var(--color-cream);
    font-size: 0.7rem;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 0.25rem 0.7rem;
    border-radius: 50px;
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
    font-size: 0.95rem;
    color: var(--color-sage);
    backdrop-filter: blur(4px);
    transition: all 0.25s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.eco-card__fav:hover { color: #c0392b; transform: scale(1.1); }
.eco-card__fav.active { color: #c0392b; }

.eco-card__body {
    padding: 1.25rem 1.25rem 1.1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.eco-card__name {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.15rem;
    font-weight: 600;
    color: var(--color-charcoal);
    margin-bottom: 0.4rem;
    line-height: 1.3;
}

.eco-card__desc {
    font-size: 0.82rem;
    color: var(--color-sage);
    line-height: 1.5;
    margin-bottom: 0.75rem;
    flex: 1;
}

.eco-card__stars {
    color: var(--color-tan);
    font-size: 0.78rem;
    margin-bottom: 1rem;
}
.eco-card__stars small { color: var(--color-sage); margin-left: 0.25rem; }

.eco-card__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    border-top: 1px solid rgba(162,165,141,0.2);
    padding-top: 0.9rem;
}

.eco-card__price-block { display: flex; flex-direction: column; }
.eco-card__price-old {
    font-size: 0.78rem;
    color: var(--color-sage);
    text-decoration: line-through;
    line-height: 1;
}
.eco-card__price {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.35rem;
    font-weight: 600;
    color: var(--color-forest);
    line-height: 1;
}

.eco-card__btn-cart {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    background: var(--color-forest);
    color: var(--color-cream);
    border: none;
    border-radius: 50px;
    padding: 0.55rem 1.1rem;
    font-family: 'Jost', sans-serif;
    font-size: 0.82rem;
    font-weight: 500;
    letter-spacing: 0.03em;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    white-space: nowrap;
}
.eco-card__btn-cart:hover {
    background: var(--color-charcoal);
    transform: translateY(-1px);
}

/* ── EMPTY STATE ──────────────────────────────────────────── */
.eco-empty {
    text-align: center;
    padding: 5rem 2rem;
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(45,45,38,0.07);
}
.eco-empty__icon {
    width: 90px; height: 90px;
    background: var(--color-cream);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
    color: var(--color-sage);
    border: 2px solid rgba(162,165,141,0.3);
}
.eco-empty h4 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.6rem;
    color: var(--color-charcoal);
    margin-bottom: 0.5rem;
}
.eco-empty p { color: var(--color-sage); margin-bottom: 1.5rem; }

/* ── GENERIC BTN ──────────────────────────────────────────── */
.eco-btn {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 2rem;
    border-radius: 50px;
    font-family: 'Jost', sans-serif;
    font-weight: 500;
    font-size: 0.9rem;
    letter-spacing: 0.04em;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
}
.eco-btn--primary {
    background: var(--color-forest);
    color: var(--color-cream);
}
.eco-btn--primary:hover {
    background: var(--color-charcoal);
    color: var(--color-cream);
    transform: translateY(-2px);
}

/* ── PAGINATION ───────────────────────────────────────────── */
.eco-pagination-wrap { margin-top: 3rem; }

/* ── FEATURES ─────────────────────────────────────────────── */
.eco-features {
    background: var(--color-charcoal);
    padding: 4rem 0;
}

.eco-features__grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2.5rem;
    text-align: center;
}

.eco-feature__icon {
    width: 60px; height: 60px;
    background: rgba(186,155,114,0.15);
    border: 1.5px solid rgba(186,155,114,0.3);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1.1rem;
    font-size: 1.5rem;
    color: var(--color-tan);
    transition: background 0.3s;
}
.eco-feature:hover .eco-feature__icon {
    background: rgba(186,155,114,0.25);
}

.eco-feature h5 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.2rem;
    color: var(--color-cream);
    margin-bottom: 0.5rem;
}
.eco-feature p {
    font-size: 0.85rem;
    color: rgba(230,234,221,0.6);
    line-height: 1.6;
    margin: 0;
}

/* ── ANIMATIONS ───────────────────────────────────────────── */
@keyframes ecoFadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.product-item:nth-child(1)  { animation-delay: 0.05s; }
.product-item:nth-child(2)  { animation-delay: 0.1s; }
.product-item:nth-child(3)  { animation-delay: 0.15s; }
.product-item:nth-child(4)  { animation-delay: 0.2s; }
.product-item:nth-child(5)  { animation-delay: 0.25s; }
.product-item:nth-child(6)  { animation-delay: 0.3s; }
.product-item:nth-child(7)  { animation-delay: 0.35s; }
.product-item:nth-child(8)  { animation-delay: 0.4s; }

/* ── RESPONSIVE ───────────────────────────────────────────── */
@media (max-width: 768px) {
    .eco-hero { padding: 3.5rem 0 3rem; }
    .eco-hero__title { font-size: 2.4rem; }
    .eco-stats { gap: 0.5rem 1.25rem; }
    .eco-stat-divider { display: none; }
    .eco-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 1rem; }
    .eco-card__img-wrap { height: 180px; }
}
</style>
@endpush

@push('scripts')
<script>


// ── Búsqueda automática ────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchForm  = document.getElementById('searchForm');
    let searchTimeout;

    if (!searchInput) return;

    searchInput.addEventListener('input', function() {
        const val = this.value.trim();
        clearTimeout(searchTimeout);

        if (val.length === 0) {
            searchTimeout = setTimeout(() => searchForm.submit(), 500);
        } else if (val.length >= 3) {
            searchTimeout = setTimeout(() => searchForm.submit(), 700);
        }
    });
});

// ── Añadir al carrito (pública) ───────────────────────────────────
function addToCartFromWelcome(productId, productName, productPrice, productImage) {
    @guest
        if (confirm('Debes iniciar sesión para añadir al carrito. ¿Deseas ir al login?')) {
            window.location.href = "{{ route('login') }}";
        }
        return false;
    @endguest

    const btn = event.target.closest('.eco-card__btn-cart');
    const original = btn.innerHTML;

    if (typeof addToCart === 'function') {
        const result = addToCart(productId, productName, productPrice, productImage);
        if (!result) return;
    }

    btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> <span>¡Listo!</span>';
    btn.style.background = 'var(--color-sage)';
    btn.disabled = true;

    setTimeout(() => {
        btn.innerHTML = original;
        btn.style.background = '';
        btn.disabled = false;
    }, 2000);
}

// ── Favorito ──────────────────────────────────────────────────────
function toggleFavorite(btn, event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }
    btn.classList.toggle('active');
    const icon = btn.querySelector('i');
    if (btn.classList.contains('active')) {
        icon.classList.replace('bi-heart', 'bi-heart-fill');
    } else {
        icon.classList.replace('bi-heart-fill', 'bi-heart');
    }
}
</script>
@endpush
