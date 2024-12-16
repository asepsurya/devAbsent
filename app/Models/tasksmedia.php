<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tasksmedia extends Model
{
    protected $fillable = ['task_id', 'file_path','name','size','exstention'];
}
