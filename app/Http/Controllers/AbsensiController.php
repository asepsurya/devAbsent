<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function absensiStudent(){
        return view('absensi.student',[
            'title'=>'Absensi Siswa',
        ]);
    }
    public function absensiTeacher(){
        return view('absensi.teacher',[
            'title'=>'Absensi Guru',
        ]);
    }
}
