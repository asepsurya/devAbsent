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
        return $this->Hasmany('App\Models\absent','id_rfid','id_rfid');
    }
    public function absentMapel(){
        return $this->Hasmany('App\Models\absentMapel','nis','nis');
    }

    public function classTime(){
        return $this->belongsTo('App\Models\inOutTime','id_kelas','id_kelas');
    }

    public function studentUser(){
        return $this->belongsTo('App\Models\User','nis','nomor');
    }

    public function jadwalStudent(){
        return $this->hasMany('App\Models\Lesson','id_rombel','id_kelas');
    }

    public function notRFID(){
        return $this->hasMany('App\Models\absent','uid','nis');
    }
    public function rombelAbsent(){
        return $this->hasMany('App\Models\absent','uid','nis');
    }

    public function tahun_lulus(){
        return $this->belongsTo('App\Models\TahunPelajaran','id_tahun_ajar','id');
    }

}
