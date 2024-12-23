<?php

namespace App\Http\Controllers\setelanHari;

use App\Models\JamPelajaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class setelanHariController extends Controller
{
    public function index(){
        return view('jadwal.jampelajaran',[
            'title'=>'Setelan Jam Pelajaran',
            'data'=>JamPelajaran::where('status',1)->get()
        ]);
    }
}
