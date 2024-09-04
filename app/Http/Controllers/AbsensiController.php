<?php

namespace App\Http\Controllers;
use App\Models\TahunPelajaran;
use App\Models\Kelas;
use App\Models\rombel;
use App\Models\absent;
use App\Models\gtk;
use Alert;
;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function absensiStudent(){
        if(request()){
            $data =  rombel::where([
                'id_tahun_pelajaran'=> request('tahun'),
                'id_kelas'=>request('kelas'),
                ])->with(['rombelStudent','rombelAbsent'])->get();
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

        return view('absensi.teacher',[
            'title'=>'Absensi Guru dan Tenaga Kependidikan',
            'gtk'=>gtk::where(['status'=>'1'])->whereNotNull('id_rfid')->with('absent')->get(),
            'absentTanggal'=>absent::where(['tanggal'=>request('tanggal')])->get(),
        ]);

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
                    "entry" => $request->entry,
                    "out" => $request->out,
                    "status" => $request->status,
                    "keterangan" => $request->keterangan
                ]);
                gtk::where('id_rfid',$request->id_rfid)->update(['last_absent'=>request('tanggal')]);
                Alert::success('Data Berhasil Disimpan' );
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
                    "entry" => $request->entry,
                    "out" => $request->out,
                    "status" => $request->status,
                    "keterangan" => $request->keterangan
                ]);
                gtk::where('id_rfid',$request->id_rfid)->update(['last_absent'=>request('tanggal')]);
                Alert::success('Data Berhasil Disimpan' );
                return redirect()->back();
            }
        }



    }
}
