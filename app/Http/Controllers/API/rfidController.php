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

    public function rfidadd(request $request) {
        date_default_timezone_set('Asia/Jakarta');
        $timenow= date('H:i');
        $data = rfid::where('id_rfid',$request->rfid)->get();
        if($data->count()) {
            foreach($data as $item){
                if($item->status == '1') {
                    return response()->json([
                        'status'=>'RFID Not Bind',
                    ]);
                } else if($item->status == '3') {
                        return response()->json([
                            'status'=>'BLOCKED',
                    ]);
                } else {
                    $cek = absent::where([
                        'id_rfid'=>$request->rfid,'tanggal'=>date('d/m/Y')
                    ])->get();

                    if($cek->count()){
                         // sudah absen Input jam Out
                        $status ="EXIT";
                        absent::where('id_rfid',$request->rfid)->update([
                            'out'=>$timenow,
                            'status'=>'H'
                        ]);
                        // method untuk tidak multiple history ketika sudah EXIT
                          $cekhistory = absentsHistory::where([
                            'date'=>date('d/m/Y'),
                            'uid'=>$item->id_rfid,
                            'status'=>'EXIT'
                          ]);

                            if($cekhistory->count() == 0){
                                absentsHistory::create([
                                    'date'=>date('d/m/Y'),
                                    'time'=>$timenow,
                                    'uid'=>$item->id_rfid,
                                    'status'=>$status
                                ]);
                            }

                    } else {
                        // belum absen Input  jam entry
                        $status = "ENTRY";
                        absent::create([
                            'tanggal'=>date('d/m/Y'),
                            'uid'=> $item->rfidStudent->nis ?? $item->rfidGTK->nik ,
                            'id_rfid'=>$item->id_rfid,
                            'entry'=> $timenow,
                            'status'=>'H'
                        ]);

                        absentsHistory::create([
                            'date'=>date('d/m/Y'),
                            'time'=>$timenow,
                            'uid'=>$item->id_rfid,
                            'status'=>$status
                        ]);
                    }

                    $ceknama = gtk::where('id_rfid',$request->rfid)->get();
                    if($ceknama->count()){
                        foreach($ceknama as $a){
                            $nama = $a->nama;
                        }
                    }
                    $cekNama2 = student::where('id_rfid',$request->rfid)->get();
                    if($cekNama2->count()){
                        foreach($cekNama2 as $a){
                            $nama = $a->nama;
                        }
                    }
                    if(request('type') == 'device1'){
                        return redirect()->route('index');
                    }else{
                        return response()->json([
                            'waktu'=>Carbon::parse(now())->translatedFormat('d/m/Y'),
                            'nama'=>$nama,
                            'uid'=>$item->id_rfid,
                            'status'=>$status,

                        ]);
                    }

                }
            }
        } else {
            rfid::create([
                'id_rfid'=>$request->rfid,
                'status'=>'1'
            ]);

            return response()->json([
                // RFID TIDAK TERDAFTAR - INPUT RFID
                'status'=>'INVALID',
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
            'keterangan'=>$item->student->getKelas->nama_kelas.' '.$item->student->getKelas->jurusanKelas->nama_jurusan
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
