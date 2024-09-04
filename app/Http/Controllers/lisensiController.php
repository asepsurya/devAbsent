<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lisensi;
use Irfa\SerialNumber\Func\SerialNumber;
use Alert;
class lisensiController extends Controller
{
    public function lisensiIndex(Request $request){

            return view('lisensi.index',[
                'title'=>'Lisensi',
                'lisensi'=>lisensi::where(['status'=>'1'])->get()
            ]);

    }
    public function lisensiIndexGet(request $request){
         // generate Serial Number
         $sn = new SerialNumber();
         $newLisensi = $sn->generate();
         // Cek Lisensi Apakah Sudah Ada ?
         $cek = lisensi::where(['instansi'=>'SMK SATYA BHAKTI'])->get();
         // jika Belum Terdaftar Otomatis Mengenerate Serial Number yang Baru
         if($cek->count() == 0){
             lisensi::create([
                 'instansi'=>'SMK SATYA BHAKTI',
                 'lisensi'=>$newLisensi,
                 'status'=>'1'
             ]);
         }
         return redirect()->back();
    }
}
