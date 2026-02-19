@extends('layouts.app')

@section('content')
<style>
    /* ===== PÁGINA DEL CARRITO ===== */
    .cart-page {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 76px);
        padding: 3rem 0;
        margin: -1.5rem -0.75rem 0;
    }

    /* Encabezado */
    .cart-header-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.12);
        padding: 2rem 2.5rem;
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
        width: 65px;
        height: 65px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(102,126,234,0.35);
        flex-shrink: 0;
    }

    .cart-header-icon i { font-size: 2rem; color: white; }

    .cart-header-text h2 {
        margin: 0;
        font-weight: 700;
        color: #2d3748;
        font-size: 1.75rem;
    }

    .cart-header-text p {
        margin: 0.3rem 0 0;
        color: #718096;
        font-size: 0.95rem;
    }

    /* Botón Regresar */
    .btn-back {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102,126,234,0.35);
        font-size: 0.95rem;
    }

    .btn-back:hover {
        transform: translateX(-4px);
        box-shadow: 0 6px 18px rgba(102,126,234,0.45);
        color: white;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        padding: 0.25rem 0.85rem;
        font-size: 0.85rem;
        font-weight: 700;
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
    .cart-item:hover { background: #fafbff; }

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
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .cart-item-img-placeholder i { font-size: 2rem; color: #a0aec0; }

    .cart-item-info { flex: 1; min-width: 0; }

    .cart-item-name {
        font-weight: 700;
        color: #2d3748;
        font-size: 1rem;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cart-item-unit-price { color: #a0aec0; font-size: 0.85rem; }

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
        color: #667eea;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .btn-qty:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: scale(1.1);
        box-shadow: 0 3px 10px rgba(102,126,234,0.35);
    }

    .qty-value {
        min-width: 36px;
        text-align: center;
        font-weight: 700;
        color: #2d3748;
        font-size: 1rem;
    }

    /* Precio del item */
    .cart-item-price { text-align: right; min-width: 90px; }

    .cart-item-total {
        font-weight: 700;
        font-size: 1.15rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
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
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 1.25rem 1.75rem;
    }

    .cart-summary-header h5 {
        margin: 0;
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
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
        font-size: 1.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Botones de acción */
    .btn-checkout {
        display: block;
        width: 100%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 1rem;
        font-weight: 700;
        color: white;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(102,126,234,0.4);
        text-align: center;
        margin-bottom: 0.75rem;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102,126,234,0.5);
        color: white;
    }

    .btn-clear-cart {
        display: block;
        width: 100%;
        background: white;
        border: 2px solid #fed7d7;
        border-radius: 12px;
        padding: 0.75rem;
        font-weight: 600;
        color: #e53e3e;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .btn-clear-cart:hover {
        background: #e53e3e;
        border-color: #e53e3e;
        color: white;
        transform: translateY(-2px);
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
    .cart-empty h4 { color: #2d3748; font-weight: 700; font-size: 1.5rem; margin-bottom: 0.75rem; }
    .cart-empty p { color: #718096; margin-bottom: 2rem; font-size: 1rem; }

    .btn-go-shop {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 0.9rem 2rem;
        font-weight: 700;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102,126,234,0.4);
        font-size: 1rem;
    }

    .btn-go-shop:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(102,126,234,0.5);
        color: white;
        text-decoration: none;
    }

    /* Toast del carrito */
    .cart-page-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
        border-radius: 14px;
        padding: 1rem 1.5rem;
        font-weight: 600;
        box-shadow: 0 8px 30px rgba(72,187,120,0.4);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: cpToastIn 0.4s ease;
        font-size: 0.95rem;
    }

    .cart-page-toast.danger {
        background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
        box-shadow: 0 8px 30px rgba(229,62,62,0.3);
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
function cp_readCart() {
    try {
        return JSON.parse(localStorage.getItem('cart') || '[]');
    } catch(e) {
        return [];
    }
}

function cp_writeCart(cart) {
    localStorage.setItem('cart', JSON.stringify(cart));
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
    localStorage.removeItem('cart');
    if (typeof updateCartCount === 'function') updateCartCount();
    cp_renderPage();
    cp_toast('Carrito vaciado', 'danger');
}

// ── Checkout (placeholder) ─────────────────────────────────────────
function cp_checkout() {
    var cart = cp_readCart();
    if (cart.length === 0) { cp_toast('Tu carrito está vacío', 'danger'); return; }
    var total = cp_calcTotal(cart);
    alert('🛒 Funcionalidad de pago en desarrollo.\n\nProductos: ' + cart.length + '\nTotal: $' + total.toFixed(2));
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
