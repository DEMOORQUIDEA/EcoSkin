# 👥 Sistema de Activación/Desactivación de Usuarios - Documentación

## 📋 Resumen

En lugar de **eliminar permanentemente** usuarios de la base de datos, ahora se pueden **activar o desactivar** sus cuentas. Esto permite:
- ✅ Mantener el historial de usuarios y órdenes
- ✅ Prevenir que usuarios desactivados inicien sesión
- ✅ Reactivar cuentas cuando sea necesario
- ✅ Integridad referencial en base de datos

---

## ✨ Cambios Implementados

### 1. **Nueva Columna en Base de Datos**
Se agregó la columna `is_active` (booleano) a la tabla `users`:

```php
// Migración: add_is_active_to_users_table.php
Schema::table('users', function (Blueprint $table) {
    $table->boolean('is_active')->default(true)->after('email_verified_at');
});
```

**Estado por defecto:** `true` (usuario activo)

### 2. **Métodos en Modelo User**

Se agregaron nuevos métodos al modelo `app/Models/User.php`:

```php
$user->isActive()        // ¿Usuario está activo?
$user->isInactive()      // ¿Usuario está inactivo?
$user->activate()        // Activar cuenta
$user->deactivate()      // Desactivar cuenta
$user->toggleStatus()    // Cambiar estado (activo ↔ inactivo)
```

### 3. **Cambios en UserController**

#### Método `destroy()` - Desactivar en lugar de eliminar
```php
public function destroy(Request $request, User $user)
{
    // Ya no elimina, solo desactiva
    $user->deactivate();

    return redirect()
        ->route("users.index")
        ->with("success", "Usuario desactivado exitosamente!!!");
}
```

#### Nuevo método `toggleStatus()` - Alternar estado
```php
public function toggleStatus(Request $request, User $user)
{
    $user->toggleStatus();
    $newStatus = $user->is_active ? 'activado' : 'desactivado';

    return redirect()
        ->route("users.index")
        ->with("success", "Usuario {$newStatus} exitosamente!!!");
}
```

### 4. **Interfaz de Usuario Actualizada**

La tabla de usuarios ahora muestra botones con los mismos estilos
personalizados que el resto de la aplicación:

- **Usuario ACTIVO**: Botón **"Desactivar"** (clase `btn-deactivate`)
- **Usuario INACTIVO**: Botón **"Activar"** (clase `btn-activate`)

```html
<!-- Usuario Activo -->
<button class="btn btn-action btn-deactivate btn-sm">
    <i class="bi bi-lock"></i> Desactivar
</button>

<!-- Usuario Inactivo -->
<button class="btn btn-action btn-activate btn-sm">
    <i class="bi bi-unlock"></i> Activar
</button>
```

Esto reemplaza los colores `warning`/`success` de Bootstrap y garantiza
que todos los botones de la aplicación utilicen la paleta definida en
`layout.blade.php`, de modo que la UI se vea coherente.

---

## 🔄 Flujo de Desactivación/Activación

```
┌─────────────────────┐
│  Admin ve usuarios  │
│    en la tabla      │
└──────────┬──────────┘
           │
      ┌────┴────┐
      │          │
      ▼          ▼
 ┌─────────┐  ┌──────────┐
 │ ACTIVO  │  │ INACTIVO │
 │ 🟢      │  │ 🔴       │
 └────┬────┘  └────┬─────┘
      │            │
  Botón         Botón
  Desactivar    Activar
      │            │
      ▼            ▼
 ┌─────────┐  ┌──────────┐
 │ INACTIVO│  │  ACTIVO  │
 │ 🔴      │  │ 🟢       │
 └─────────┘  └──────────┘
```

---

## 🗄️ Estructura de la Base de Datos

### Tabla `users` - Nueva columna

```sql
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    email_verified_at TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,  -- ✨ Nueva columna
    password VARCHAR(255),
    avatar VARCHAR(255) NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### Ejemplos de datos

```
id | name       | email              | is_active | estado
---|------------|--------------------|-----------|--------
1  | Alejandro  | alejandro@...  | 1         | ✅ Activo
2  | Juan       | juan@...           | 1         | ✅ Activo
3  | María      | maria@...          | 0         | ❌ Inactivo
4  | Pedro      | pedro@...          | 0         | ❌ Inactivo
```

---

## 🔐 Protección de Login

Para evitar que usuarios desactivados inicien sesión, necesitas agregar middleware a `app/Http/Middleware/Authenticate.php`:

```php
public function handle(Request $request, Closure $next, ...$guards)
{
    if (Auth::check() && !Auth::user()->isActive()) {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login')->with('error', 'Tu cuenta ha sido desactivada.');
    }

    // ... resto del middleware
}
```

O crea un middleware personalizado:

```bash
php artisan make:middleware CheckActiveUser
```

```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckActiveUser
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isInactive()) {
            Auth::logout();
            return redirect('/login')->with('error', 'Tu cuenta ha sido desactivada.');
        }

        return $next($request);
    }
}
```

Registrarlo en `app/Http/Kernel.php`:

```php
protected $middleware = [
    // ... otros middleware
    \App\Http\Middleware\CheckActiveUser::class,
];
```

---

## 📝 Rutas Disponibles

### Nuevas rutas en `routes/web.php`

```php
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Resource routes (incluyendo destroy)
    Route::resource('users', UserController::class);
    
    // Toggle status (crear nueva ruta POST)
    Route::post('users/{user}/toggle', [UserController::class, 'toggleStatus'])
         ->name('users.toggle');
});
```

| Ruta | Método | Acción |
|------|--------|--------|
| `/users/{id}/edit` | GET | Mostrar formulario de edición |
| `/users/{id}` | POST | Desactivar usuario |
| `/users/{id}/toggle` | POST | Alternar estado (activar/desactivar) |

---

## 🧪 Ejemplos de Uso

### En Controladores

```php
use App\Models\User;

