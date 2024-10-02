<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rombel extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function rombelStudent(){
        return $this->belongsTo('App\Models\student','nis','nis');
    }

    // public function absent(){
    //     return $this->belongsTo('App\Models\absent','id_rfid','id_rfid');
    // }
    public function notRFID(){
        return $this->hasMany('App\Models\absent','id_rfid','nis');
    }
    public function rombelAbsent(){
        return $this->hasMany('App\Models\absent','id_rfid','id_rfid');
    }
    public function rombelAbsentClass(){
        return $this->hasMany('App\Models\absentMapel','nis','nis');
    }
    public function getkelas(){
        return $this->belongsTo('App\Models\Kelas','id_kelas','id');
    }

}
