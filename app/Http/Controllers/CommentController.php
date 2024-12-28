<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {

        // Save the comment to the database
        $comment = Comment::create([
            'user_id' => $request->user_id,
            'comment' => $request->comment,
            'kelas_id' => $request->id_kelas,
            'task_id' => $request->task_id,
        ]);

        // Return the comment data as JSON
        return response()->json([
            'success' => true,
            'comment' => $comment,
        ]);
    }
    public function index(request $request)
    {
         // Validate the incoming task_id
         $request->validate([
            'task_id' => 'required|integer|exists:tasks,id',  // Ensure task_id is valid
        ]);

        // Fetch the comments related to the provided task_id
        $taskId = $request->input('task_id');
        $comments = Comment::where('task_id', $taskId)
            ->with('user','student','gtk')  // Assuming each comment has a related user
            ->latest()
            ->get();

        // Return the comments as JSON response
        return response()->json([
            'success' => true,
            'comments' => $comments->map(function ($comment) {
                return [
                    'username' => $comment->user->nama,  // Or comment->username if not using relation
                    'comment' => $comment->comment,
                    'gtkFoto'=>$comment->gtk ?? '' ,
                    'studentFoto'=>$comment->student ?? ''  ,
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
            }),
        ]);
    }
}
