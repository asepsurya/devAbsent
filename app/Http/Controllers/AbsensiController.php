<?php

namespace App\Http\Controllers;
use Alert;
use App\Models\gtk;
use App\Models\Kelas;
use App\Models\absent;
use App\Models\rombel;
use App\Models\student;
;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;

class AbsensiController extends Controller
{
    public function absensiStudent(){
        if(request()){
            $data =  rombel::where([
                'id_tahun_pelajaran'=> request('tahun'),
                'id_kelas'=>request('kelas'),
                ])->with(['rombelStudent','rombelAbsent','notRFID'])->paginate(10)->appends(request()->query());
         }
         if(request('kelas') == "all"){
            $data = rombel::where('status','1')->with(['rombelStudent','rombelAbsent','notRFID'])->paginate(10)->appends(request()->query());
         }

        return view('absensi.student',[
            'title'=>'Absensi Siswa',
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->with('jurusanKelas')->get(),
            'rombel'=>$data,
            'absent'=>absent::where(['tanggal'=>request('tanggal')])->get(),

        ]);
    }
    public function absensiTeacher(request $request){
// ->whereNotNull('id_rfid')
        return view('absensi.teacher',[
            'title'=>'Absensi Guru dan Tenaga Kependidikan',
            'gtk'=>gtk::where(['status'=>'1'])->with('absent','rombelAbsent')->get(),
            'absentTanggal'=>absent::where(['tanggal'=>request('tanggal','absent')])->get(),
        ]);

    }
    public function absensiStudentAdd1(request $request){
        dd($request);
    }
    public function absensiStudentAdd(request $request){
        $cek =  absent::where(['tanggal'=>request('tanggal'),'id_rfid'=>$request->id_rfid])->get();
        if($cek->count()){
            if($request->id_rfid == ''){
                Alert::error('RFID belum diatur, Mohon atur terlebih dahulu RFID' );
                return redirect()->back();
            }else{
                absent::where(['tanggal'=>request('tanggal'),'id_rfid'=>$request->id_rfid])->update([
                    "tanggal" => $request->tanggal,
                    "entry" => date('H:i'),
                    "out" => $request->out,
                    "status" => $request->status,
                    "keterangan" => $request->keterangan
                ]);
                gtk::where('id_rfid',$request->id_rfid)->update(['last_absent'=>request('tanggal')]);
                toastr()->success('Berhasil Disimpan');
                return redirect()->back();
            }
        }else{
            if($request->id_rfid == ''){
                Alert::error('RFID belum diatur, Mohon atur terlebih dahulu RFID' );
                return redirect()->back();
            }else{
                absent::create([
                    "tanggal" => $request->tanggal,
                    "id_rfid" => $request->id_rfid,
                    "entry" => date('H:i'),
                    "out" => $request->out,
                    "status" => $request->status,
                    "keterangan" => $request->keterangan
                ]);
                gtk::where('id_rfid',$request->id_rfid)->update(['last_absent'=>request('tanggal')]);
                toastr()->success('Berhasil Disimpan');
                return redirect()->back();
            }
        }



    }
}
