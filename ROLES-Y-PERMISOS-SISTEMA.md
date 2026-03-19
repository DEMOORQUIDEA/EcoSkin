# 👥 Sistema de Roles y Permisos - Documentación

## 📋 Resumen

El sistema de **detección automática de roles** ha sido implementado en la base de datos. Cada usuario es automáticamente clasificado como:
- ✅ **Administrador** (5 usuarios predefinidos)
- ✅ **Cliente** (usuarios que se registran por primera vez)
- ✅ **Vendedor** (rol opcional para futuros vendedores)
- ✅ **Invitado** (rol para visitantes sin autenticar)

---

## 🎯 5 Administradores Predefinidos

Los siguientes usuarios tienen rol de **ADMINISTRADOR** por defecto:

| # | Nombre | Email | Estado |
|---|--------|-------|--------|
| 1 | **Alejandro** | alejandro@ecoskin.com | ✅ Admin |
| 2 | **Orquidea** | orquidea@ecoskin.com | ✅ Admin |
| 3 | **Karen** | karen@ecoskin.com | ✅ Admin |
| 4 | **Obet** | obet@ecoskin.com | ✅ Admin |
| 5 | **Dayana** | dayana@ecoskin.com | ✅ Admin |

**Contraseña por defecto:** `ECOSKIN2025`

---

## 🔧 Cómo Funciona la Asignación de Roles

### 1. Nuevos Usuarios (Registro)

Cuando un usuario se registra a través del formulario de registro (`/register`):

```php
// En RegisterController.php
protected function create(array $data)
{
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    // ✅ Se asigna automáticamente rol 'cliente'
    $user->assignRole('cliente');

    return $user;
}
```

**Resultado:** El nuevo usuario recibe rol `'cliente'` automáticamente.

### 2. Administradores Predefinidos

Al ejecutar los seeders (`php artisan db:seed`), se crean automáticamente:

```bash
php artisan db:seed --class=AdminUsersSeeder
```

**Los 5 admins se crean/actualizan automáticamente** con el rol `'admin'`.

---

## ✨ Métodos del Modelo User para Detectar Roles

Se han agregado métodos útiles en `app/Models/User.php` para detectar roles:

### Métodos Disponibles

```php
use Auth;

$user = Auth::user();

// 1. Verificar si es administrador
if ($user->isAdmin()) {
    // Usuario es admin
}

// 2. Verificar si es cliente
if ($user->isCliente()) {
    // Usuario es cliente
}

// 3. Verificar si es vendedor
if ($user->isVendedor()) {
    // Usuario es vendedor
}

// 4. Verificar si es invitado
if ($user->isInvitado()) {
    // Usuario es invitado
}

// 5. Obtener rol principal
$role = $user->getPrimaryRole(); // Devuelve: 'admin', 'cliente', etc.

// 6. Obtener todos los roles
$roles = $user->getAllRoles(); // Devuelve colección de roles
```

---

## 🗄️ Estructura de la Base de Datos

### Tabla `users`

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    avatar VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Tabla `roles`

```sql
CREATE TABLE roles (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(125) UNIQUE,  -- 'admin', 'cliente', 'vendedor', 'invitado'
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Tabla Pivote `model_has_roles` (Relación)

```sql
CREATE TABLE model_has_roles (
    role_id BIGINT,
    model_type VARCHAR(255),  -- 'App\\Models\\User'
    model_id BIGINT,
    PRIMARY KEY (role_id, model_id, model_type),
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);
```

**Ejemplo de datos:**
```
role_id | model_type         | model_id
--------|--------------------|---------
1       | App\Models\User    | 1        ← Alejandro es admin
2       | App\Models\User    | 6        ← Usuario 6 es cliente
2       | App\Models\User    | 7        ← Usuario 7 es cliente
```

---

## 🎬 Ejemplo de Uso en Vistas

### En Blade Templates

```html
<!-- Mostrar contenido solo para admins -->
@can('admin')
    <div class="admin-panel">
        <!-- Contenido solo para administradores -->
    </div>
@endcan

<!-- Si prefieres usar el método directo -->
@if(Auth::user()->isAdmin())
    <div class="admin-controls">
        <!-- Controles administrativos -->
    </div>
@endif

<!-- Para clientes -->
@if(Auth::user()->isCliente())
    <div class="customer-section">
        <!-- Sección para clientes -->
    </div>
@endif
```

### En Controladores

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Verificar si es admin
        if ($user->isAdmin()) {
            return view('admin.dashboard');
        }

        // Verificar si es cliente
        if ($user->isCliente()) {
            return view('customer.dashboard');
        }

        return redirect('/');
    }
}
```

---

## 🔐 Uso de Middleware para Proteger Rutas

### Registrar Rutas Protegidas

En `routes/web.php`:

```php
Route::middleware(['auth', 'admin'])->group(function () {
    // Solo administradores pueden acceder
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/users', [AdminController::class, 'users']);
});

Route::middleware(['auth'])->group(function () {
    // Autenticados (clientes)
    Route::get('/customer/orders', [OrderController::class, 'myOrders']);
    Route::get('/cart', [CartController::class, 'index']);
});
```

### Crear Middleware Personalizado

