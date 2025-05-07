<?php

namespace App\Http\Controllers;

use mPDF;
use TCPDF;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\gtk;
use Dompdf\Options;
use App\Models\User;
use App\Models\Event;
use App\Models\Kelas;
use App\Models\Mapel;
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

        return view('exportPDF.datagtk', $data);
           //return $pdf->download('export-gtks-' . Carbon::now()->format('YmdHis') . '.pdf');
    }

    public function generatePDFSiswaAll() {

        if (request('kelas')) {
            $students = student::where('id_kelas', request('kelas'))
                ->orderBy('nama', 'asc')
                ->get();
        } else {
            $students = student::orderBy('nama', 'asc')
                ->get();
        }
        
        App::setLocale('id');
        $data = [
            'title' => 'Data Siswa',
            'date'  => Carbon::now()->translatedFormat('l, d F Y H:i:s'),
            'students' => $students,
            
        ];
        
        return view('exportPDF.datasiswa', $data);
        
        
    }
    public function generatePDFRFIDstudents(){
        // Get the current date and time
        $created = Carbon::now()->translatedFormat('l, d F Y H:i:s');

        // Fetch data
        $students = Student::with('absentRFID')->get();
        $holidays = Event::all();

        return view('exportPDF.ReportAbsesiRfid', [
            'created' => $created,
            'students' => $students,
            'holiday' => $holidays
        ]);


    }
    public function reportAbsentKelas()
    {
        // Get the current date and time
        $created = Carbon::now()->translatedFormat('l, d F Y H:i:s');

        // Fetch data
        $students = Student::with('absentMapel')->where('id_kelas',request('kelas'))->get();
        $holidays = Event::all();
        $kelas = kelas::where('id',request('kelas'))->first();
        $mapel = Mapel::where('id',request('mapel'))->first();
            // Prepare data for the PDF
            $data = [
                'created' => $created,
                'students' => $students,
                'holiday' => $holidays,
                'kelas' => $kelas,
                'mapel' => $mapel
            ];
            // Load the HTML content for the PDF   
             return view('exportPDF.ReportAbsesiKelas', $data);

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

        return view('exportPDF.jadwal',compact('jadwal','hari','jam','title'));

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

        return view('exportPDF.studentScore', compact('task', 'peserta','id'));
       

    }

    public function generatePDFRFIDgtk(){
        $created = Carbon::now()->translatedFormat('l, d F Y H:i:s');

        // Fetch data
        $students = gtk::with('absentRFID')->get();
        $holidays = Event::all();
        $data = [
            'created' => $created,
            'students' => $students,
            'holiday' => $holidays
        ];
        return view('exportPDF.ReportAbsesiRfidGTK', $data);

    }

    public function reportstudent(){
        return view('report.siswa',[
            'title'=>'Laporan Data Siswa',
            'kelas'=>Kelas::with(['jurusanKelas'])->get()
        ]);
    }
    public function reportgtk(){
        return view('report.guru',[
            'title'=>'Laporan GTK',
        ]);
    }


}

