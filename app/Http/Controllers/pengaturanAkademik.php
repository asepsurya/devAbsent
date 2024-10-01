<?php

namespace App\Http\Controllers;
use App\Models\Mapel;
use App\Models\TahunPelajaran;
use App\Models\Kelas;
use App\Models\gtk;
use App\Models\User;
use App\Models\grupMapel;
use App\Models\walikelas;
use App\Models\student;
use App\Models\rombel;
use Illuminate\Support\Facades\DB;
use Alert;
use Validator;
use Illuminate\Http\Request;

class pengaturanAkademik extends Controller
{
    public function pengaturanMapel(){
        if(request()){
            $data =  grupMapel::where([
                'id_tahun_pelajaran'=> request('id_tahun_pelajaran'),
                'id_kelas'=>request('id_kelas'),
                'status'=>'2'
                ])->with('mata_pelajaran')->get();
         }
        return view('akdemik.pengaturan.matapelajaran',[
            'title'=>'Pengaturan Mata Pelajaran',
            'mapel'=>Mapel::where('status','1')->get(),
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->with('jurusanKelas')->get(),
            'grupMapel'=>$data,
            'mapelnotAllow'=>grupMapel::where(['status'=>'1'])->get()
        ]);
    }

    public function PengaturanWalikelas(){
        return view('akdemik.pengaturan.walikelas',[
            'title'=> 'Pengaturan Wali Kelas',
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->with(['jurusanKelas','jmlRombel'])->get(),
            'gtk'=>gtk::where('status','1')->get(),
            'walikelas'=>walikelas::orderBy('id', 'DESC')->with(['gtk','tahun_ajar'])->get(),
        ]);
    }

