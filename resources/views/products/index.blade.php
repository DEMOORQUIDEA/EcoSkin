<x-layout>

    @section('css')
    <style>
        /* Estilos generales */
        .products-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: calc(100vh - 76px);
            padding: 2rem 0;
            margin: 0 -15px;
        }

        .products-header {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .title-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .title-icon i {
            font-size: 1.75rem;
            color: white;
        }

        .header-title h1 {
            margin: 0;
            color: #2d3748;
            font-weight: 700;
            font-size: 2rem;
        }

        .btn-add {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            color: white;
        }

        .btn-add i {
            font-size: 1.25rem;
        }

        /* Search Bar */
        .search-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .search-wrapper {
            position: relative;
            max-width: 600px;
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 1.25rem;
            pointer-events: none;
        }

        #searchInput {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e0e6ed;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        #searchInput:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        #clearSearch {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: none;
        }

        #clearSearch:hover {
            background: #c82333;
            transform: translateY(-50%) scale(1.05);
        }

        .search-help {
            margin-top: 0.75rem;
            font-size: 0.9rem;
            color: #718096;
        }

        .search-help i {
            color: #667eea;
        }

        /* Table Styles */
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .table thead th {
            color: white;
            font-weight: 600;
            padding: 1.25rem 1rem;
            border: none;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f7fafc;
        }

        .table tbody tr:hover {
            background: #f8f9ff;
            transform: scale(1.01);
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            color: #2d3748;
        }

        /* Product Image in Table */
        .product-img-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image-icon {
            font-size: 1.5rem;
            color: rgba(0, 0, 0, 0.2);
        }

        /* Action Buttons */
        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-edit {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 87, 108, 0.4);
            color: white;
        }

        /* DataTables Custom Styles */
        .dataTables_wrapper {
            padding: 1.5rem;
        }

        .dataTables_length {
            margin-bottom: 1.5rem;
        }

        .dataTables_length label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #2d3748;
            font-weight: 500;
        }

        .dataTables_length select {
            padding: 0.5rem 2.5rem 0.5rem 1rem;
            border: 2px solid #e0e6ed;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #2d3748;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23667eea' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            appearance: none;
        }

        .dataTables_info {
            color: #718096;
            font-size: 0.95rem;
            padding: 1rem 0;
        }

        /* PAGINACIÓN MEJORADA - SIN FLECHAS */
        .dataTables_paginate {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            padding: 1.5rem 0;
        }

        .dataTables_paginate .paginate_button {
            min-width: 45px;
            height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: 2px solid #e0e6ed;
            background: white;
            color: #2d3748;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            padding: 0.5rem 1rem;
        }

        .dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .dataTables_paginate .paginate_button.disabled {
            opacity: 0.4;
            cursor: not-allowed;
            background: #f7fafc;
            color: #a0aec0;
        }

        /* Ocultar las flechas previous/next y mostrar texto */
        .dataTables_paginate .paginate_button.previous,
        .dataTables_paginate .paginate_button.next {
            font-size: 0.9rem;
            padding: 0.5rem 1.25rem;
        }

        .dataTables_paginate .paginate_button.previous::before {
            content: 'Anterior';
            font-weight: 600;
        }

        .dataTables_paginate .paginate_button.next::before {
            content: 'Siguiente';
            font-weight: 600;
        }

        /* Ocultar el texto original de los botones */
        .dataTables_paginate .paginate_button.previous,
        .dataTables_paginate .paginate_button.next {
            font-size: 0;
        }

        .dataTables_paginate .paginate_button.previous::before,
        .dataTables_paginate .paginate_button.next::before {
            font-size: 0.9rem;
        }

        .dataTables_filter {
            display: none;
        }

        /* Processing Indicator */
        .dataTables_processing {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            border: none;
            color: #667eea;
            font-weight: 600;
        }

        /* Empty State */
        .dataTables_empty {
            padding: 3rem;
            text-align: center;
            color: #718096;
            font-size: 1.1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                align-items: stretch;
            }

            .header-title {
                flex-direction: column;
                text-align: center;
            }

            .products-header {
                padding: 1.5rem;
            }

            .dataTables_paginate {
                flex-wrap: wrap;
            }

            .dataTables_paginate .paginate_button {
                min-width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }

            .btn-action span {
                display: none;
            }

            .table-responsive {
                border-radius: 15px;
            }
        }
    </style>
    @endsection

    <div class="products-container">
        <div class="container">
            <!-- Header -->
            <div class="products-header">
                <div class="header-content">
                    <div class="header-title">
                        <div class="title-icon">
                            <i class="bi bi-box-seam-fill"></i>
                        </div>
                        <h1>Gestión de Productos</h1>
                    </div>
                    <button class="btn btn-add" onclick="execute('/productos/agregar')">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Agregar Producto</span>
                    </button>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="search-container">
                <div class="search-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text"
                           id="searchInput"
                           placeholder="Buscar por nombre, descripción o precio...">
                    <button id="clearSearch">
                        <i class="bi bi-x-lg"></i> Limpiar
                    </button>
                </div>
                <div class="search-help">
                    <i class="bi bi-info-circle-fill"></i>
                    Escribe para filtrar los productos en tiempo real
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <div class="table-responsive">
                    <table id="myTable" class="table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">Imagen</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th style="width: 120px;">Precio</th>
                                <th class="text-center" style="width: 200px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Datos cargados por DataTables -->
                        </tbody>
                    </table>
                </div>
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
                    searchable: false,
                    className: 'text-center'
                }
            ],
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            searching: true,
            language: {
                lengthMenu: "Mostrar _MENU_ productos por página",
                zeroRecords: "No se encontraron productos",
                info: "Mostrando página _PAGE_ de _PAGES_",
                infoEmpty: "No hay productos disponibles",
                infoFiltered: "(filtrado de _MAX_ productos totales)",
                processing: '<i class="bi bi-hourglass-split"></i> Cargando productos...',
                paginate: {
                    first: "Primera",
                    last: "Última",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            },
            order: [[1, 'asc']]
        });

        // Búsqueda personalizada con el input
        $('#searchInput').on('keyup', function() {
            const searchValue = this.value;
            table.search(searchValue).draw();

            // Mostrar/ocultar botón de limpiar
            if (searchValue.length > 0) {
                $('#clearSearch').fadeIn(200);
            } else {
                $('#clearSearch').fadeOut(200);
            }
        });

        // Limpiar búsqueda
        $('#clearSearch').on('click', function() {
            $('#searchInput').val('');
            table.search('').draw();
            $(this).fadeOut(200);
            $('#searchInput').focus();
        });

        // Funciones auxiliares
        function execute(url) {
            window.open(url, '_self');
        }

        function deleteRecord(url) {
            // SweetAlert style confirmation
            const confirmDelete = confirm('⚠️ ¿Estás seguro de eliminar este producto?\n\nEsta acción no se puede deshacer.');

            if (confirmDelete) {
                $('<form>', {
                    'action': url,
                    'method': 'POST'
                })
                .append($('<input>', {
                    type: 'hidden',
                    name: '_token',
                    value: '{{ csrf_token() }}'
                }))
                .append($('<input>', {
                    type: 'hidden',
                    name: '_method',
                    value: 'DELETE'
                }))
                .appendTo('body')
                .submit()
                .remove();
            }
        }

        // Mostrar mensaje de éxito
        @if (session('success'))
            // Crear un alert personalizado
            const successAlert = $('<div>', {
                class: 'alert alert-success alert-dismissible fade show',
                style: 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); border-radius: 12px;',
                html: '<i class="bi bi-check-circle-fill me-2"></i><strong>{{ session("success") }}</strong><button type="button" class="btn-close" data-bs-dismiss="alert"></button>'
            });

            $('body').append(successAlert);

            // Auto-cerrar después de 5 segundos
            setTimeout(function() {
                successAlert.fadeOut(400, function() {
                    $(this).remove();
                });
            }, 5000);

            // Recargar la tabla
            table.ajax.reload(null, false);
        @endif
    </script>
    @endsection

</x-layout>
