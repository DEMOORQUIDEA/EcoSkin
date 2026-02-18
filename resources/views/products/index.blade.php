<x-layout>

    @section('css')
    <style>
        /* Estilos personalizados para el input de búsqueda */
        #searchInput {
            transition: all 0.3s ease;
        }

        #searchInput:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
            border-color: #86b7fe !important;
        }

        .input-group:focus-within .input-group-text {
            border-color: #86b7fe;
        }

        #clearSearch {
            transition: opacity 0.2s ease;
        }

        #clearSearch:hover {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .input-group-text {
            transition: border-color 0.15s ease-in-out;
        }
    </style>
    @endsection

    <?php
// $products = [
//     ['id' => 1, 'name' => 'Coca600ml', 'description' => 'Coca cola de 600 grs', 'price' => 18.00],
//     ['id' => 2, 'name' => 'Coca1lt', 'description' => 'Coca cola de 1 litro', 'price' => 38.00],
// ];
?>
    <div class="container">
        <div class="row my-4 mx-1">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Productos</h1>
                <button class="btn btn-primary btn-sm" onclick="execute('/productos/agregar')">
                    <i class="bi bi-plus"></i>
                    <span class="d-none d-sm-inline">Agregar</span>
                </button>
            </div>
        </div>

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
                    <button class="btn btn-outline-secondary" type="button" id="clearSearch" style="display: none;">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <small class="text-muted d-block mt-1">
                    <i class="bi bi-info-circle"></i> Escribe para filtrar los productos
                </small>
            </div>
        </div>

        <div class="row justify-content-center">
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
                        {{-- @foreach ($products as $product)
                            <tr>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['description'] }}</td>
                                <td>${{ number_format($product['price'], 2) }}</td>
                                <td class="text-end text-nowrap w-auto">
                                    <button class="btn btn-primary btn-sm" onclick="execute('/products/{{ $product['id'] }}/edit')">
                                        <i class="bi bi-pencil"></i>
                                            <span class="d-none d-sm-inline">Edit</span>
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteRecord('/products/{{ $product['id'] }}')">
                                        <i class="bi bi-trash"></i>
                                        <span class="d-none d-sm-inline">Delete</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @section('js')
    <script>
        // Inicializar DataTable
        const table = $('#myTable').DataTable({
            serverSide: true,
            processing: true,
            ajax: {
                url: '{{ route("products.data") }}',
                type: 'GET'
            },
            columns: [
                {
                    data: 'image',
                    orderable: false,
                    searchable: false,
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
            pageLength: 10, // Items por página
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            searching: true, // Habilitar búsqueda
            // language: {
            //     url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json' // Opcional: español
            // }
        });

        // Búsqueda personalizada con el input
        $('#searchInput').on('keyup', function() {
            const searchValue = this.value;
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

        function execute(url) {
            window.open(url, '_self');
        }
        function deleteRecord(url) {
            if (confirm('¿Está seguro de eliminar este registro?')) {
                $('<form>', {'action': url, 'method': 'POST'})
                .append($('<input>', {type: 'hidden', name: '_token', value: '{{ csrf_token() }}'}))
                .append($('<input>', {type: 'hidden', name: '_method', value: 'DELETE'}))
                .appendTo('body')
                .submit()
                .remove();
            }
        }
        // Obtener de la sessión el mensaje de éxito o error
        @if (session('success'))
            alert (`{{ session('success') }}`);
            // Opcional: Recarga la tabla después de agregar/eliminar
            // $('#myTable').DataTable().ajax.reload(null, false); // false para no resetear paginación
        @endif
    </script>
    @endsection

</x-layout>