    public function pengaturanWalikelasAdd(request $request){
        walikelas::create([
            'id_tahun_pelajaran'=>$request->tahun,
            'id_kelas'=>$request->kelas,
            'id_gtk'=>$request->id_gtk
        ]);

          User::where('nomor',$request->id_gtk)->update(['role'=>'walikelas']);
          $cekid = User::where('nomor',$request->id_gtk)->get();
          foreach($cekid as $key){
              $getid = $key->id;
              DB::table('model_has_roles')->where('model_id','=', $getid)->update(array('role_id'=>'1'));
          }
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function pengaturanWalikelasEdit(request $request){
        // ubah dulu role ke guru
        User::where('nomor',$request->id_gtk_default)->update(['role'=>'guru']);
          $cekid = User::where('nomor',$request->id_gtk_default)->get();
          foreach($cekid as $key){
              $getid = $key->id;
              DB::table('model_has_roles')->where('model_id','=', $getid)->update(array('role_id'=>'2'));
          }
        //  update ke walikelas
        walikelas::where('id',$request->id)->update([
            'id_tahun_pelajaran'=>$request->tahun,
            'id_kelas'=>$request->kelas,
            'id_gtk'=>$request->id_gtk
        ]);

          User::where('nomor',$request->id_gtk)->update(['role'=>'walikelas']);
          $cekid = User::where('nomor',$request->id_gtk)->get();
          foreach($cekid as $key){
              $getid = $key->id;
              DB::table('model_has_roles')->where('model_id','=', $getid)->update(array('role_id'=>'1'));
          }
        toastr()->success('Data Berhasil disimpan');
        return redirect()->back();
    }

    public function PengaturaRombel(){
        // jika ada request atau filter 1
        if(request('id_kelas_asal') =="all"){
            $data = student::where(['status'=>'1'])->paginate(10)->appends(request()->query());

        }elseif(request('id_kelas_asal') == "belumDiatur"){
            $data = student::where(['id_kelas'=>NULL,'status'=>'1'])->paginate(10)->appends(request()->query());
        }
        else{
            $data = rombel::where(['id_kelas'=>request('id_kelas_asal'),'id_tahun_pelajaran'=>request('tahunAjarAsal')])->paginate(10)->appends(request()->query());
        }
        // filter Tujuan Kelas
        if(request() ){
            $mydata = rombel::where(['id_kelas'=>request('id_kelas_tujuan'),'id_tahun_pelajaran'=>request('id_tahun_pelajaran')])->with('rombelStudent')->paginate(10)->appends(request()->query());
        }
        return view('akdemik.pengaturan.rombel',[
            'title'=>'Rombongan Belajar',
            'students'=>$data,
            'studentsClass'=>$mydata,
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->with('jurusanKelas')->get(),
        ]);
    }

    public function PengaturaRombelUpdate(request $request){
        $cek = rombel::where(['nis'=>$request->nis])->get();
        if($cek->count() != 0){
            foreach($cek as $item){
                    if($item->id_kelas == $request->id_kelas){
                        Alert::warning('Data Sudah Terdaftar Dikelas ini' );
                        return redirect()->back()->withInput();
                    }
                    else{
                        if($request->id_tahun_pelajaran == "" || $request->id_kelas=='' ){
                            Alert::error('Mohon Periksa Kembali Kelas Tujuan terlebih dahulu' );
                            return redirect()->back()->withInput();
                        }else{
                            rombel::where('nis',$request->nis)->update([
                                // 'id_rfid'=>$request->id_rfid,
                                'id_kelas'=>$request->id_kelas,
                                'id_tahun_pelajaran'=>$request->id_tahun_pelajaran,
                            ]);
                            student::where('nis',$request->nis)->update([
                                'id_kelas'=>$request->id_kelas,
                                // 'id_rfid'=>$request->id_rfid,
                            ]);
                            toastr()->success('Data Berhasil dipindahkan');
                            return redirect(route('PengaturaRombel','id_kelas_asal='.$request->id_kelas_asal.'&tahunAjarAsal='.$request->tahunAjarAsal.'&id_kelas_tujuan='.$request->id_kelas.'&id_tahun_pelajaran='.$request->id_tahun_pelajaran))->withInput();
                        }

                    }
             }
        }else{
            if($request->id_kelas == "" || $request->id_tahun_pelajaran == "" ){
                        Alert::error('Mohon Periksa Kembali Kelas Tujuan terlebih dahulu' );
                        return redirect()->back()->withInput();
            }else{
                        rombel::create([
                            // 'id_rfid'=>$request->id_rfid,
                            'nis'=>$request->nis,
                            'id_kelas'=>$request->id_kelas,
                            'id_tahun_pelajaran'=>$request->id_tahun_pelajaran,
                            'status'=>'1',
                           ]);
                        student::where('nis',$request->nis)->update([
                            'id_kelas'=>$request->id_kelas,
                            // 'id_rfid'=>$request->id_rfid,
                           ]);

                        toastr()->success('Data Berhasil disubmit');
                        return redirect(route('PengaturaRombel','id_kelas_asal='.$request->id_kelas_asal.'&tahunAjarAsal='.$request->tahunAjarAsal.'&id_kelas_tujuan='.$request->id_kelas.'&id_tahun_pelajaran='.$request->id_tahun_pelajaran))->withInput();
            }
        }

    }

    public function subject_teachers(){
        if(request()){
            $data =  grupMapel::where(['id_tahun_pelajaran'=> request('tahun'),'id_kelas'=>request('kelas')])->with('mata_pelajaran')->get();
         }
       return view('akdemik.pengaturan.gurumapel',[
        'title'=> 'Guru Mata Pelajaran',
        'mapel'=>Mapel::where('status','1')->get(),
        'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
        'kelas'=>Kelas::where('status','1')->with('jurusanKelas')->get(),
        'gtk'=>gtk::where('status','1')->get(),
        'grupMapel'=>$data,
       ]);
    }
    public function pengaturanMapelAdd(request $request){
        if(request()){
            grupMapel::create([
                'id_mapel'=>$request->id_mapel,
                'status'=>'1'
            ]);
            return redirect()->back();
        }

    }
    public function pengaturanMapelUpdate(request $request){

        grupMapel::where('status','1')->update([
            'id_tahun_pelajaran'=>$request->tahun,
            'id_kelas'=>$request->kelas,
            'semester'=>$request->semester,
            'status'=>'2',
            'id_gtk'=>''
        ]);
        toastr()->success('Data Berhasil disubmit');
        return redirect()->back();
    }
    public function pengaturanMapelDelete($id){
        grupMapel::where('id',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
    }

    public function subject_teachersUpdate(request $request){
       grupMapel::where('id',$request->id )->update(['id_gtk'=>$request->id_gtk ]);
       toastr()->success('Data Berhasil diubah');
       return redirect()->back();
    }
}
