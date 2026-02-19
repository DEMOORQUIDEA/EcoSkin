<?php

namespace App\Http\Controllers;

// use App\Http\Requests\ProductStoreRequest;
// use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\FileService;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Mostrar productos públicos en la página de bienvenida con paginación y búsqueda
     */
    public function welcome(Request $request)
    {
        $query = Product::query();

        // Búsqueda en toda la base de datos
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('price', 'like', "%{$search}%");
            });
        }

        // Obtener productos con paginación (20 por página)
        $products = $query->orderBy('created_at', 'desc')->paginate(20);

        // Mantener parámetros de búsqueda en paginación
        $products->appends($request->all());

        return view('welcome-simple', [
            'products' => $products,
            'search' => $request->input('search', ''),
        ]);
    }

    public function index(Request $request)
    {
        // $products = Product::all();

        return view("products.index", [
            // 'products' => $products,
            "products" => collect(),
        ]);
    }

    public function create(Request $request)
    {
        return view("products.form");
    }

    public function store(Request $request)
    {
        try {
            // Debug: Verificar si hay archivo
            Log::info("Store method called");
            Log::info("All request data:", $request->all());
            Log::info("All files:", $request->allFiles());
            Log::info(
                "Has file image: " .
                ($request->hasFile("image") ? "YES" : "NO"),
            );
            if ($request->hasFile("image")) {
                $file = $request->file("image");
                Log::info(
                    "File info: " .
                    json_encode([
                    "name" => $file->getClientOriginalName(),
                    "size" => $file->getSize(),
                    "mime" => $file->getMimeType(),
                    "valid" => $file->isValid(),
                    "error" => $file->getError(),
                ]),
                );
            }

            // validar los inputs del request incluyendo imagen
            $validated = $request->validate([
                "name" => "required|string|max:40",
                "price" => "required|numeric|min:1|max:9999999",
                "description" => "required|string",
                "image" => "nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120",
            ]);

            $id = $request->input("id", null);

            if ($id) {
                // actualizar producto existente
                $product = Product::findOrFail($id);
                $oldImage = $product->image;

                // Actualizar campos básicos
                $product->fill($validated);
                $product->save();

                // Procesar nueva imagen si se subió
                if ($request->hasFile("image")) {
                    $uploadResult = $this->fileService->upload(
                        $request->file("image"),
                        "products",
                    );

                    if ($uploadResult["success"]) {
                        $product->image = $uploadResult["path"];
                        $product->save();

                        // Eliminar imagen anterior si existe
                        if ($oldImage) {
                            $this->fileService->delete($oldImage);
                        }
                    }
                }
            }
            else {
                // agregar producto nuevo
                $product = Product::create([
                    'name' => $validated['name'],
                    'price' => $validated['price'],
                    'description' => $validated['description'],
                ]);

                // Procesar imagen para producto nuevo
                if ($request->hasFile("image") && $request->file("image")->isValid()) {
                    Log::info("Processing new product image");
                    $uploadResult = $this->fileService->upload(
                        $request->file("image"),
                        "products",
                    );

                    Log::info("Upload result: " . json_encode($uploadResult));

                    if ($uploadResult["success"]) {
                        $product->image = $uploadResult["path"];
                        $product->save();
                        Log::info("Image path saved: " . $uploadResult["path"]);
                    }
                    else {
                        Log::error("Image upload failed: " . $uploadResult["message"]);
                    }
                }
            }
            return redirect()
                ->route("products.index")
                ->with("success", "Producto registrado exitosamente.");
        }
        catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
        catch (QueryException $e) {
            // Manejar errores de base de datos (duplicados, restricciones, etc.)
            Log::error("Database error in product store: " . $e->getMessage());

            $errorMessage = "Ocurrió un error al guardar el producto.";

            // Detectar error de duplicado (código 23000 es para violación de restricción única)
            if ($e->getCode() == 23000) {
                $errorMessage = "Este producto ya existe en el sistema. Por favor, verifica los datos e intenta nuevamente.";
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(["error" => $errorMessage]);
        }
        catch (\Exception $e) {
            // Manejar cualquier otro error inesperado
            Log::error("Unexpected error in product store: " . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(["error" => "Ocurrió un error inesperado. Por favor, intenta nuevamente."]);
        }
    }

    public function edit(Request $request, Product $product)
    {
        //$product = Product::find($product);

        return view("products.form", [
            "product" => $product,
        ]);
    }

    // public function update(ProductUpdateRequest $request, Product $product)
    // {
    //     $product->update($request->validated());

    //     session()->flash('Product.name', $product->name);

    //     return redirect()->route('products.index');
    // }

    public function destroy(Request $request, Product $product)
    {
        // Eliminar imagen si existe
        if ($product->image) {
            $this->fileService->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route("products.index")
            ->with("success", "Producto eliminado exitosamente!!!");
    }

    public function dataTable(Request $request)
    {
        // Validar params de DataTables (opcional, pero seguro)
        $request->validate([
            "draw" => "integer",
            "start" => "integer|min:0",
            "length" => "integer|min:1|max:100",
            "search.value" => "nullable|string|max:255",
        ]);

        // Query base
        $query = Product::query();

        // Búsqueda en varios campos
        $search = $request->input("search.value");
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where("name", "like", "%{$search}%")
                    ->orWhere("description", "like", "%{$search}%")
                    ->orWhere("price", "like", "%{$search}%");
            });
        }

        // Total de registros sin filtros (para recordsTotal)
        $totalRecords = Product::count();

        // Registros filtrados (recordsFiltered)
        $filteredRecords = clone $query;
        $recordsFiltered = $filteredRecords->count();

        // get y set Ordenación (columna y dirección)
        $columns = ["name", "description", "price", "id"]; // Orden de columnas en tabla
        $orderColumn = $request->input("order.0.column", 0);
        $orderDir = $request->input("order.0.dir", "asc");
        $query->orderBy($columns[$orderColumn] ?? "id", $orderDir);

        // Paginación
        $start = $request->input("start", 0);
        $length = $request->input("length", 10);
        $data = $query->skip($start)->take($length)->get();

        // Formatear los datos para el componente DataTables
        // TODO: Formatear del lado del cliente
        $data = $data->map(function ($product) {
            $imageHtml = "";
            if (
            $product->image &&
            Storage::disk("public")->exists($product->image)
            ) {
                $imageHtml =
                    '<div class="product-img-wrapper"><img src="' .
                    asset("storage/" . $product->image) .
                    '" alt="' .
                    $product->name .
                    '"></div>';
            }
            else {
                $imageHtml =
                    '<div class="product-img-wrapper"><i class="bi bi-image no-image-icon"></i></div>';
            }

            return [
            "image" => $imageHtml,
            "name" => $product->name,
            "description" => $product->description,
            "price" => '$' . number_format($product->price, 2),
            "actions" =>
            '
                    <button class="btn btn-action btn-edit" onclick="execute(\'/products/' .
            $product->id .
            '/edit\')">
                        <i class="bi bi-pencil-square"></i> <span>Editar</span>
                    </button>
                    <button class="btn btn-action btn-delete" onclick="deleteRecord(\'/products/' .
            $product->id .
            '\')">
                        <i class="bi bi-trash-fill"></i> <span>Eliminar</span>
                    </button>
                ',
            ];
        });

        // Respuesta JSON en formato requerido por DataTables
        return response()->json([
            "draw" => (int)$request->input("draw"), // Eco del draw para sync
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data,
        ]);
    }

    /**
     * Descargar imagen de producto
     */
    public function downloadImage(Product $product)
    {
        if (!$product->image) {
            abort(404, "Imagen no encontrada");
        }

        try {
            return $this->fileService->download(
                $product->image,
                "producto_" . $product->id . "_" . basename($product->image),
            );
        }
        catch (\Exception $e) {
            abort(404, "Archivo no encontrado");
        }
    }
}
