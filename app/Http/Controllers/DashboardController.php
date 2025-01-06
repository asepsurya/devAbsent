<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\gtk;
use App\Models\Event;
use App\Models\Kelas;
use App\Models\tasks;
use App\Models\absent;
use App\Models\Lesson;
use App\Models\rombel;
use App\Models\student;
use App\Models\ClassRoom;
use App\Models\inOutTime;
use Illuminate\Http\Request;
use App\Models\absentsHistory;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard.index',[
            'title'=>'Dashboard',
        ]);
    }

    public function Studentindex(){

                // Get the authenticated user's RFID ID
        $userId = auth()->user()->student->id_rfid ?? 'NULL';
     // Get the attendance records for this RFID
        $attendanceRecords = absent::where('id_rfid', $userId)->get();

        // Initialize counters for attendance status
        $present = 0;
        $late = 0;
        $halfDay = 0;
        $absent = 0;
        $estimasiWaktu = 0 ;

        $estimasiWaktu =  app('settings')['estimasi_waktu_masuk'] ?? 10;
        $estimasiWaktu = (int) $estimasiWaktu;

        $id_kelas = auth()->user()->student->id_kelas ?? 'NULL';
        $jam = inOutTime::where(['id_kelas'=>$id_kelas])->first();
        $jamMasuk = $jam->jam_masuk ?? '07:00';

        // Define the threshold times
        $thresholdTime = Carbon::parse($jamMasuk); // 07:00 AM for "Present"
        $twentyMinutesThreshold = Carbon::parse($jamMasuk)->addMinutes($estimasiWaktu); // 07:20 AM for "Present" window


        // Check each attendance record and calculate status
        foreach ($attendanceRecords as $record) {
            // Parse the entry time
            $entryTime = Carbon::parse($record->entry);

            if ($entryTime->lte($thresholdTime)) {
                // If entry time is on or before 7:00 AM, mark as "Present"
                $present++;
            } elseif ($entryTime->lte($twentyMinutesThreshold)) {
                // If entry time is between 7:00 AM and 7:20 AM, still mark as "Present"
                $present++;
            } elseif ($entryTime->lte($thresholdTime->addMinutes($estimasiWaktu))) {
                // If the entry time is within 30 minutes after 7:00 AM, mark as "Half Day"
                $halfDay++;
            } else {
                // If the entry time is more than 30 minutes after 7:00 AM, mark as "Late"
                $late++;
            }

            // Check if the user is absent (no entry time)
            if (!$record->entry) {
                $absent++;
            }
        }

        // Get the current date and the start and end of this week
        $today = Carbon::now();
        $startOfWeek = $today->startOfWeek(); // Start of the week (Monday)
        $endOfWeek = $today->endOfWeek(); // End of the week (Sunday)

        // Fetch the attendance records for the authenticated user for this week
        $hadir = absent::where('id_rfid', auth()->user()->student->id_rfid ?? 'NULL')
                        ->get();

        // Initialize absence data for the week (all days set to 0 by default)
        $absenceData = [
            'monday' => 0, 'tuesday' => 0, 'wednesday' => 0,
            'thursday' => 0, 'friday' => 0, 'saturday' => 0, 'sunday' => 0
        ];

        // Loop through the attendance records and update the absenceData
        foreach ($hadir as $record) {
            // Convert the "tanggal" field to Carbon instance using the d/m/Y format
            $date = Carbon::createFromFormat('d/m/Y', $record->tanggal);

            // Get the full day name (e.g., 'Monday', 'Tuesday')
            $day = $date->format('l'); // Get the full day name (e.g., 'Monday')

            // Map the full day name to lowercase and set the corresponding absence data
            $absenceData[strtolower($day)] = 1; // Mark as "active" (1) for that day
        }
        return view('dashboard.studentDashboard',[
            'title'=>'Dashboard',
            'jadwal'=>student::where('nis',auth()->user()->nomor)->with(['absent','absentRFID'])->get(),
        ], compact('present', 'late', 'halfDay', 'absent','absenceData','hadir','jamMasuk'));
    }

    public function teacherDashboard(){
                  // Get the authenticated user's RFID ID
        $userId = auth()->user()->student->id_rfid ?? 'NULL';
         // Get the attendance records for this RFID
        $attendanceRecords = absent::where('id_rfid', $userId)->get();

        // Initialize counters for attendance status
        $present = 0;
        $late = 0;
        $halfDay = 0;
        $absent = 0;
        $estimasiWaktu = 0 ;

        $estimasiWaktu =  app('settings')['estimasi_waktu_masuk'] ?? 10;
        $estimasiWaktu = (int) $estimasiWaktu;

        $id_kelas = auth()->user()->student->id_kelas ?? 'NULL';
        $jam = inOutTime::where(['id_kelas'=>$id_kelas])->first();
        $jamMasuk = $jam->jam_masuk ?? '07:00';

        // Define the threshold times
        $thresholdTime = Carbon::parse($jamMasuk); // 07:00 AM for "Present"
        $twentyMinutesThreshold = Carbon::parse($jamMasuk)->addMinutes($estimasiWaktu); // 07:20 AM for "Present" window


        // Check each attendance record and calculate status
        foreach ($attendanceRecords as $record) {
            // Parse the entry time
            $entryTime = Carbon::parse($record->entry);

            if ($entryTime->lte($thresholdTime)) {
                // If entry time is on or before 7:00 AM, mark as "Present"
                $present++;
            } elseif ($entryTime->lte($twentyMinutesThreshold)) {
                // If entry time is between 7:00 AM and 7:20 AM, still mark as "Present"
                $present++;
            } elseif ($entryTime->lte($thresholdTime->addMinutes($estimasiWaktu))) {
                // If the entry time is within 30 minutes after 7:00 AM, mark as "Half Day"
                $halfDay++;
            } else {
                // If the entry time is more than 30 minutes after 7:00 AM, mark as "Late"
                $late++;
            }

            // Check if the user is absent (no entry time)
            if (!$record->entry) {
                $absent++;
            }
        }

        // Get the current date and the start and end of this week
        $today = Carbon::now();
        $startOfWeek = $today->startOfWeek(); // Start of the week (Monday)
        $endOfWeek = $today->endOfWeek(); // End of the week (Sunday)

        // Fetch the attendance records for the authenticated user for this week
        $hadir = absent::where('id_rfid', auth()->user()->gtk->id_rfid ?? 'NULL')
                ->get();

        // Initialize absence data for the week (all days set to 0 by default)
        $absenceData = [
            'monday' => 0, 'tuesday' => 0, 'wednesday' => 0,
            'thursday' => 0, 'friday' => 0, 'saturday' => 0, 'sunday' => 0
        ];

        // Loop through the attendance records and update the absenceData
        foreach ($hadir as $record) {
            // Convert the "tanggal" field to Carbon instance using the d/m/Y format
            $date = Carbon::createFromFormat('d/m/Y', $record->tanggal);

            // Get the full day name (e.g., 'Monday', 'Tuesday')
            $day = $date->format('l'); // Get the full day name (e.g., 'Monday')

            // Map the full day name to lowercase and set the corresponding absence data
            $absenceData[strtolower($day)] = 1; // Mark as "active" (1) for that day
        }
        $jadwal = Lesson::where(['id_gtk'=>auth()->user()->nomor])->get();

        $currentYear = date('Y');
        $month = date('m');
        $url = "https://api-harilibur.netlify.app/api?year=$currentYear&month=$month";

        $response = Http::get($url);
        $data = $response->json(); // Assuming the API returns an array of data.

        return view('dashboard.teacher',[
            'title'=>'Dashboard',
            'classRoom'=>ClassRoom::where('auth',auth()->user()->nomor)->get(),
            'events'=>Event::all(),
            'tasks'=>tasks::where('created_by',auth()->user()->nomor)->get()
        ],compact('present', 'late', 'halfDay', 'absent','absenceData','hadir','jamMasuk','jadwal','data', 'currentYear'));
    }
    public function walikelasDashboard(){
        return view('dashboard.walikelas',[
            'title'=>'Dashboard',
        ]);
    }
    public function superadmin(){
        return view('dashboard.superadmin',[
            'title'=>'Dashboard',
            // student
            'studentCount'=>student::count(),
            'studentActive'=>student::where('status','1')->count(),
            'studentDeactive'=>student::where('status','2')->count(),
            // gtk
            'gtkCount'=>gtk::count(),
            'gtkActive'=>gtk::where('status','1')->count(),
            'gtkDeactive'=>gtk::where('status','2')->count(),
            // rombel
            'kelas'=>kelas::where('status','1')->with(['jurusanKelas','jmlRombel'])->get(),
            'rombelCount'=>rombel::count(),
            'rombelActive'=>rombel::where('status','1')->count(),
            'rombelDeactive'=>rombel::where('status','2')->count(),
            // kelas
            'kelasCount'=>Kelas::count(),
            'kelasActive'=>Kelas::where('status','1')->count(),
            'kelasDeactive'=>Kelas::where('status','2')->count(),
            // absen
            'absenEntryCount'=>AbsentsHistory::where('status', 'ENTRY')->whereDate('created_at', Carbon::today())->count(),
            'absenOutCount'=>absentsHistory::where('status', 'EXIT')->whereDate('created_at', Carbon::today())->count(),
        ]);
    }
}
