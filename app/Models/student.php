<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function kota(){
        return $this->belongsTo('App\Models\Regency','id_kota','id');
    }
    public function kecamatan(){
        return $this->belongsTo('App\Models\District','id_kecamatan','id');
    }
    public function desa(){
        return $this->belongsTo('App\Models\Village','id_desa','id');
    }
    public function absent(){
        return $this->belongsTo('App\Models\absent','id_rfid','id_rfid');
    }

    public function rombelstudent(){
        return $this->belongsTo('App\Models\rombel','nis','nis');
    }

    public function getKelas(){
        return $this->belongsTo('App\Models\Kelas','id_kelas','id');
    }

    public function absentRFID(){
        return $this->Hasmany('App\Models\absent','id_rfid','nis');
    }

    public function studentUser(){
        return $this->belongsTo('App\Models\User','nis','nomor');
    }

}
