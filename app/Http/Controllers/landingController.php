<?php

namespace App\Http\Controllers;
use auth;
use App\Models\gtk;
use App\Models\student;
use Illuminate\Http\Request;
use App\Models\absentsHistory;
use App\Services\InstagramService;

class landingController extends Controller
{
    protected $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }
    public function isConnected() {
        $connected = @fsockopen("8.8.8.8", 53);
        if ($connected){
            fclose($connected);
            return true;
        }
        return false;
    }
    public function index(){
        if($this->isConnected()) {
            try {
                $username = $this->instagramService->getUsername($userId);
                $feed = $this->instagramService->getFeed($userId);
            } catch (\Exception $e) {
                // Kalau gagal, kosongkan variabelnya biar view tetap jalan
                $username = null;
                $feed = [];

                // Optional: simpan log errornya
                \Log::error('Instagram API error: ' . $e->getMessage());
            }
        } else {
            $username = null;
            $feed = [];
        }
        if(auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'superadmin')) {
            return view('frontpage.myIndex', [
                'absent' => absentsHistory::where('date', date('d/m/Y'))->count()
            ], compact('feed', 'username'));
        } else {
            return view('frontpage.index', [
                'absent' => absentsHistory::where('date', date('d/m/Y'))->count()
            ], compact('feed', 'username'));
        }




    }

    public function listabsents(){
        $data = absentsHistory::where('date',date('d/m/Y'))->with(['student','gtk'])->orderBy('id','DESC')->get();
        return  json_encode($data);
    }

    public function home(){
        return view('frontpage.myIndex');
    }


    public function getAbsenSummary()
    {
       // Ambil semua NIK GTK
        $gtkNiks = gtk::pluck('id_rfid')->map(function($value) {
            return trim($value);
        })->toArray();

        // Ambil semua NIS Student
        $studentNis = student::pluck('id_rfid')->map(function($value) {
            return trim($value);
        })->toArray();

        // Ambil semua absensi hari ini
        $absenHariIni = absentsHistory::where('date', date('d/m/Y'))
            ->whereNotNull('uid')
            ->where('status', 'ENTRY')
            ->get();

        // Hitung yang udah absen GTK
        $totalAbsenGtkHariIni = $absenHariIni->whereIn('uid', $gtkNiks)->count();

        // Hitung yang udah absen Student
        $totalAbsenStudentHariIni = $absenHariIni->whereIn('uid', $studentNis)->count();

        // Hitung total
        $totalGTK     = count($gtkNiks);
        $totalStudent = count($studentNis);

        // Hitung belum absen
        $belumAbsenGTK     = $totalGTK - $totalAbsenGtkHariIni;
        $belumAbsenStudent = $totalStudent - $totalAbsenStudentHariIni;

        // Return JSON
        return response()->json([
            'total_student'         => $totalStudent,
            'sudah_absen_student'   => $totalAbsenStudentHariIni,
            'belum_absen_student'   => $belumAbsenStudent,
            'total_gtk'             => $totalGTK,
            'sudah_absen_gtk'       => $totalAbsenGtkHariIni,
            'belum_absen_gtk'       => $belumAbsenGTK
        ]);

    }



}
