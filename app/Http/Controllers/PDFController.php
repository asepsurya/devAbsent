<?php

namespace App\Http\Controllers;

use PDF;
use TCPDF;
use Carbon\Carbon;
use App\Models\gtk;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\User;
use App\Models\Event;
use App\Models\Kelas;
use App\Models\tasks;
use App\Models\absent;
use App\Models\Lesson;
use App\Models\student;
use App\Models\setelanHari;
use App\Models\JamPelajaran;
use Illuminate\Http\Request;
use App\Models\ClassRoomPeople;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;


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
        // Get the current date and time
    $created = Carbon::now()->translatedFormat('l, d F Y H:i:s');

    // Fetch data
    $students = Student::with('absentRFID')->get();
    $holidays = Event::all();

    // Check if 'type' request is "cetak"
    if (request('type') == "cetak") {
        // Return the view as HTML for printing
        return view('exportPDF.ReportAbsesiRfid', [
            'created' => $created,
            'students' => $students,
            'holiday' => $holidays
        ]);
    } else {
        // Prepare data for the PDF
        $data = [
            'created' => $created,
            'students' => $students,
            'holiday' => $holidays
        ];

        // Set DOMPDF options
        $options = new Options();
        $options->set('image-cache', storage_path('app/pdf_cache'));  // Enable image caching
        $options->set('isHtml5ParserEnabled', true);  // Enable HTML5 parser
        $options->set('isPhpEnabled', true);  // Enable PHP functions (for handling images)
        $options->set('image-dpi', 150);  // Change DPI for better image quality

        // Initialize Dompdf with the specified options
        $dompdf = new Dompdf($options);

        // Load the view with the data and render the HTML content
        $htmlContent = view('exportPDF.ReportAbsesiRfid', $data)->render();

        // Load HTML content into DOMPDF
        $dompdf->loadHtml($htmlContent);

        // Set paper size and orientation (A4 landscape)
        $dompdf->setPaper('A4', 'landscape');

        // Render the PDF (first pass: load HTML, second pass: render the PDF)
        $dompdf->render();

        // Output the PDF to the browser for download
        return $dompdf->stream('Absensi_Siswa_' . Carbon::now()->format('Ymd') . '-' . rand(1000, 9999) . '.pdf');
    }


    }
    public function reportAbsentKelas(){
           // Get the current date and time
            $created = Carbon::now()->translatedFormat('l, d F Y H:i:s');

            // Fetch data
            $students = Student::with('absentMapel')->get();
            $holidays = Event::all();

            // Check if 'type' request is "cetak"
            if (request('type') == "cetak") {
                // Return the view as HTML for printing
                return view('exportPDF.ReportAbsesiRfid', [
                    'created' => $created,
                    'students' => $students,
                    'holiday' => $holidays
                ]);
            } else {
                // Prepare data for the PDF
                $data = [
                    'created' => $created,
                    'students' => $students,
                    'holiday' => $holidays
                ];

                // Set DOMPDF options
                $options = new Options();
                $options->set('image-cache', storage_path('app/pdf_cache'));  // Enable image caching
                $options->set('isHtml5ParserEnabled', true);  // Enable HTML5 parser
                $options->set('isPhpEnabled', true);  // Enable PHP functions (for handling images)
                $options->set('image-dpi', 150);  // Change DPI for better image quality

                // Initialize Dompdf with the specified options
                $dompdf = new Dompdf($options);

                // Load the view with the data and render the HTML content
                $htmlContent = view('exportPDF.ReportAbsesiKelas', $data)->render();

                // Load HTML content into DOMPDF
                $dompdf->loadHtml($htmlContent);

                // Set paper size and orientation (A4 landscape)
                $dompdf->setPaper('A4', 'landscape');

                // Render the PDF (first pass: load HTML, second pass: render the PDF)
                $dompdf->render();

                // Output the PDF to the browser for download
                return $dompdf->stream('Absensi_Siswa_' . Carbon::now()->format('Ymd') . '-' . rand(1000, 9999) . '.pdf');
            }
    }

    public function generateJadwal($id_kelas)
    {
        $cek = Kelas::where('id',$id_kelas)->with('jurusanKelas')->get();
        foreach($cek as $item){
            $kelas =  $item->nama_kelas.' '.$item->jurusanKelas->nama_jurusan.' '. $item->sub_kelas;
        }

        $jadwal = Lesson::where('id_rombel',$id_kelas)->orderBy('day', 'asc')->with(['mata_pelajaran','guru','ref'])->get();
        $hari = setelanHari::where('status',1)->get();
        $jam =JamPelajaran::all();
        $title = $kelas;
        // Load Blade view and pass data
        $pdf = app('dompdf.wrapper')->loadView('exportPDF.jadwal', compact('jadwal','hari','jam','title'));

        // Stream PDF to browser
        return $pdf->stream('jadwal_pelajaran.pdf');


    }

    private function generateScheduleTable($id_kelas)
    {
        // Fetch data from the database
        $jadwal = \App\Models\Lesson::where('id_rombel', $id_kelas)
            ->orderBy('day', 'asc')
            ->with(['mata_pelajaran', 'guru', 'ref'])
            ->get();

        $hari = \App\Models\setelanHari::where('status', 1)->get();
        $jam = \App\Models\JamPelajaran::all();

        // Create HTML table structure
        $html = '
        <table border="1" cellpadding="5">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jam</th>';

        // Add the day names dynamically from the $hari variable
        foreach ($hari as $h) {
            // Map the id_hari to the day name
            $dayName = '';
            switch ($h->id_hari) {
                case 1:
                    $dayName = 'Senin';
                    break;
                case 2:
                    $dayName = 'Selasa';
                    break;
                case 3:
                    $dayName = 'Rabu';
                    break;
                case 4:
                    $dayName = 'Kamis';
                    break;
                case 5:
                    $dayName = 'Jumat';
                    break;
                case 6:
                    $dayName = 'Sabtu';
                    break;
                case 7:
                    $dayName = 'Minggu';
                    break;
                default:
                    $dayName = 'Tidak Diketahui';
            }

            $html .= '<th>' . $dayName . '</th>';
        }

        $html .= '
                </tr>
            </thead>
            <tbody>';

        $no = 1;
        foreach ($jam as $b) {
            $html .= '<tr>
                <td>' . $no++ . '</td>
                <td>' . $b->jam_mulai . ' - ' . $b->jam_berakhir . '</td>';

            // Loop through days (hari)
            foreach ($hari as $a) {
                $scheduleFound = false;
                $html .= '<td>';

                // Filter jadwal for current day
                $jadwalForDay = $jadwal->where('day', $a->id_hari)->where('id_jam', $b->jam_ke);

                // Check if there's a matching schedule
                if ($jadwalForDay->isNotEmpty()) {
                    foreach ($jadwalForDay as $jadwalItem) {
                        if ($jadwalItem->mata_pelajaran) {
                            $html .= $jadwalItem->mata_pelajaran->nama ?? 'N/A';
                        } else {
                            $html .= $jadwalItem->ref->ref;
                        }
                        $scheduleFound = true;
                        break;
                    }
                }

                // If no schedule found, display a dash
                if (!$scheduleFound) {
                    $html .= '-';
                }

                $html .= '</td>';
            }

            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        return $html;
    }

    public function generateScore($id){

        $task = tasks::where('id_kelas',$id)->orderBy('id', 'DESC')->with(['media','links','user'])->get();  // Fetch all tasks
        $peserta = ClassRoomPeople::where('id_kelas',$id)->with('peopleStudent')->get();  // Fetch all participants

        // Load the HTML view to render the table
        $pdf = PDF::loadView('exportPDF.studentScore', compact('task', 'peserta','id'))
         ->setPaper('a4', 'landscape');  // Set landscape orientation

        // Download the generated PDF
        return $pdf->download('export.pdf');

    }




}

