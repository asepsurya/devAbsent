<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class kelaslistController extends Controller
{
    public function kelaslist(){
        return view('datakelas.index',[
            'title'=> 'Data Kelas',
            'kelas'=>Kelas::orderBy('id', 'DESC')->with(['jurusanKelas','jmlRombel'])->get(),
            'jurusans'=>Jurusan::where('status','1')->get()

        ]);
    }

    public function kelaslistdetail(){
        return view('datakelas.detail',[
            'title'=>'Detail Kelas'
        ]);
    }
}
