@push('styles')
<style>
    .comments-container {
        background: var(--color-cream);
        min-height: calc(100vh - 76px);
        padding: 2rem 0;
        margin: 0 -15px;
    }

    .comments-header {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .header-content {
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
        background: rgba(230,234,221,0.5);
    }

    .badge-forest { background: var(--color-forest); color: white; }
    .badge-tan { background: var(--color-tan); color: white; }
</style>
@endpush

<x-layout>
    <div class="comments-container">
        <div class="container">
            <!-- Header -->
            <div class="comments-header">
                <div class="header-content">
                    <div class="title-icon">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>
                    <div class="header-title">
                        <h1>{{ __('Comments') }}</h1>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="px-4">ID</th>
                                <th>{{ __('Usuario') }}</th>
                                <th>{{ __('Producto') }}</th>
                                <th>{{ __('Rating') }}</th>
                                <th>{{ __('Contenido') }}</th>
                                <th>{{ __('Estado') }}</th>
                                <th class="text-center px-4">{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($comments as $comment)
                            <tr>
                                <td class="px-4 py-3 align-middle">#{{ $comment->id }}</td>
                                <td class="py-3 align-middle fw-bold">{{ $comment->user->name }}</td>
                                <td class="py-3 align-middle text-muted small">{{ Str::limit($product_name = $comment->product->name ?? 'N/A', 40) }}</td>
                                <td class="py-3 align-middle">
                                    <div class="text-tan" title="{{ $comment->rating }} estrellas">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $comment->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </div>
                                </td>
                                <td class="py-3 align-middle" style="max-width: 300px;">
                                    <div class="text-truncate" title="{{ $comment->content }}">{{ $comment->content }}</div>
                                </td>
                                <td class="py-3 align-middle">
                                    <span class="badge rounded-pill {{ $comment->status == 'approved' ? 'badge-forest' : ($comment->status == 'pending' ? 'badge-tan' : 'bg-danger') }}">
                                        {{ ucfirst($comment->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center align-middle">
                                    <div class="btn-group" role="group">
                                        @if($comment->status != 'approved')
                                        <form action="{{ route('admin.comments.update', $comment) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-outline-success me-1" title="Aprobar" style="border-radius: 8px;">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @if($comment->status != 'rejected')
                                        <form action="{{ route('admin.comments.update', $comment) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-outline-warning me-1" title="Rechazar" style="border-radius: 8px;">
                                                <i class="bi bi-x-octagon"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar este comentario?')" style="border-radius: 8px;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">{{ __('No hay comentarios aún.') }}</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</x-layout>
