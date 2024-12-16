<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoomPeople extends Model
{
    protected $guarded=['id'];

    public function peopleStudent(){
        return $this->belongsTo('App\Models\student','nis','nis');
    }
}
