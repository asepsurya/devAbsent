<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\gtk;
use App\Models\Event;
use App\Models\Kelas;
use App\Models\absent;
use App\Models\student;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;

class reportController extends Controller
{
    public function reportRFIDStudent(Request $request)
    {
        return view('report.RFIDstudent', [
            'title' => 'Laporan Absensi',
            'created' => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'students' => student::with('absentRFID')->get(),
            'holiday'=>Event::all()
        ]);
    }

    public function reportRFIDTeacher(request $request){
        return view('report.RFIDTeacher', [
            'title' => 'Laporan Absensi',
            'created' => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'students' => gtk::with('absentRFID')->get(),
            'holiday'=>Event::all()
        ]);
    }
    public function reportAbsentStudent(){
        return view('report.studentAbsent', [
            'title' => 'Laporan Absensi',
            'tahunpelajaran' => TahunPelajaran::all(),
            'students' => gtk::with('absentRFID')->get(),
            'holiday'=>Event::all()
        ]);
    }
}
