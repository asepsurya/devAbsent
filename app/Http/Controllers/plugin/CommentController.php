<?php

namespace App\Http\Controllers\plugin;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = Comment::create([
            'comment' => $request->comment,
            'user_id' => $request->user_id,
            'username' => $request->username,
            'task_id' => $request->task_id,
            'parent_id' => $request->parent_id
        ]);

        // Ambil ulang data lengkap untuk respons
        $comment = Comment::with(['gtkFoto', 'studentFoto'])->find($comment->id);

        return response()->json([
            'success' => true,
            'comment' => $comment
        ]);
    }
    public function index(request $request)
    {
        $taskId = $request->query('task_id');

        $comments = Comment::with(['studentFoto', 'gtkFoto'])
            ->where('task_id', $taskId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }
}
