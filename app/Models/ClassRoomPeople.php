<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoomPeople extends Model
{
    protected $guarded=['id'];

    public function peopleStudent(){
        return $this->belongsTo('App\Models\student','nis','nis');
    }

    public function getClass(){
        return $this->HasMany('App\Models\ClassRoom','class_code','id_kelas');
    }
    public function getScore(){
        return $this->HasMany('App\Models\StudentScore','student_id','nis');
    }
    
}
