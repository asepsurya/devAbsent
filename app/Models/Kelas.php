<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function jurusanKelas(){
        return $this->belongsTo('App\Models\Jurusan','id_jurusan','id');
    }
    public function jmlRombel(){
        return $this->hasMany('App\Models\rombel','id_kelas','id');
    }
    public function walikelas(){
        return $this->belongsTo('App\Models\walikelas','id','id_kelas');
    }

}
