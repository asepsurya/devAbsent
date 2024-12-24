<?php

namespace App\Http\Controllers;

use PDF;
use TCPDF;
use Carbon\Carbon;
use App\Models\gtk;
use Dompdf\Options;
use App\Models\User;
use App\Models\Event;
use App\Models\Kelas;
use App\Models\tasks;
use App\Models\absent;
use App\Models\student;
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
        return $pdf->stream('Absensi_Siswa_' . Carbon::now()->format('Ymd') . '-' . rand(1000, 9999) . '.pdf');

        }

    }

    public function generateJadwal($id_kelas)
    {
        // Create a new TCPDF instance
        $pdf = new TCPDF();
    
        // Set document properties
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Schedule Report');
    
        // Add a page (landscape orientation)
        $pdf->AddPage('L', 'A4');

        // Set the font for the school name
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->SetXY(50, 15);  // Position of the text
    
  
        // Add some space before the main content
        $pdf->Ln(30); // 30 units to ensure the next content is well spaced
    
        // Set font for the schedule table
        $pdf->SetFont('helvetica', '', 10);
    
        // Prepare the HTML content (replace this with your actual data)
        $html = $this->generateScheduleTable($id_kelas);
    
        // Output the HTML content into the PDF
        $pdf->writeHTML($html, true, false, true, false, '');
    
        // Add signature and QR code at the end
        $pdf->Ln(20); // Add some space before the signature
    
        // Set the font for the signature text
        $pdf->SetFont('helvetica', 'I', 10);
        $pdf->Cell(0, 10, 'Kepala Sekolah', 0, 1, 'L');
        
        // Add signature image (replace with actual path to the signature image)
        $pdf->Image('path_to_signature.jpg', 40, $pdf->GetY(), 50, 20);  // Adjust coordinates and dimensions
    
        // Generate a smaller QR Code for the headmaster's signature (you can replace '1234567890' with actual data)
        $pdf->SetXY(120, $pdf->GetY());  // Adjust position for QR code
        $pdf->write2DBarcode('1234567890', 'QRCODE,L', '', '', 30, 30, [], 'N');  // QR Code with data and size (smaller size)
    
        // Add the "Ditandatangani Secara Elektronik" text below the QR code
        $pdf->SetXY(0, $pdf->GetY() + 35); // Position text under QR Code
        $pdf->SetFont('helvetica', 'I', 8);
        $pdf->Cell(0, 10, 'Ditandatangani Secara Elektronik', 0, 1, 'C');  // Text centered below QR code
    
        // Close and output PDF document
        return $pdf->Output('schedule_report.pdf', 'I'); // Display PDF in browser
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

