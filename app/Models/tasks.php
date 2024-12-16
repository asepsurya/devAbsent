<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tasks extends Model
{
    use HasFactory;
    protected $fillable = [
        'judul',
        'description',
        'id_kelas',
        'created_by',
        'poin',
        'due_date',
        'type',
    ];

    public function media(){
        return $this->Hasmany('App\Models\tasksmedia','task_id','id');
    }
    public function links(){
        return $this->belongsTo('App\Models\taskslink','id','task_id');
    }
    public function user(){
        return $this->belongsTo('App\Models\User','created_by','nomor');
    }

}
