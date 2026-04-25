@extends('layouts.app')

@push('styles')
<style>
    /* Estilos generales */
    .users-container {
        background: var(--color-cream);
        min-height: calc(100vh - 76px);
        padding: 2rem 0;
        margin: 0 -15px;
    }

    .users-header {
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
        width: 56px;
        height: 56px;
        background: var(--color-forest);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(88, 98, 74, 0.25);
    }

    .title-icon i {
        font-size: 1.75rem;
        color: white;
    }

    .header-title h1 {
        margin: 0;
        color: var(--color-charcoal);
        font-family: 'Cormorant Garamond', serif;
        font-weight: 600;
        font-size: 2rem;
    }

    .btn-add {
        background: var(--color-forest);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        letter-spacing: 0.04em;
        color: var(--color-cream);
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(88, 98, 74, 0.25);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(88, 98, 74, 0.35);
        background: var(--color-charcoal);
        color: var(--color-cream);
    }

    /* Table Styles */
    .table-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table thead {
        background: #000000;
    }

    .table thead th {
        color: #FFFFFF !important;
        font-weight: 600;
        padding: 1.25rem 1rem;
        border: none;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 1px;
    }

    .table tbody tr:hover {
        background: rgba(230, 234, 221, 0.5);
    }

    /* Avatar */
    .avatar-wrapper {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid var(--color-forest);
    }

    /* DataTables Custom Styles */
    .dataTables_wrapper {
        padding: 1.5rem;
    }

    .dataTables_paginate .paginate_button.current {
        background: var(--color-charcoal) !important;
        color: white !important;
        border-color: var(--color-charcoal) !important;
    }

    .dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) {
        background: var(--color-forest) !important;
        color: white !important;
    }
</style>
@endpush

@section('content')
    <div class="users-container">
        <div class="container">
            <!-- Header -->
            <div class="users-header">
                <div class="header-content">
                    <div class="header-title">
                        <div class="title-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h1>{{ __('Users') }}</h1>
                    </div>
                    <button class="btn btn-add" onclick="execute('{{ route('users.create') }}')">
                        <i class="bi bi-person-plus-fill"></i>
                        <span>{{ __('Agregar Usuario') }}</span>
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="table-container">
                <div class="table-responsive">
                    <table id="myTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('Avatar') }}</th>
                                <th>{{ __('Nombre') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Rol') }}</th>
                                <th>{{ __('Registro') }}</th>
                                <th class="text-center">{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $('#myTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route("users.data") }}',
                    type: 'GET',
                    error: function(xhr, error, thrown) {
                        console.error('DataTables Ajax error (users):', error, thrown, xhr.responseText);
                        alert('Error al cargar usuarios. Revisa la consola del navegador o captura en el servidor.');
                    }
                },
                columns: [
                    {
                        data: 'avatar',
                        orderable: false,
                        searchable: false,
                        width: '80px'
                    },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'role' },
                    { data: 'created_at' },
                    {
                        data: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                order: [[1, 'asc']],
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });

            function execute(url) {
                window.open(url, '_self');
            }

            function confirmToggleStatus(url, action) {
                const message = action === 'desactivar' 
                    ? '⚠️ ¿Estás seguro de desactivar esta cuenta? El usuario no podrá iniciar sesión.'
                    : '✅ ¿Estás seguro de activar esta cuenta?';
                
                if (confirm(message)) {
                    $('<form>', { 'action': url, 'method': 'POST' })
                        .append($('<input>', { type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
                        .appendTo('body')
                        .submit()
                        .remove();
                }
            }

            function deleteRecord(url) {
                if (confirm('⚠️ ¿Estás seguro de eliminar este usuario?')) {
                    $('<form>', { 'action': url, 'method': 'POST' })
                        .append($('<input>', { type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
                        .append($('<input>', { type: 'hidden', name: '_method', value: 'DELETE' }))
                        .appendTo('body')
                        .submit()
                        .remove();
                }
            }
        </script>
    @endpush
@endsection