Si necesitas un middleware para verificar admin:

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Acceso denegado. Solo administradores.');
        }

        return $next($request);
    }
}
```

Luego registrarlo en `app/Http/Kernel.php`:

```php
protected $routeMiddleware = [
    'admin' => \App\Http\Middleware\IsAdmin::class,
    // ... otros middleware
];
```

---

## 📊 Flujo de Detección de Roles

```
┌─────────────────┐
│  Usuario accede │
│  a la aplicación│
└────────┬────────┘
         │
         ▼
┌─────────────────────────────────┐
│ ¿Está autenticado?              │
└──────┬──────────────┬────────────┘
       │ SÍ           │ NO
       ▼               ▼
┌──────────────┐  ┌─────────────┐
│ Consultar    │  │ Rol: guest  │
│ rol en BD    │  │ (invitado)  │
└──────┬───────┘  └─────────────┘
       │
       ▼
   ┌───────────────────────────┐
   │ ¿Es uno de los 5 admins?  │
   └───┬───────────────────────┘
       │
   ┌───┴───────────┐
   │ SÍ      │ NO  │
   ▼         ▼     │
┌────────┐ ┌───────┴──────┐
│ ADMIN  │ │ ¿Tiene rol   │
└────────┘ │ cliente?     │
│          │
           ▼
       ┌─────────────┐
       │ CLIENTE     │
       └─────────────┘
```

---

## 🔄 Cambiar Rol de un Usuario (Admin)

Si en el futuro necesitas **cambiar el rol** de un usuario:

```php
use App\Models\User;

// Obtener usuario
$user = User::find(6); // Usuario ID 6

// Asignar nuevo rol (reemplaza rol anterior)
$user->syncRoles(['cliente']); // Solo cliente
$user->syncRoles(['admin', 'vendedor']); // Múltiples roles

// Agregar un rol adicional sin quitar otros
$user->assignRole('vendedor');

// Quitar un rol específico
$user->removeRole('cliente');

// Quitar todos los roles
$user->syncRoles([]);
```

---

## 📞 Testing de Roles

### Test 1: Verificar Rol de Nuevo Usuario

```bash
# Registra un nuevo usuario por CLI
php artisan tinker

# En la consola de tinker:
$user = User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
]);
$user->assignRole('cliente');
$user->isCliente(); // true
$user->isAdmin(); // false
```

### Test 2: Verificar 5 Admins

```bash
php artisan tinker

# Ver todos los admins
User::role('admin')->get();

# Verificar cada admin
User::where('email', 'alejandro@ecoskin.com')->first()->isAdmin(); // true
User::where('email', 'orquidea@ecoskin.com')->first()->isAdmin(); // true
// ... etc
```

### Test 3: En la Aplicación

1. Registra un nuevo usuario en `/register`
2. Inicia sesión con ese usuario
3. En consola del navegador (F12), ejecuta:
   ```javascript
   // Verificar el rol (si lo guardas en el template)
   const userRole = document.querySelector('[data-user-role]')?.dataset.userRole;
   console.log('Rol del usuario:', userRole); // Debe ser 'cliente'
   ```

---

## 📁 Archivos Modificados

| Archivo | Cambios |
|---------|---------|
| `app/Http/Controllers/Auth/RegisterController.php` | ✅ Agregada asignación automática de rol 'cliente' |
| `app/Models/User.php` | ✅ Agregados métodos: `isAdmin()`, `isCliente()`, `isVendedor()`, `isInvitado()`, `getPrimaryRole()`, `getAllRoles()` |
| `database/seeders/AdminUsersSeeder.php` | ✅ Ya tenía los 5 admins (sin cambios) |
| `database/seeders/RolesAndPermissionsSeeder.php` | ✅ Ya tenía los roles creados (sin cambios) |

---

## 🚀 Próximos Pasos

1. **Usar roles en vistas** - Aplicar `@if(Auth::user()->isAdmin())` en templates
2. **Proteger rutas** - Usar middleware para rutas de admin
3. **Sistema de permisos** - Agregar permisos específicos dentro de roles si es necesario
4. **Auditoría** - Logging de cambios de rol

---

## ⚡ Resumen Rápido

✅ **5 Administradores predefinidos:** Alejandro, Orquidea, Karen, Obet, Dayana
✅ **Rol automático para nuevos usuarios:** Se asigna 'cliente' al registrarse
✅ **Métodos de detección:** `isAdmin()`, `isCliente()`, `getPrimaryRole()`, etc.
✅ **Detección en BD:** Tabla `model_has_roles` vincula usuarios con roles
✅ **Uso en vistas:** `@if(Auth::user()->isAdmin())` disponible en Blade

---

## 📝 Notas Técnicas

- Se usa **Spatie Laravel Permission** para manejar roles y permisos
- Los roles son almacenados en tabla `roles`
- La relación usuario-rol se guarda en `model_has_roles`
- Cada usuario puede tener múltiples roles
- Es case-sensitive: los nombres de roles deben coincidir exactamente

---

## Fecha de Implementación

**Marzo 4, 2026**

## Estado

✅ **COMPLETADO** - Sistema de detección automática de roles en la base de datos implementado.