// Verificar si usuario está activo
if (Auth::user()->isActive()) {
    // Permitir acceso
}

// Desactivar usuario
$user = User::find(5);
$user->deactivate();

// Activar usuario
$user->activate();

// Cambiar estado
$user->toggleStatus();
```

### En Vistas Blade

```html
@if(Auth::user()->isActive())
    <!-- Contenido para usuarios activos -->
@else
    <!-- usuario desactivado -->
@endif

<!-- Mostrar badge de estado -->
@if($user->isActive())
    <span class="badge bg-success">Activo</span>
@else
    <span class="badge bg-danger">Inactivo</span>
@endif
```

---

## 🎬 Pasos para Usar la Funcionalidad

### 1. Ejecutar la Migración

```bash
php artisan migrate
```

Esto agregará la columna `is_active` a todos los usuarios existentes con valor `true`.

### 2. En Administrador

1. Ve a `/admin/users` (o la ruta de usuarios)
2. Verás la tabla de usuarios con dos tipos de botones:
   - **Desactivar** (amarillo) - Para usuarios activos
   - **Activar** (verde) - Para usuarios inactivos

### 3. Hacer clic en el botón

- El sistema pedirá confirmación
- Luego redirigirá con mensaje de éxito

---

## 📊 Comparación: Antes vs Después

| Aspecto | Antes (Delete) | Ahora (Toggle) |
|---------|---|---|
| **Acción** | Eliminar permanentemente | Activar/Desactivar |
| **Datos** | Se pierden | Se preservan |
| **Historial** | Se pierde | Disponible |
| **Órdenes** | Referencia rota | Intacto |
| **Reversible** | No | Sí |
| **Seguridad** | Riesgo de pérdida | Más seguro |

---

## 🔍 Verificar Estado en DevTools

En la consola de Laravel Tinker:

```bash
php artisan tinker
```

```php
// Ver usuarios activos
User::where('is_active', true)->get();

// Ver usuarios inactivos
User::where('is_active', false)->get();

// Desactivar usuario
User::find(5)->deactivate();

// Verificar estado
User::find(5)->isActive();  // false
User::find(5)->isInactive(); // true

// Activar usuario
User::find(5)->activate();
```

---

## ⚙️ Configuración Avanzada

### Filtrar solo usuarios activos en consultas

```php
// En un controlador
$activeUsers = User::where('is_active', true)->get();

// O usar scope (si lo deseas agregar)
$activeUsers = User::active()->get();
```

### Agregar Scope al modelo User

```php
public function scopeActive($query)
{
    return $query->where('is_active', true);
}

public function scopeInactive($query)
{
    return $query->where('is_active', false);
}

// Uso:
$activeUsers = User::active()->get();
$inactiveUsers = User::inactive()->get();
```

---

## 📁 Archivos Modificados

| Archivo | Cambios |
|---------|---------|
| `database/migrations/2026_03_04_200000_add_is_active_to_users_table.php` | ✅ Nueva migración |
| `app/Models/User.php` | ✅ Métodos: `isActive()`, `isInactive()`, `activate()`, `deactivate()`, `toggleStatus()` |
| `app/Http/Controllers/UserController.php` | ✅ `destroy()` desactiva en lugar de eliminar, nuevo `toggleStatus()` |
| `routes/web.php` | ✅ Nueva ruta `users/{user}/toggle` POST |
| `resources/views/users/index.blade.php` | ✅ Botones Activar/Desactivar, función `confirmToggleStatus()` |

---

## 🚀 Próximos Pasos Opcionales

1. **Agregar filtro de estado** en tabla de usuarios (mostrar solo activos, inactivos, todos)
2. **Log de cambios** - Registrar cuándo se activó/desactivó
3. **Notificación por email** - Avisar al usuario cuando su cuenta es desactivada
4. **Razón de desactivación** - Agregar campo de comentario
5. **Soft deletes** - Usar softDeletes en lugar de esta columna

---

## 📞 Preguntas Frecuentes

**P: ¿Se pierde la información del usuario?**
R: No. Los datos se mantienen en la BD y se puede reactivar en cualquier momento.

**P: ¿Qué sucede si un usuario desactivado intenta iniciar sesión?**
R: Con el middleware implementado, será desconectado automáticamente.

**P: ¿Se pueden desactivar los 5 administradores?**
R: Técnicamente sí, pero es recomendable agregar restricción para evitarlo:
```php
if ($user->isAdmin()) {
    abort(403, 'No puedes desactivar un administrador');
}
```

**P: ¿Necesito ejecutar migraciones?**
R: Sí, ejecuta `php artisan migrate` para agregar la columna `is_active`.

---

## Fecha de Implementación

**Marzo 4, 2026**

## Estado

✅ **COMPLETADO** - Sistema de activación/desactivación de usuarios implementado. Usuarios desactivados no podrán iniciar sesión después de implementar el middleware de verificación.
