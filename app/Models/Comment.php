<?php

namespace App\Models;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'comment'
    ];

    // Relationship with User model
    public function user(){
        return $this->belongsTo('App\Models\User','user_id','nomor');
    }
    public function gtk(){
        return $this->belongsTo('App\Models\gtk','user_id','nik');
    }
    public function student(){
        return $this->belongsTo('App\Models\student','user_id','nis');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);  // A user can have many comments
    }
}
