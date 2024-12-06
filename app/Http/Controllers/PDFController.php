<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;
use PDF;
use Dompdf\Options;
use Illuminate\Support\Facades\App;
use App\Models\gtk;
use App\Models\student;
use App\Models\Event;
use App\Models\Kelas;
use App\Models\absent;


class PDFController extends Controller
{
    // #region ExportUsers
    public function generatePDFUserAll() {
        $users = User::orderBy('nama', 'asc')
        ->get();

        App::setLocale('id');
        $data = [
            'title' => 'Data Users',
            'date'  => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'users' => $users
        ];

        $pdf = PDF::loadView('exportPDF.users', $data)
        ->setPaper('a4', 'landscape')
        ->setWarnings(false);

        return $pdf->stream('users-all-' . Carbon::now()->format('YmdHis') . '.pdf');
        //return $pdf->download('users-all-' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    public function generatePDFUserAdmin() {
        $users = User::whereIn('role', ['superadmin', 'admin'])
        ->orderBy('nama', 'asc')
        ->get();

        App::setLocale('id');
        $data = [
            'title' => 'Data Users Admin',
            'date'  => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'users' => $users
        ];

        $pdf = PDF::loadView('exportPDF.users', $data)
        ->setPaper('a4', 'landscape')
        ->setWarnings(false);

        return $pdf->stream('users-admin-' . Carbon::now()->format('YmdHis') . '.pdf');
        //return $pdf->download('users-admin-' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    public function generatePDFUserWalikelas() {
        $users = User::where([
            'role' => 'walikelas',
        ])
        ->orderBy('nama', 'asc')
        ->get();

        App::setLocale('id');
        $data = [
            'title' => 'Data Users Walikelas',
            'date'  => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'users' => $users
        ];

        $pdf = PDF::loadView('exportPDF.users', $data)->setPaper('a4', 'landscape');
        return $pdf->stream('users-walikelas-' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    public function generatePDFUserGuru() {
        $users = User::whereIn('role', ['walikelas', 'guru'])
        ->orderBy('nama', 'asc')
        ->get();

        App::setLocale('id');
        $data = [
            'title' => 'Data Users Guru',
            'date'  => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'users' => $users
        ];

        $pdf = PDF::loadView('exportPDF.users', $data)
        ->setPaper('a4', 'landscape')
        ->setWarnings(false);

        return $pdf->stream('users-guru-' . Carbon::now()->format('YmdHis') . '.pdf');
        //return $pdf->download('users-guru-' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    public function generatePDFUserSiswa() {
        $users = User::where([
            'role' => 'siswa',
        ])
        ->orderBy('nama', 'asc')
        ->get();

        App::setLocale('id');
        $data = [
            'title' => 'Data Users Siswa',
            'date'  => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'users' => $users
        ];

        $pdf = PDF::loadView('exportPDF.users', $data)
        ->setPaper('a4', 'landscape')
        ->setWarnings(false);

        return $pdf->stream('users-siswa-' . Carbon::now()->format('YmdHis') . '.pdf');
        //return $pdf->download('users-siswa-' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    // #endregion ExportUsers

    public function generatePDFGTKAll() {
        $gtks = gtk::orderBy('nama', 'asc')
        ->get();

        App::setLocale('id');
        $data = [
            'title' => 'Data Guru',
            'date'  => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'gtks' => $gtks
        ];

        $pdf = PDF::loadView('exportPDF.datagtk', $data)
        ->setPaper('a4', 'landscape')
        ->setWarnings(false);


        return $pdf->stream('export-gtks-' . Carbon::now()->format('YmdHis') . '.pdf');
        //return $pdf->download('export-gtks-' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    public function generatePDFSiswaAll() {
        $students = student::orderBy('nama', 'asc')
        ->get();

        App::setLocale('id');
        $data = [
            'title' => 'Data Siswa',
            'date'  => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'students' => $students
        ];

        $pdf = PDF::loadView('exportPDF.datasiswa', $data)
        ->setPaper('a4', 'landscape')
        ->setWarnings(false);

        return $pdf->stream('export-students-' . Carbon::now()->format('YmdHis') . '.pdf');
        //return $pdf->download('export-students-' . Carbon::now()->format('YmdHis') . '.pdf');
    }
    public function generatePDFRFIDstudents(){
        if(request('type') == "cetak"){
            return view('exportPDF.ReportAbsesiRfid',[
            'created' => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'students' => student::with('absentRFID')->get(),
            'holiday'=>Event::all()
            ]);
        }else{

        
        $data = [
            'created' => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'students' => student::with('absentRFID')->get(),
            'holiday'=>Event::all()
        ];
        $options = new Options();
        $options->set('image-cache', storage_path('app/pdf_cache'));

        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('image-cache', true); // Enable caching for images
        $options->set('image-dpi', 150); // Change DPI (dots per inch)

        $pdf = PDF::loadView('exportPDF.ReportAbsesiRfid', $data);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        // Tampilkan di browser
        return $pdf->stream('Laporan-AbsensiRDIFSiswa'.  Carbon::now()->format('YmdHis') .'-'.rand().'.pdf');

        }

    }

}

