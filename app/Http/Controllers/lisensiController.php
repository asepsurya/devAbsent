<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lisensi;
use Irfa\SerialNumber\Func\SerialNumber;
use Carbon\Carbon;
use Alert;
class lisensiController extends Controller
{
    public function lisensiIndex(Request $request){

            return view('lisensi.index',[
                'title'=>'Lisensi',
                'lisensi'=>lisensi::where(['instansi_id'=>'20271907'])->get()
            ]);
    }
    public function lisensiIndexGet(request $request){
         // generate Serial Number
         $sn = new SerialNumber();
         $newLisensi = $sn->generate();

         // Cek Lisensi Apakah Sudah Ada ?
         $cek = lisensi::where(['instansi_id'=>'20271907'])->get();

         // Menghitung expired
         $today = Carbon::now()->toDateString();
         $nextYear = Carbon::now()->addYear()->toDateString(); // Aktivasi 1 Tahun
         $nextMont =  Carbon::now()->addMonth()->toDateString(); // Aktivasi 1 Bulan

         // jika Belum Terdaftar Otomatis Mengenerate Serial Number yang Baru
         if($cek->count() == 0){
             lisensi::create([
                 'instansi_id'=>'20271907',
                 'instansi'=>'SMK SATYA BHAKTI',
                 'lisensi'=>$newLisensi,
                 'subscription_type'=>'2',
                 'expired'=>$nextYear,
                 'status'=>'1',
             ]);
         }
         return redirect()->back();
    }
}
