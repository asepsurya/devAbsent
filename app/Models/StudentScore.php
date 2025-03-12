<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentScore extends Model
{
    protected $guarded=['id'];

    public function StudentScore(){
        return $this->belongsTo('App\Models\tasks','task_id','id');
    }
}
