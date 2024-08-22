<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class walikelas extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function gtk(){
        return $this->belongsTo('App\Models\gtk','id_gtk','id');
    }
    public function tahun_ajar(){
        return $this->belongsTo('App\Models\TahunPelajaran','id_tahun_pelajaran','id');
    }
    public function kelas(){
        return $this->belongsTo('App\Models\Kelas','id_kelas','id');
    }
}
