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
        'comment', 'user_id', 'username', 'task_id', 'parent_id'
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



    // Balasan rekursif untuk nested comments
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive', 'gtkFoto', 'studentFoto');
    }

    // Relasi ke user GTK
    public function gtkFoto()
    {
        return $this->belongsTo('App\Models\gtk','user_id','nik');
    }

    // Relasi ke user Student
    public function studentFoto()
    {
        return $this->belongsTo('App\Models\student','user_id','nis');
    }
}
