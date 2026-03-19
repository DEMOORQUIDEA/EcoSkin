@extends('layouts.app')

@section('content')
<style>
    /* ===== PÁGINA DEL CARRITO — EcoSkin ===== */
    .cart-page {
        background: var(--color-cream);
        min-height: calc(100vh - 76px);
        padding: 3rem 0;
        margin: -1.5rem -0.75rem 0;
    }

    /* Encabezado */
    .cart-header-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 24px rgba(45,45,38,0.09);
        padding: 1.75rem 2.25rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .cart-header-left {
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .cart-header-icon {
        width: 58px;
        height: 58px;
        background: var(--color-forest);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(88,98,74,0.25);
        flex-shrink: 0;
    }

    .cart-header-icon i { font-size: 2rem; color: white; }

    .cart-header-text h2 {
        margin: 0;
        font-family: 'Cormorant Garamond', serif;
        font-weight: 500;
        color: var(--color-charcoal);
        font-size: 1.75rem;
        letter-spacing: 0.02em;
    }

    .cart-header-text p {
        margin: 0.3rem 0 0;
        color: var(--color-sage);
        font-size: 0.9rem;
        letter-spacing: 0.02em;
    }

    /* Botón Regresar */
    .btn-back {
        background: var(--color-cream);
        border: 1.5px solid rgba(162,165,141,0.4);
        border-radius: 50px;
        padding: 0.6rem 1.4rem;
        font-weight: 500;
        color: var(--color-charcoal);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        font-size: 0.88rem;
        letter-spacing: 0.03em;
    }

    .btn-back:hover {
        background: var(--color-charcoal);
        border-color: var(--color-charcoal);
        color: var(--color-cream);
        transform: translateX(-3px);
        text-decoration: none;
    }

    .btn-back i { font-size: 1.1rem; transition: transform 0.3s ease; }
    .btn-back:hover i { transform: translateX(-3px); }

    /* Grid principal */
    .cart-main-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 2rem;
        align-items: start;
    }

    @media (max-width: 992px) {
        .cart-main-grid { grid-template-columns: 1fr; }
    }

    /* Tarjeta de items */
    .cart-items-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
    }

    .cart-items-header {
        padding: 1.25rem 1.75rem;
        border-bottom: 2px solid #f0f4f8;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .cart-items-header h5 {
        margin: 0;
        font-weight: 700;
        color: #2d3748;
        font-size: 1.1rem;
    }

    .badge-count {
        background: var(--color-forest);
        color: var(--color-cream);
        border-radius: 50px;
        padding: 0.25rem 0.85rem;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.03em;
    }

    /* Cada item */
    .cart-item {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 1.25rem 1.75rem;
        border-bottom: 1px solid #f0f4f8;
        transition: all 0.3s ease;
        position: relative;
    }

    .cart-item:last-child { border-bottom: none; }
    .cart-item:hover { background: rgba(230,234,221,0.3); }

    .cart-item-img {
        width: 75px;
        height: 75px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }

    .cart-item-img-placeholder {
        width: 75px;
        height: 75px;
        background: var(--color-cream);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cart-item-img-placeholder i { font-size: 2rem; color: var(--color-sage); }

    .cart-item-info { flex: 1; min-width: 0; }

    .cart-item-name {
        font-weight: 600;
        font-family: 'Cormorant Garamond', serif;
        color: var(--color-charcoal);
        font-size: 1.05rem;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cart-item-unit-price { color: var(--color-sage); font-size: 0.82rem; }

    /* Controles de cantidad */
    .qty-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #f7fafc;
        border-radius: 10px;
        padding: 0.25rem;
        border: 2px solid #e2e8f0;
    }

    .btn-qty {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 8px;
        background: white;
        color: var(--color-forest);
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .btn-qty:hover {
        background: var(--color-forest);
        color: var(--color-cream);
        transform: scale(1.1);
        box-shadow: 0 3px 10px rgba(88,98,74,0.3);
    }

    .qty-value {
        min-width: 36px;
        text-align: center;
        font-weight: 600;
        color: var(--color-charcoal);
        font-size: 1rem;
    }

    /* Precio del item */
    .cart-item-price { text-align: right; min-width: 90px; }

    .cart-item-total {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 600;
        font-size: 1.2rem;
        color: var(--color-forest);
    }

    /* Botón eliminar */
    .btn-remove {
        background: none;
        border: 2px solid #fed7d7;
        border-radius: 8px;
        color: #e53e3e;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .btn-remove:hover {
        background: #e53e3e;
        border-color: #e53e3e;
        color: white;
        transform: scale(1.1);
        box-shadow: 0 3px 10px rgba(229,62,62,0.35);
    }

    /* Animación al eliminar */
    .cart-item.removing {
        animation: slideOutLeft 0.35s ease forwards;
        overflow: hidden;
    }

    @keyframes slideOutLeft {
        from { opacity: 1; transform: translateX(0); max-height: 120px; padding-top: 1.25rem; padding-bottom: 1.25rem; }
        to   { opacity: 0; transform: translateX(-30px); max-height: 0; padding-top: 0; padding-bottom: 0; }
    }

    /* Tarjeta resumen */
    .cart-summary-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        position: sticky;
        top: 20px;
    }

    .cart-summary-header {
        background: var(--color-charcoal);
        padding: 1.25rem 1.75rem;
    }

    .cart-summary-header h5 {
        margin: 0;
        color: var(--color-cream);
        font-family: 'Cormorant Garamond', serif;
        font-weight: 400;
        font-size: 1.2rem;
        letter-spacing: 0.04em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .cart-summary-body { padding: 1.5rem 1.75rem; }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
        color: #718096;
        font-size: 0.95rem;
    }

    .summary-row.total {
        border-top: 2px solid #e2e8f0;
        margin-top: 0.5rem;
        padding-top: 1rem;
        color: #2d3748;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .summary-total-amount {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--color-forest);
    }

    /* Botones de acción */
    .btn-checkout {
        display: block;
        width: 100%;
        background: var(--color-forest);
        border: none;
        border-radius: 50px;
        padding: 1rem;
        font-weight: 500;
        font-family: 'Jost', sans-serif;
        color: var(--color-cream);
        font-size: 0.95rem;
        letter-spacing: 0.04em;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(88,98,74,0.25);
        text-align: center;
        margin-bottom: 0.75rem;
    }

    .btn-checkout:hover {
        background: var(--color-charcoal);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(45,45,38,0.25);
        color: var(--color-cream);
    }

    .btn-clear-cart {
        display: block;
        width: 100%;
        background: white;
        border: 1.5px solid rgba(162,165,141,0.4);
        border-radius: 50px;
        padding: 0.7rem;
        font-weight: 500;
        font-family: 'Jost', sans-serif;
        color: var(--color-sage);
        font-size: 0.88rem;
        letter-spacing: 0.03em;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .btn-clear-cart:hover {
        background: var(--color-cream);
        border-color: var(--color-sage);
        color: var(--color-charcoal);
        transform: translateY(-1px);
    }

    /* Estado vacío */
    .cart-empty {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        padding: 4rem 2rem;
        text-align: center;
    }

    .cart-empty-icon {
        width: 110px;
        height: 110px;
        background: linear-gradient(135deg, #f5f7fa 0%, #e2e8f0 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        animation: floatEmpty 3s ease-in-out infinite;
    }

    @keyframes floatEmpty {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-10px); }
    }

    .cart-empty-icon i { font-size: 3.5rem; color: #a0aec0; }
    .cart-empty h4 { 
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem;
        color: var(--color-charcoal); 
        font-weight: 500; 
        margin-bottom: 0.75rem; 
    }
    .cart-empty p { color: var(--color-sage); margin-bottom: 2rem; font-size: 1rem; }

    .btn-go-shop {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--color-forest);
        border: none;
        border-radius: 50px;
        padding: 0.9rem 2rem;
        font-weight: 500;
        font-family: 'Jost', sans-serif;
        color: var(--color-cream);
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 14px rgba(88,98,74,0.3);
        letter-spacing: 0.04em;
        font-size: 0.93rem;
    }

    .btn-go-shop:hover {
        background: var(--color-charcoal);
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(45,45,38,0.3);
        color: var(--color-cream);
        text-decoration: none;
    }

    /* Toast del carrito */
    .cart-page-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        background: var(--color-forest);
        color: var(--color-cream);
        border-radius: 50px;
        padding: 0.85rem 1.5rem;
        font-weight: 500;
        box-shadow: 0 8px 30px rgba(88,98,74,0.4);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: cpToastIn 0.4s ease;
        font-size: 0.9rem;
        letter-spacing: 0.02em;
    }

    .cart-page-toast.danger {
        background: #b04a3a;
        box-shadow: 0 8px 30px rgba(176,74,58,0.3);
    }

    @keyframes cpToastIn {
        from { opacity: 0; transform: translateY(20px) scale(0.95); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cart-page { padding: 1.5rem 0; }
        .cart-header-card { padding: 1.25rem; flex-direction: column; align-items: flex-start; }
        .cart-item { flex-wrap: wrap; gap: 0.75rem; }
        .cart-item-price { min-width: auto; }
    }
</style>

<div class="cart-page">
    <div class="container">

        {{-- Encabezado --}}
        <div class="cart-header-card">
            <div class="cart-header-left">
                <div class="cart-header-icon">
                    <i class="bi bi-cart3"></i>
                </div>
                <div class="cart-header-text">
                    <h2>Mi Carrito de Compras</h2>
                    <p id="cartHeaderSubtitle">Cargando productos...</p>
                </div>
            </div>
            <a href="{{ route('home') }}" class="btn-back">
                <i class="bi bi-arrow-left-circle-fill"></i>
                Regresar al Catálogo
            </a>
        </div>

        {{-- Contenido dinámico --}}
        <div id="cartPageContent"></div>

    </div>
</div>

<script>
/**
 * MÓDULO DEL CARRITO — cart/index.blade.php
 *
 * IMPORTANTE: usamos nombres de función con prefijo "cp_" (cart page)
 * para NO colisionar con getCart() / saveCart() / renderCart() que
 * están definidas en layouts/app.blade.php y se cargan DESPUÉS de esta
 * vista, sobreescribiendo cualquier función con el mismo nombre.
 *
 * Todas las operaciones de persistencia leen/escriben localStorage
 * directamente, sin depender de las funciones del layout.
 */

// ── Helpers locales ────────────────────────────────────────────────
function cp_getCartKey() {
    @auth
        return 'cart_{{ Auth::id() }}';
    @endauth
    return 'cart_guest';
}

function cp_readCart() {
    try {
        const cartKey = cp_getCartKey();
        return JSON.parse(localStorage.getItem(cartKey) || '[]');
    } catch(e) {
        return [];
    }
}

function cp_writeCart(cart) {
    const cartKey = cp_getCartKey();
    localStorage.setItem(cartKey, JSON.stringify(cart));
    // Actualizar badge del navbar (función del layout, disponible en runtime)
    if (typeof updateCartCount === 'function') updateCartCount();
}

function cp_calcTotal(cart) {
    return cart.reduce(function(sum, i) { return sum + i.price * i.quantity; }, 0);
}

// ── Cambiar cantidad (+/-) ─────────────────────────────────────────
function cp_changeQty(productId, delta) {
    var cart = cp_readCart();
    var item = cart.find(function(i) { return i.id === productId; });
    if (!item) return;

    item.quantity += delta;

    if (item.quantity <= 0) {
        cp_removeItem(productId);
    } else {
        cp_writeCart(cart);
        cp_renderPage();
        cp_toast('Cantidad actualizada', 'success');
    }
}

// ── Eliminar producto ──────────────────────────────────────────────
function cp_removeItem(productId) {
    var row = document.getElementById('cp-item-' + productId);

    function doRemove() {
        var cart = cp_readCart().filter(function(i) { return i.id !== productId; });
        cp_writeCart(cart);
        cp_renderPage();
        cp_toast('Producto eliminado', 'danger');
    }

    if (row) {
        row.classList.add('removing');
        setTimeout(doRemove, 350);
    } else {
        doRemove();
    }
}

// ── Vaciar carrito ─────────────────────────────────────────────────
function cp_clearCart() {
    if (!confirm('¿Estás seguro de que deseas vaciar todo el carrito?')) return;
    localStorage.removeItem(cp_getCartKey());
    if (typeof updateCartCount === 'function') updateCartCount();
    cp_renderPage();
    cp_toast('Carrito vaciado', 'danger');
}

// ── Checkout (placeholder) ─────────────────────────────────────────
function cp_checkout() {
    var cart = cp_readCart();
    if (cart.length === 0) { cp_toast('Tu carrito está vacío', 'danger'); return; }
    window.location.href = "{{ route('checkout.index') }}";
}


// ── Renderizar toda la página ──────────────────────────────────────
function cp_renderPage() {
    var cart      = cp_readCart();
    var container = document.getElementById('cartPageContent');
    var subtitle  = document.getElementById('cartHeaderSubtitle');
    if (!container || !subtitle) return;

    var totalItems = cart.reduce(function(s, i) { return s + i.quantity; }, 0);
    subtitle.textContent = totalItems > 0
        ? totalItems + ' artículo' + (totalItems !== 1 ? 's' : '') + ' en tu carrito'
        : 'Tu carrito está vacío';

    // ── Estado vacío ───────────────────────────────────────────────
    if (cart.length === 0) {
        container.innerHTML =
            '<div class="cart-empty">' +
                '<div class="cart-empty-icon"><i class="bi bi-cart-x"></i></div>' +
                '<h4>¡Tu carrito está vacío!</h4>' +
                '<p>Explora nuestro catálogo y agrega los productos que más te gusten.</p>' +
                '<a href="{{ route('home') }}" class="btn-go-shop">' +
                    '<i class="bi bi-bag-heart-fill"></i> Ir al Catálogo' +
                '</a>' +
            '</div>';
        return;
    }

    // ── Lista de productos ─────────────────────────────────────────
    var total    = cp_calcTotal(cart);
    var itemsHtml = '';

    cart.forEach(function(item) {
        var itemTotal = item.price * item.quantity;
        var imgHtml   = item.image
            ? '<img src="' + item.image + '" alt="' + item.name + '" class="cart-item-img">'
            : '<div class="cart-item-img-placeholder"><i class="bi bi-image"></i></div>';

        itemsHtml +=
            '<div class="cart-item" id="cp-item-' + item.id + '">' +
                imgHtml +
                '<div class="cart-item-info">' +
                    '<div class="cart-item-name">' + item.name + '</div>' +
                    '<div class="cart-item-unit-price">$' + item.price.toFixed(2) + ' por unidad</div>' +
                '</div>' +
                '<div class="qty-controls">' +
                    '<button class="btn-qty" onclick="cp_changeQty(' + item.id + ', -1)" title="Reducir cantidad">' +
                        '<i class="bi bi-dash"></i>' +
                    '</button>' +
                    '<span class="qty-value">' + item.quantity + '</span>' +
                    '<button class="btn-qty" onclick="cp_changeQty(' + item.id + ', 1)" title="Aumentar cantidad">' +
                        '<i class="bi bi-plus"></i>' +
                    '</button>' +
                '</div>' +
                '<div class="cart-item-price">' +
                    '<div class="cart-item-total">$' + itemTotal.toFixed(2) + '</div>' +
                '</div>' +
                '<button class="btn-remove" onclick="cp_removeItem(' + item.id + ')" title="Eliminar producto">' +
                    '<i class="bi bi-trash3-fill"></i>' +
                '</button>' +
            '</div>';
    });

    var plural = cart.length !== 1 ? 's' : '';
    var plural2 = totalItems !== 1 ? 's' : '';

    container.innerHTML =
        '<div class="cart-main-grid">' +
            // Panel izquierdo
            '<div class="cart-items-card">' +
                '<div class="cart-items-header">' +
                    '<h5><i class="bi bi-list-check me-2"></i>Productos</h5>' +
                    '<span class="badge-count">' + cart.length + ' producto' + plural + '</span>' +
                '</div>' +
                itemsHtml +
            '</div>' +
            // Panel derecho — Resumen
            '<div class="cart-summary-card">' +
                '<div class="cart-summary-header">' +
                    '<h5><i class="bi bi-receipt"></i> Resumen del Pedido</h5>' +
                '</div>' +
                '<div class="cart-summary-body">' +
                    '<div class="summary-row">' +
                        '<span>Subtotal (' + totalItems + ' artículo' + plural2 + ')</span>' +
                        '<span>$' + total.toFixed(2) + '</span>' +
                    '</div>' +
                    '<div class="summary-row">' +
                        '<span>Envío</span>' +
                        '<span class="text-success fw-bold">Gratis</span>' +
                    '</div>' +
                    '<div class="summary-row total">' +
                        '<span>Total</span>' +
                        '<span class="summary-total-amount">$' + total.toFixed(2) + '</span>' +
                    '</div>' +
                    '<div style="margin-top:1.5rem;">' +
                        '<button class="btn-checkout" onclick="cp_checkout()">' +
                            '<i class="bi bi-credit-card-fill me-2"></i>Proceder al Pago' +
                        '</button>' +
                        '<button class="btn-clear-cart" onclick="cp_clearCart()">' +
                            '<i class="bi bi-trash3 me-2"></i>Vaciar Carrito' +
                        '</button>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';
}

// ── Toast de feedback ──────────────────────────────────────────────
var _cpToastTimer;
function cp_toast(msg, type) {
    var old = document.getElementById('cp-toast');
    if (old) old.remove();
    clearTimeout(_cpToastTimer);

    var t = document.createElement('div');
    t.id        = 'cp-toast';
    t.className = 'cart-page-toast' + (type === 'danger' ? ' danger' : '');
    var icon    = type === 'danger' ? 'bi-x-circle-fill' : 'bi-check-circle-fill';
    t.innerHTML = '<i class="bi ' + icon + '"></i> ' + msg;
    document.body.appendChild(t);

    _cpToastTimer = setTimeout(function() {
        t.style.transition = 'opacity 0.3s ease';
        t.style.opacity    = '0';
        setTimeout(function() { t.remove(); }, 300);
    }, 2500);
}

// ── Arrancar ───────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    cp_renderPage();
});
</script>
@endsection
