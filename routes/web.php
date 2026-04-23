<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;


use App\Http\Controllers\UserController;

use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AbandonedCartController;
use App\Http\Controllers\UserOrderController;

Route::get("/", [ProductController::class , "welcome"])->name("welcome");
Route::get("/nosotros", [PageController::class, "nosotros"])->name("nosotros");

// Custom auth routes with better control
Route::get("login", [LoginController::class , "showLoginForm"])->name("login");
Route::post("login", [LoginController::class , "login"]);
Route::match (["get", "post"], "logout", [LoginController::class , "logout"])
    ->name("logout")
    ->middleware(["auth", "security:logout"]);

// Admin Specific Login Routes
Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
// Admin dashboard route
Route::get('admin', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware(['auth', 'role:admin']);

Route::get("register", [
    RegisterController::class ,
    "showRegistrationForm",
])->name("register");
Route::post("register", [RegisterController::class , "register"]);

Route::get("password/reset", [
    ForgotPasswordController::class ,
    "showLinkRequestForm",
])->name("password.request");
Route::post("password/email", [
    ForgotPasswordController::class ,
    "sendResetLinkEmail",
])->name("password.email");
Route::get("password/reset/{token}", [
    ResetPasswordController::class ,
    "showResetForm",
])->name("password.reset");
Route::post("password/reset", [ResetPasswordController::class , "reset"])->name(
    "password.update",
);
Route::get("password/confirm", [
    ConfirmPasswordController::class ,
    "showConfirmForm",
])->name("password.confirm");
Route::post("password/confirm", [ConfirmPasswordController::class , "confirm"]);

Route::middleware(["auth", "security:auth"])->group(function () {
    Route::get("/home", [HomeController::class , "index"])->name("home");

    // Ruta del carrito
    Route::get('/cart', [CartController::class , 'index'])->name('cart.index');

    // Historial de compras y pagos
    Route::get('/my-orders', [UserOrderController::class , 'index'])->name('user.orders');
    Route::get('/my-orders/{order}/pay', [UserOrderController::class , 'pay'])->name('user.orders.pay');
    Route::post('/my-orders/{order}/pay', [UserOrderController::class , 'processPayment'])->name('user.orders.process-payment');

    // Rutas de productos
    Route::resource("products", ProductController::class)->except([
        "update",
    ]);
    Route::get("productos", [ProductController::class , "index"])->name(
        "productos.index",
    );
    Route::get("productos/agregar", [ProductController::class , "create"])->name(
        "productos.create",
    );
    // endpoint used by DataTables; the english name is kept for backwards
    // compatibility with automated tests and the original documentation, but
    // we also expose a Spanish path so that the AJAX call lives on the same
    // `productos` prefix as the index page.  Both routes hit the same controller
    // method.
    Route::get("products/data", [ProductController::class , "dataTable"])->name(
        "products.data",
    );
    Route::get("productos/data", [ProductController::class , "dataTable"])->name(
        "productos.data",
    );
    Route::get("products/{product}/download-image", [
        ProductController::class ,
        "downloadImage",
    ])->name("products.download-image");
    Route::post("products/{product}/toggle", [ProductController::class, "toggleStatus"])->name("products.toggle");

    // Rutas de empresas
    Route::resource('companies', CompanyController::class)->except(['show', 'update']);
    Route::get('companies/data', [CompanyController::class , 'dataTable'])->name('companies.data');

    // Rutas de Checkout
    Route::get('/checkout', [CheckoutController::class , 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class , 'store'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class , 'success'])->name('checkout.success');
    Route::get('/checkout/cancel/{order}', [CheckoutController::class , 'cancel'])->name('checkout.cancel');

    // Rutas de usuarios (Solo Admin)

    Route::middleware(["role:admin"])->group(function () {
            // Usuarios
            Route::resource("users", UserController::class)->except([
                "show",
                "update",
            ]);
            Route::post("users/{user}/toggle", [UserController::class, "toggleStatus"])->name("users.toggle");
            Route::get("users/data", [UserController::class , "dataTable"])->name(
                "users.data",
            );
            Route::get("users/{user}/download-avatar", [
                UserController::class ,
                "downloadAvatar",
            ])->name("users.download-avatar");

            // Pedidos (Orders)
            Route::get('admin/orders', [OrderAdminController::class, 'index'])->name('admin.orders.index');
            Route::get('admin/orders/{order}', [OrderAdminController::class, 'show'])->name('admin.orders.show');

            // Abandono de Productos (Abandoned)
            Route::get('admin/abandoned', [AbandonedCartController::class, 'index'])->name('admin.abandoned.index');

            // Comentarios (Comments)
            Route::get('admin/comments', [CommentController::class, 'index'])->name('admin.comments.index');
            Route::patch('admin/comments/{comment}', [CommentController::class, 'update'])->name('admin.comments.update');
            Route::delete('admin/comments/{comment}', [CommentController::class, 'destroy'])->name('admin.comments.destroy');

            // Reportes de Ventas
            Route::get('admin/reports', [\App\Http\Controllers\Admin\ReportAdminController::class, 'index'])->name('admin.reports.index');
        }
    );

    // Public Comments Store (Logged in users)
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    });
