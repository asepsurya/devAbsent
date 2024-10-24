<?php

namespace App\Http\Controllers;
use App\Models\Lesson;
use App\Models\rombel;
use App\Models\Regency;
use App\Models\Village;
use App\Models\District;
use App\Models\Province;
use App\Models\grupMapel;
use App\Models\walikelas;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function getkabupaten(request $request){
        $id_provinsi = $request->id_provinsi;
        $option = "<option value=''> Kota/Kabupaten </option>";
        $kabupatens = Regency::where('province_id',$id_provinsi)->get();
        foreach($kabupatens as $kabupaten){
            $option.="<option value='$kabupaten->id' > $kabupaten->name </option>";
        }
        echo $option;
    }
    public function getkecamatan(request $request){
        $id_kabupaten = $request->id_kabupaten;

        $option = "<option value=''> Kecamatan </option>";
        $kecamatans = District::where('regency_id',$id_kabupaten)->get();
        foreach($kecamatans as $kecamatan){
            $option.="<option value='$kecamatan->id'> $kecamatan->name </option>";
        }
        echo $option;
    }

    public function getdesa(request $request){
        $id_kecamatan = $request->id_kecamatan;

        $option = "<option value=''> Kelurahan/Desa </option>";
        $desas = Village::where('district_id',$id_kecamatan)->get();
        foreach($desas as $desa){
            $option.= "<option value='$desa->id' > $desa->name </option>";
        }
        echo $option;
    }

    public function getwalikelas(request $request){
        $id_kelas = $request->id_kelas;
        $cek = walikelas::where('id_kelas',$id_kelas)->get();
        foreach($cek as $kelas){
          echo $kelas->gtk->nama;
        }

    }
    public function getgtk(request $request){
        $id_mapel = $request->id_mapel;
        $id_kelas = $request->id_kelas;
        $cek = grupMapel::where(['id_mapel'=>$id_mapel,'id_kelas'=>$id_kelas])->with('guru')->get();
        foreach ($cek as $data){
             $nik = $data->guru->nik ;
             $nama = $data->guru->nama ;
             $option = "<option value='$nik' > $nik </option>";
        }
        return [
            'a' => $option,
            'b' => $nama
        ];
    }

}
