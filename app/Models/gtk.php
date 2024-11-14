<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gtk extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function Usergtk(){
        return $this->belongsTo('App\Models\User','nik','nomor');
    }
    public function kota(){
        return $this->belongsTo('App\Models\Regency','id_kota','id');
    }
    public function kecamatan(){
        return $this->belongsTo('App\Models\District','id_kecamatan','id');
    }
    public function desa(){
        return $this->belongsTo('App\Models\Village','id_desa','id');
    }
    public function Mapelgtk(){
        return $this->belongsTo('App\Models\grupMapel','nik','id_gtk');
    }
    public function MapelgtkList(){
        return $this->hasMany('App\Models\grupMapel','id_gtk','nik');
    }

    public function absent(){
        return $this->belongsTo('App\Models\absent','id_rfid','id_rfid');
    }
    public function rombelAbsent(){
        return $this->hasMany('App\Models\absent','id_rfid','id_rfid');
    }


}
