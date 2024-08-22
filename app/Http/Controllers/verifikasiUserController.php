<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class verifikasiUserController extends Controller
{
    public function verifikasiUser(){
        return view('verifikasiPengguna.index',[
            'title' => 'Verifikasi Pengguna',
            'users'=>User::where('status','1')->orderBy('id', 'DESC')->with(['student'])->get()
        ]);

    }
    public function verifikasiUpdate($id){
        User::where('nomor',$id)->update(['status'=>'2']);
        toastr()->success('Pengguna Dapat Menggunakan Aplikasi');
        return redirect()->back();
    }
}
