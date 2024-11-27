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
    public function reportAbsensiAll(Request $request)
    {

        return view('report.absents', [

            'title' => 'Laporan Absensi',
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->with('jurusanKelas')->get(),
            'created' => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'students' => student::all(),
            'holiday'=>Event::all()

        ]);
    }
}
