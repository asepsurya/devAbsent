<?php

namespace App\Http\Controllers\API;
use DB;

use Alert;
use Carbon\Carbon;
use App\Models\gtk;
use App\Models\rfid;
use App\Models\absent;
use App\Models\student;
use App\Models\entyrfid;
use App\Models\inOutTime;
use Illuminate\Http\Request;
use App\Models\absentsHistory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class rfidController extends Controller
{
    public function rfid(request $request) {
        if ($request->ajax()) {
            return DataTables::of(rfid::orderBy('id', 'DESC'))->addIndexColumn()->toJson();
        }
        return view('rfid.rfid',[
            'title'=>'Registrasi RFID',
            'rfid'=>rfid::orderBy('id', 'DESC')->with(['rfidStudent','rfidGTK'])->get()
        ]);
    }
    // untuk mengirim data RFID API
    public function rfidAPI(request $request) {
        $data = rfid::orderBy('id','ASC')->get();
        return response()->json([
            'status'=>true,
            'message'=>'Data ditemukan',
            'data'=>$data
        ],200);
    }

    public function rfidadd(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $timenow = Carbon::now();

        // Ambil data RFID dan relasi student/GTK
        $item = rfid::with(['rfidStudent', 'rfidGTK'])->where('id_rfid', $request->rfid)->first();

        // Jika RFID tidak ditemukan → buat baru
        if (!$item) {
            rfid::create([
                'id_rfid' => $request->rfid,
                'status' => '1'
            ]);
            return response()->json(['status' => 'INVALID']);
        }

        // Cek status RFID
        if ($item->status == '1') {
            return response()->json(['status' => 'RFID Not Bind']);
        }

        if ($item->status == '3') {
            return response()->json(['status' => 'BLOCKED']);
        }

        // Ambil UID dari student/GTK
        $uid = optional($item->rfidStudent)->nis ?? optional($item->rfidGTK)->nik;

        if (!$uid) {
            return response()->json([
                'status' => 'UID_NOT_FOUND',
                'message' => 'RFID tidak terhubung ke data siswa atau GTK.'
            ]);
        }

        // Cek apakah sudah absen hari ini
        $cekAbsen = absent::where('id_rfid', $request->rfid)
            ->where('tanggal', $timenow->format('d/m/Y'))
            ->first();

        if ($cekAbsen) {
            // EXIT logic
            $status = "EXIT";

            if ($item->rfidStudent) {
                $id_kelas = $item->rfidStudent->id_kelas;
                $cek = inOutTime::where('id_kelas', $id_kelas)->first();
                $jamPulang = $cek ? Carbon::parse($cek->jam_pulang) : Carbon::createFromTimeString('16:00');

                if ($timenow->lessThan($jamPulang)) {
                    return response()->json([
                        'status' => 'BELUM_WAKTUNYA',
                        'sss'=>$id_kelas,
                        'message' => 'Maaf, jam pulang belum saatnya'
                    ]);
                }
            }

            // Update jam keluar
            $cekAbsen->update([
                'out' => $timenow,
                'status' => 'H'
            ]);

           // Cek apakah sudah ada history dengan status ini (ENTRY / EXIT)
            $alreadyLogged = absentsHistory::where([
                'date' => $timenow->format('d/m/Y'),
                'uid' => $item->id_rfid,
                'status' => $status
            ])->exists();

            $bolehSimpanHistory = false;

            if ($item->rfidStudent) {
                // Siswa: cukup pastikan belum dicatat
                $bolehSimpanHistory = !$alreadyLogged;
            } elseif ($item->rfidGTK) {
                // GTK: pastikan belum dicatat status ENTRY / EXIT-nya hari ini
                $bolehSimpanHistory = !$alreadyLogged;
            }

            if ($bolehSimpanHistory) {
                absentsHistory::create([
                    'date' => $timenow->format('d/m/Y'),
                    'time' => $timenow->format('H:i:s'),
                    'uid' => $item->id_rfid,
                    'status' => $status
                ]);
            }


        } else {
            // ENTRY logic
            $status = "ENTRY";

            absent::create([
                'tanggal' => $timenow->format('d/m/Y'),
                'uid' => $uid,
                'id_rfid' => $item->id_rfid,
                'entry' => $timenow,
                'status' => 'H'
            ]);

            absentsHistory::create([
                'date' => $timenow->format('d/m/Y'),
                'time' => $timenow->format('H:i:s'),
                'uid' => $item->id_rfid,
                'status' => $status
            ]);
        }

        // Ambil nama dari student atau GTK
        $nama = optional($item->rfidStudent)->nama ?? optional($item->rfidGTK)->nama ?? 'Tidak diketahui';

        // Cek apakah dari perangkat tertentu
        if ($request->type == 'device1') {
            return redirect()->route('index');
        } else {
            return response()->json([
                'waktu' => $timenow->translatedFormat('d/m/Y - H:i'),
                'nama' => $nama,
                'uid' => $item->id_rfid,
                'status' => $status,
            ]);
        }
    }

    // Untuk Mengambil Data
    public function rfidData(request $request){
        date_default_timezone_set('Asia/Jakarta');
        // Ambil data absensi berdasarkan UID
            $data = absentsHistory::where('uid', $request->id_rfid)
            ->orderBy('id', 'DESC')
            ->get();

        foreach ($data as $item) {
        $statusAbsen = 'Absen Tepat Waktu';
        $terlambat = null;

        // Ambil jam mulai sekolah dari settings
        $startSchool = app('settings')['start_school']; // Misal jam mulai sekolah (contoh: 07:30)

        // Waktu sekarang
        $currentTime = Carbon::now();

        // Jika waktu sekarang lebih besar dari waktu mulai sekolah, berarti terlambat
        if ($currentTime->greaterThan(Carbon::parse($startSchool))) {
        $terlambat = $currentTime->diffInMinutes(Carbon::parse($startSchool)); // Hitung berapa menit terlambat
        $statusAbsen = 'Terlambat';
        }

        // Tentukan nama dan jabatan/ jurusan
        if ($item->gtk) {
        return [
            'nama' => $item->gtk->nama,
            'id' => $item->gtk->id_rfid,
            'uid' => $item->gtk->nik,
            'foto' => $item->gtk->gambar,
            'jam' => $item->time,
            'jenis_kelamin' => $item->gtk->gender,
            'statusAbsent' => $statusAbsen,
            'status' => $item->status,
            'terlambat' => $terlambat, // Tambahkan waktu terlambat
            'jabatan' => $item->gtk->JenisGTK->nama, // Jabatan untuk guru
            'tipe'=>'Guru',
            'keterangan'=>$item->gtk->JenisGTK->nama ?? ''
        ];
        } else {
        return [
            'nama' => $item->student->nama,
            'id' => $item->student->id_rfid,
            'uid' => $item->student->nis,
            'foto' => $item->student->foto,
            'jam' => $item->time,
            'jenis_kelamin' => $item->student->gender,
            'statusAbsent' => $statusAbsen,
            'status' => $item->status,
            'terlambat' => $terlambat, // Waktu terlambat untuk siswa
            'jurusan' => $item->student->jurusan, // Jurusan untuk siswa
            'tipe'=>'Siswa',
          'keterangan' =>
            ($item->student->getKelas->nama_kelas ?? '-') . ' ' .
            ($item->student->getKelas->jurusanKelas->nama_jurusan ?? ' ')
        ];
        }
        }

    }

    public function rfidDataGET(Request $request)
    {
        $dateToday = date('d/m/Y');
        $data = absentsHistory::where('date', $dateToday)
                    ->orderBy('id', 'DESC')
                    ->first();


        return $data ? $data->uid : null;
    }

    public function rfidDelete($id){
        $data = rfid::where('id',$id)->get();
        foreach($data as $key){
            if($key->status == "1"){
                rfid::where('id',$id)->delete();
                toastr()->success('Data Berhasil dihapus');
                return redirect()->back();
            } else {
                toastr()->error('Data Sudah Tertaut, tidak bisa dihapus');
                return redirect()->back();

            }
        }

    }

    public function processRfid(request $request){


         $data = rfid::where('status','1')->orderBy('id','DESC')->get();
         foreach($data as $item){
            return $item->id_rfid;
         }
         // For demonstration, return the RFID value (or process it as needed)

    }



}
