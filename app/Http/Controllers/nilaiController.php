<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class nilaiController extends Controller
{
    public function index(){
        return view('nilai.index',[
            'title'=> 'Manajement Penilaian'
        ]);
    }
}
