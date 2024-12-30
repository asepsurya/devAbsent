<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fileTugas extends Model
{
    protected $guarded=['id'];

    public function student(){
        return $this->HasMany('App\Models\student','nis','student_id');
    }
}
