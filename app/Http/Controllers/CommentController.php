<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin'])->except(['store']);
        $this->middleware(['auth'])->only(['store']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'content' => 'required|string|min:5|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'content' => $request->content,
            'rating' => $request->rating,
            'status' => 'pending', // Comments are pending by default
        ]);

        return redirect()->back()->with('success', 'Tu comentario ha sido enviado y está pendiente de moderación.');
    }

    public function index()
    {
        $comments = Comment::with(['user', 'product'])->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.comments.index', compact('comments'));
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $comment->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Estado del comentario actualizado.');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Comentario eliminado.');
    }
}
