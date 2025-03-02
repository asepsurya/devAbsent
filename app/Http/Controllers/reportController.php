<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\gtk;
use App\Models\Event;
use App\Models\Kelas;
use App\Models\absent;
use App\Models\rombel;
use App\Models\student;
use App\Models\grupMapel;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;

class reportController extends Controller
{
    public function reportRFIDStudent(Request $request)
    {

        return view('report.RFIDstudent', [
            'title' => 'Laporan Absensi',
            'created' => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'students' => student::with(['absentRFID','classTime'])->paginate(20)->appends(request()->query()),
            'holiday'=>Event::all(),
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
        $kelas = Kelas::with(['jurusanKelas'])->get();
        $mapel =grupMapel::where('id_kelas',request('kelas'))->get();


        return view('report.studentAbsent', [
            'title' => 'Laporan Absensi',
            'tahunpelajaran' => TahunPelajaran::all(),
            'students' => student::where('id_kelas', request('kelas'))->get(),
            'holiday'=>Event::all()
        ],compact('kelas','mapel'));
    }
}
