# 🎯 Ejemplos de Implementación de Búsqueda

## Índice
1. [Búsqueda Client-Side (Página Pública)](#búsqueda-client-side)
2. [Búsqueda Server-Side (Página Autenticada)](#búsqueda-server-side)
3. [Ejemplos de Código Completos](#ejemplos-completos)
4. [Casos de Uso Reales](#casos-de-uso-reales)
5. [Troubleshooting](#troubleshooting)

---

## Búsqueda Client-Side

### Página de Bienvenida (`welcome-simple.blade.php`)

#### Estructura HTML

```html
<!-- Input de Búsqueda -->
<div class="col-md-6 col-lg-5">
    <div class="input-group">
        <!-- Icono de búsqueda -->
        <span class="input-group-text bg-white border-end-0">
            <i class="bi bi-search text-primary"></i>
        </span>
        
        <!-- Campo de texto -->
        <input type="text"
               id="searchInput"
               class="form-control border-start-0 ps-0"
               placeholder="Buscar productos por nombre, descripción o precio...">
        
        <!-- Botón limpiar (oculto por defecto) -->
        <button class="btn btn-outline-secondary" 
                type="button" 
                id="clearSearch" 
                style="display: none;">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    
    <!-- Texto de ayuda -->
    <small class="text-muted d-block mt-1">
        <i class="bi bi-info-circle"></i> Escribe para filtrar los productos
    </small>
</div>
```

#### JavaScript - Guardar Productos

```javascript
let allProducts = [];

function saveAllProducts() {
    // Obtener todas las tarjetas de productos del DOM
    const productCards = document.querySelectorAll('.product-card');
    
    // Convertir a array y extraer datos relevantes
    allProducts = Array.from(productCards).map(card => {
        return {
            // Guardar referencia al elemento DOM
            element: card.closest('.col'),
            
            // Extraer y normalizar textos (lowercase para búsqueda case-insensitive)
            name: card.querySelector('.card-title').textContent.toLowerCase(),
            description: card.querySelector('.card-text').textContent.toLowerCase(),
            price: card.querySelector('.h5.text-primary').textContent.toLowerCase()
        };
    });
    
    console.log(`✅ ${allProducts.length} productos guardados en memoria`);
}
```

#### JavaScript - Filtrar Productos

```javascript
function filterProducts(searchTerm) {
    const term = searchTerm.toLowerCase().trim();
    
    // Si no hay término, mostrar todos
    if (term === '') {
        allProducts.forEach(product => {
            product.element.style.display = '';
        });
        noResultsDiv.style.display = 'none';
        productsContainer.style.display = '';
        updateProductCount(allProducts.length);
        return;
    }
    
    let visibleCount = 0;
    
    // Filtrar cada producto
    allProducts.forEach(product => {
        // Verificar si el término aparece en alguno de los campos
        const matches = product.name.includes(term) ||
                       product.description.includes(term) ||
                       product.price.includes(term);
        
        if (matches) {
            product.element.style.display = '';
            visibleCount++;
        } else {
            product.element.style.display = 'none';
        }
    });
    
    // Mostrar/ocultar mensaje de "no resultados"
    if (visibleCount === 0) {
        productsContainer.style.display = 'none';
        noResultsDiv.style.display = 'block';
    } else {
        productsContainer.style.display = '';
        noResultsDiv.style.display = 'none';
    }
    
    updateProductCount(visibleCount);
    
    // Ocultar paginación durante búsqueda
    if (paginationContainer) {
        paginationContainer.style.display = 'none';
    }
}
```

#### JavaScript - Event Listeners

```javascript
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearSearchBtn = document.getElementById('clearSearch');
    
    // Búsqueda en tiempo real
    searchInput.addEventListener('input', function() {
        const value = this.value;
        filterProducts(value);
        
        // Mostrar/ocultar botón de limpiar
        if (value.length > 0) {
            clearSearchBtn.style.display = 'block';
        } else {
            clearSearchBtn.style.display = 'none';
        }
    });
    
    // Limpiar búsqueda
    clearSearchBtn.addEventListener('click', function() {
        searchInput.value = '';
        filterProducts('');
        clearSearchBtn.style.display = 'none';
        searchInput.focus();
    });
    
    // Guardar productos al cargar
    saveAllProducts();
});
```

#### CSS Personalizado

```css
/* Transición suave para el input */
#searchInput {
    transition: all 0.3s ease;
}

/* Efecto focus */
#searchInput:focus {
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    border-color: #86b7fe !important;
}

/* Border del icono cuando input tiene focus */
.input-group:focus-within .input-group-text {
    border-color: #86b7fe;
}

/* Botón de limpiar */
#clearSearch {
    transition: opacity 0.2s ease;
}

#clearSearch:hover {
    background-color: #dc3545;
    color: white;
    border-color: #dc3545;
}

/* Animación fade-in para productos */
.product-card {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
```

---

## Búsqueda Server-Side

### Panel de Productos (`products/index.blade.php`)

#### Estructura HTML

```html
<!-- Barra de búsqueda -->
<div class="row mb-3">
    <div class="col-md-6 col-lg-5">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search text-primary"></i>
            </span>
            <input type="text"
                   id="searchInput"
                   class="form-control border-start-0 ps-0"
                   placeholder="Buscar productos por nombre, descripción o precio...">
            <button class="btn btn-outline-secondary" 
                    type="button" 
                    id="clearSearch" 
                    style="display: none;">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <small class="text-muted d-block mt-1">
            <i class="bi bi-info-circle"></i> Escribe para filtrar los productos
        </small>
    </div>
</div>

<!-- Tabla de productos -->
<div class="table-responsive">
    <table id="myTable" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th class="text-end text-nowrap w-auto">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- DataTables llenará esto dinámicamente -->
        </tbody>
    </table>
</div>
```

#### JavaScript - Inicializar DataTables

```javascript
// Inicializar DataTable con configuración completa
const table = $('#myTable').DataTable({
    serverSide: true,        // Procesamiento en servidor
    processing: true,         // Mostrar indicador de carga
    
    // Configuración AJAX
    ajax: {
        // En las versiones españolas el end‑point también puede llamarse
        // `productos.data`, pero ambas rutas apuntan al mismo método.
        url: '{{ route("productos.data") }}',  // Endpoint del controlador
        type: 'GET'
    },
    
    // Definición de columnas
    columns: [
        {
            data: 'image',
            orderable: false,    // No se puede ordenar por imagen
            searchable: false,   // No se incluye en búsqueda
            width: '80px'
        },
        { data: 'name' },
        { data: 'description' },
        { data: 'price' },
        {
            data: 'actions',
            orderable: false,
            searchable: false
        }
    ],
    
    // Configuración de paginación
    pageLength: 10,
    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
    
    // Habilitar búsqueda
    searching: true,
    
    // Opcional: Idioma español
    // language: {
    //     url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
    // }
});
```

#### JavaScript - Búsqueda Personalizada

```javascript
// Búsqueda personalizada con el input
$('#searchInput').on('keyup', function() {
    const searchValue = this.value;
    
    // Enviar búsqueda a DataTables
    table.search(searchValue).draw();
    
    // Mostrar/ocultar botón de limpiar
    if (searchValue.length > 0) {
        $('#clearSearch').show();
    } else {
        $('#clearSearch').hide();
    }
});

// Limpiar búsqueda
$('#clearSearch').on('click', function() {
    $('#searchInput').val('');
    table.search('').draw();
    $(this).hide();
});
```

#### Backend - ProductController.php

```php
public function dataTable(Request $request)
{
    // Validar parámetros
    $request->validate([
        'draw' => 'integer',
        'start' => 'integer|min:0',
        'length' => 'integer|min:1|max:100',
        'search.value' => 'nullable|string|max:255',
    ]);
    
    // Query base
    $query = Product::query();
    
    // Búsqueda en varios campos
    $search = $request->input('search.value');
    if (!empty($search)) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('price', 'like', "%{$search}%");
        });
    }
    
    // Total de registros
    $totalRecords = Product::count();
    
    // Registros filtrados
    $filteredRecords = clone $query;
    $recordsFiltered = $filteredRecords->count();
    
    // Ordenamiento
    $columns = ['name', 'description', 'price', 'id'];
    $orderColumn = $request->input('order.0.column', 0);
    $orderDir = $request->input('order.0.dir', 'asc');
    $query->orderBy($columns[$orderColumn] ?? 'id', $orderDir);
    
    // Paginación
    $start = $request->input('start', 0);
    $length = $request->input('length', 10);
    $data = $query->skip($start)->take($length)->get();
    
    // Formatear datos
    $data = $data->map(function ($product) {
        return [
            'image' => $this->formatImageHtml($product),
            'name' => $product->name,
            'description' => $product->description,
            'price' => '$' . number_format($product->price, 2),
            'actions' => $this->formatActionsHtml($product),
        ];
    });
    
    // Respuesta JSON
    return response()->json([
        'draw' => (int)$request->input('draw'),
        'recordsTotal' => $totalRecords,
        'recordsFiltered' => $recordsFiltered,
        'data' => $data,
    ]);
}
```

---

## Ejemplos Completos

### Ejemplo 1: Búsqueda por Nombre

**Input del usuario:** `"Coca"`

**Client-Side (Welcome):**
```javascript
// JavaScript filtra instantáneamente
'coca cola 600ml'.includes('coca') // true ✅
'pepsi 1lt'.includes('coca')       // false ❌
```

**Server-Side (Products):**
```sql
-- MySQL ejecuta query
SELECT * FROM products 
WHERE name LIKE '%Coca%' 
   OR description LIKE '%Coca%' 
   OR price LIKE '%Coca%';
```

**Resultado:** Solo productos con "Coca" en el nombre o descripción

---

### Ejemplo 2: Búsqueda por Precio

**Input del usuario:** `"18"`

**Client-Side:**
```javascript
'$18.00'.includes('18')  // true ✅
'$180.00'.includes('18') // true ✅ (también coincide)
'$16.00'.includes('18')  // false ❌
```

**Server-Side:**
```sql
-- MySQL busca coincidencias en precio
SELECT * FROM products 
WHERE name LIKE '%18%' 
   OR description LIKE '%18%' 
   OR price LIKE '%18%';
```

**Resultado:** Productos con "18" en cualquier campo

---

### Ejemplo 3: Búsqueda sin Resultados

**Input del usuario:** `"xyz123"`

**Client-Side:**
```javascript
let visibleCount = 0;

allProducts.forEach(product => {
    const matches = product.name.includes('xyz123') ||
                   product.description.includes('xyz123') ||
                   product.price.includes('xyz123');
    // matches = false para todos
});

// visibleCount = 0
if (visibleCount === 0) {
    noResultsDiv.style.display = 'block'; // Mostrar mensaje
}
```

**Server-Side:**
```php
$recordsFiltered = 0; // No hay coincidencias

return response()->json([
    'data' => [],
    'recordsFiltered' => 0,
    'recordsTotal' => 100
]);
```

**Resultado:** Mensaje "No se encontraron productos"

---

## Casos de Uso Reales

### Caso 1: Catálogo E-commerce Pequeño

**Escenario:** Tienda con 50 productos

**Recomendación:** Client-Side (Welcome)

```javascript
// ✅ Ventajas:
// - Búsqueda instantánea
// - Experiencia fluida
// - Sin carga al servidor

// ⚠️ Consideración:
// - Todos los productos cargados en memoria
// - ~100KB de datos totales (aceptable)
```

---

### Caso 2: Catálogo Corporativo Grande

**Escenario:** Sistema con 5,000 productos

**Recomendación:** Server-Side (Products)

```php
// ✅ Ventajas:
// - Búsqueda eficiente en BD
// - Paginación real
// - Bajo uso de memoria cliente

// ⚠️ Consideración:
// - Latencia de red (~200ms)
// - Requiere índices en BD
```

**Optimización:**
```sql
-- Crear índices para mejorar búsqueda
CREATE INDEX idx_product_name ON products(name);
CREATE INDEX idx_product_description ON products(description);
```

---

### Caso 3: Marketplace Multi-Vendedor

**Escenario:** 50,000+ productos, múltiples vendedores

**Recomendación:** Server-Side + Elasticsearch

```php
// Búsqueda avanzada con Elasticsearch
public function search(Request $request)
{
    $results = Product::search($request->input('q'))
        ->where('status', 'active')
        ->orderBy('relevance', 'desc')
        ->paginate(20);
    
    return response()->json($results);
}
```

---

## Troubleshooting

### Problema 1: Búsqueda no funciona (Client-Side)

**Síntoma:** Al escribir, no se filtran productos

**Diagnóstico:**
```javascript
// Abrir consola del navegador (F12)

// Verificar que productos se guardaron
console.log(allProducts);
// Debe mostrar array con productos

// Verificar IDs
console.log(document.getElementById('searchInput'));
// No debe ser null

// Verificar event listener
searchInput.addEventListener('input', function() {
    console.log('Búsqueda:', this.value);
});
```

**Solución:**
```javascript
// Asegurarse de que el código está dentro de DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    saveAllProducts(); // ✅ Ejecutar después de cargar DOM
});
```

---

### Problema 2: DataTables no muestra datos

**Síntoma:** Tabla vacía o error "No data available"

**Diagnóstico:**
```javascript
// Verificar ruta
// console.log('{{ route("productos.data") }}');  // muestra /productos/data (alias)
// Debe ser /products/data

// Verificar respuesta AJAX
$('#myTable').on('xhr.dt', function(e, settings, json, xhr) {
    console.log('Respuesta:', json);
});
```

**Solución:**
```php
// Verificar formato de respuesta
return response()->json([
    'draw' => (int)$request->input('draw'),
    'recordsTotal' => $totalRecords,
    'recordsFiltered' => $recordsFiltered,
    'data' => $data, // ✅ Debe ser array
]);
```

---

### Problema 3: Búsqueda lenta (Server-Side)

**Síntoma:** Tabla tarda >2 segundos en actualizar

**Diagnóstico:**
```bash
# Verificar query en Laravel
php artisan telescope

# O activar query log
DB::enableQueryLog();
// ... ejecutar búsqueda
dd(DB::getQueryLog());
```

**Solución:**
```sql
-- Agregar índices FULLTEXT para búsqueda rápida
ALTER TABLE products 
ADD FULLTEXT INDEX ft_search (name, description);

-- Luego usar MATCH AGAINST
SELECT * FROM products
WHERE MATCH(name, description) AGAINST('coca' IN BOOLEAN MODE);
```

---

### Problema 4: Caracteres especiales

**Síntoma:** Búsqueda falla con acentos o ñ

**Solución Client-Side:**
```javascript
function normalizeText(text) {
    return text
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, ''); // Quitar acentos
}

// Usar en búsqueda
const matches = normalizeText(product.name).includes(normalizeText(term));
```

**Solución Server-Side:**
```php
// Configurar collation UTF-8 en MySQL
// En .env
DB_COLLATION=utf8mb4_unicode_ci

// O en query
$query->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($search).'%']);
```

---

## Performance Tips

### Client-Side

```javascript
// ❌ Lento: Buscar en cada tecla
searchInput.addEventListener('input', function() {
    filterProducts(this.value);
});

// ✅ Rápido: Debounce 150ms
const debouncedFilter = debounce(filterProducts, 150);
searchInput.addEventListener('input', function() {
    debouncedFilter(this.value);
});

function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}
```

### Server-Side

```php
// ❌ Lento: Query sin optimizar
$query->where('name', 'like', "%{$search}%")
      ->orWhere('description', 'like', "%{$search}%");

// ✅ Rápido: Con índices
$query->whereRaw("MATCH(name, description) AGAINST(? IN BOOLEAN MODE)", 
    [$search]);

// O usar Scout + Algolia/Meilisearch
$products = Product::search($search)->paginate();
```

---

## Testing Automatizado

### Test Client-Side (Playwright)

```javascript
test('búsqueda filtra productos', async ({ page }) => {
    await page.goto('http://localhost:8000');
    
    // Escribir en búsqueda
    await page.fill('#searchInput', 'Coca');
    
    // Verificar resultados
    const visible = await page.locator('.product-card:visible').count();
    expect(visible).toBeGreaterThan(0);
    
    // Verificar que otros están ocultos
    const hidden = await page.locator('.product-card:hidden').count();
    expect(hidden).toBeGreaterThan(0);
});
```

### Test Server-Side (PHPUnit)

```php
public function test_product_search_returns_filtered_results()
{
    // Crear productos de prueba
    Product::factory()->create(['name' => 'Coca Cola']);
    Product::factory()->create(['name' => 'Pepsi']);
    
    // Hacer búsqueda
    $response = $this->getJson('/products/data?search[value]=Coca');
    
    // Verificar respuesta
    $response->assertStatus(200);
    $response->assertJsonPath('recordsFiltered', 1);
    $response->assertJsonFragment(['name' => 'Coca Cola']);
}
```

---

## Conclusión

**Client-Side:**
- ✅ Mejor para: <100 productos, experiencia fluida
- ⚡ Velocidad: <5ms
- 📦 Complejidad: Baja

**Server-Side:**
- ✅ Mejor para: >1000 productos, grandes bases de datos
- ⚡ Velocidad: 100-300ms
- 📦 Complejidad: Media

Ambas implementaciones están optimizadas para sus casos de uso específicos y proporcionan una experiencia de usuario excepcional.

---

**📚 Documentación relacionada:**
- [BUSQUEDA-README.md](BUSQUEDA-README.md) - Vista general
- [BUSQUEDA-WELCOME.md](BUSQUEDA-WELCOME.md) - Client-side
- [BUSQUEDA-PRODUCTOS.md](BUSQUEDA-PRODUCTOS.md) - Server-side

**Última actualización:** Diciembre 2024