<?php

namespace App\Http\Controllers;

use App\Models\gtk;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Lesson;
use App\Models\Jurusan;
use App\Models\grupMapel;
use App\Models\ref_jadwal;
use App\Models\JamPelajaran;
use Illuminate\Http\Request;
use App\Models\TahunPelajaran;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class leassonController extends Controller
{
    public function index(){
        return view('datakelas.index',[
            'title'=>'Data Kelas',
            'kelas'=>Kelas::orderBy('id', 'DESC')->with(['jurusanKelas','jmlRombel'])->get(),
            'jurusans'=>Jurusan::where('status','1')->get()

        ]);
    }
    public function list($id){
        // get data berdasarkan tahun Ajaran
        if(request('tahun_ajar2')){
            $jadwal = Lesson::where(['id_rombel'=>$id,'id_tahun_ajar'=>request('tahun_ajar')])->orderBy('day', 'asc')->orderBy('start', 'asc')->with(['mata_pelajaran','guru','ref'])->get();
        }else{
            $jadwal = Lesson::where('id_rombel',$id)->orderBy('day', 'asc')->orderBy('start', 'asc')->with(['mata_pelajaran','guru','ref'])->get();
        }
        // get data Kelas
        $cek = Kelas::where('id',$id)->with(['jurusanKelas'])->get();
        foreach($cek as $item){
            $kelas =  $item->nama_kelas.' '.$item->jurusanKelas->nama_jurusan.' '. $item->sub_kelas;
        }

        return view('jadwal.index',[
            'title' => 'Jadwal Pelajaran '.$kelas,
            'tahun_ajar'=>TahunPelajaran::where('status',1)->get(),
            'jadwal'=>$jadwal,
            'gtk'=>gtk::where('status','1')->get(),
            'mapel' => grupMapel::where(['id_kelas'=> $id])->with(['mata_pelajaran'])->get(),
            'ref'=>ref_jadwal::where('status','1')->paginate('10'),
            'ref2'=>ref_jadwal::where('status','1')->get()
        ],compact('id'));
    }

    public function getgtk(request $request){
        $data = grupMapel::where(['id_mapel' => $request->id_mapel, 'id_kelas' => $request->id_kelas])->get();
        $gtk = gtk::all();
        $options = []; // Initialize an array to store options
        $selectedNik = null; // Assuming you want to set the selected NIK

        foreach ($data as $i) {
            // Ensure the 'id_mapel' matches, otherwise skip this iteration


            // Determine the name of the GTK
            if ($i->id_gtk == '' ) {
                $nama = 'BELUM DISETEL';
            } else {
                $nama = $i->guru->nama;
            }


            $options[] = "<option value='" . htmlspecialchars($i->id_gtk, ENT_QUOTES, 'UTF-8') . "' selected>" . htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') . "</option>";

            // If you want to remember the selected 'nik', you can set the selectedNik here.
            if ($i->id_gtk == $request->existing_nik) { // Assuming $request->existing_nik contains the current NIK
                $selectedNik = $i->id_gtk;
            }
        }

        return response()->json([
            'a' => implode('', $options), // Join all options into a single string
            'selectedNik' => $selectedNik, // Send back the selected NIK
        ]);


    }
    public function leassonAdd(request $request){
     // Get all the submitted data
     $days = $request->input('day');  // Array of days
     $mapelIds = $request->input('id_mapel');  // Array of mapel IDs
     $gtkIds = $request->input('id_gtk');  // Array of GTK IDs
     $starts = $request->input('start');  // Array of start times
     $ends = $request->input('end');  // Array of end times
     $sk = $request->input('sk');  // Array of SK values
     $tanggalSk = $request->input('tanggal_sk');  // Array of SK dates

     // Define an array for day names
     $daysNames = [
         1 => 'Senin',
         2 => 'Selasa',
         3 => 'Rabu',
         4 => 'Kamis',
         5 => 'Jumat',
         6 => 'Sabtu',
         7 => 'Minggu'
     ];

     // Loop through the arrays and store the data
     for ($i = 0; $i < count($days); $i++) {
         // Check if the lesson already exists for the given day, mapel, gtk, and tahun_ajar
         $cek = Lesson::where([
             'day' => $days[$i],
             'id_mapel' => $mapelIds[$i],

             'id_tahun_ajar' => $request->tahun_ajar
         ])->first();  // Use `first()` to get the first match or null

         // If the lesson exists, update the existing record
         if ($cek) {
             $cek->update([
                 'id_rombel' => $request->input('id_kelas'),  // Assuming id_kelas is hidden in your form
                 'day' => $days[$i],
                 'id_mapel' => $mapelIds[$i],
                 'id_gtk' => $gtkIds[$i] ?? null,  // GTK is nullable
                 'start' => $starts[$i],
                 'end' => $ends[$i],
                 'sk' => $sk[$i] ?? null,
                 'tanggal_sk' => $tanggalSk[$i] ?? null,
                 'id_tahun_ajar' => $request->tahun_ajar,
                 'status' => '1',
             ]);

             $hari = $daysNames[$days[$i]] ?? 'Unknown';  // Get the day name or 'Unknown' if not found
             toastr()->success("Mata Pelajaran pada hari $hari telah diperbarui.");
         } else {
             // If no such lesson exists, create a new lesson
             Lesson::create([
                 'id_rombel' => $request->input('id_kelas'),  // Assuming id_kelas is hidden in your form
                 'day' => $days[$i],
                 'id_mapel' => $mapelIds[$i],
                 'id_gtk' => $gtkIds[$i] ?? null,  // GTK is nullable
                 'start' => $starts[$i],
                 'end' => $ends[$i],
                 'sk' => $sk[$i] ?? null,
                 'tanggal_sk' => $tanggalSk[$i] ?? null,
                 'id_tahun_ajar' => $request->tahun_ajar,
                 'status' => '1',
             ]);
             $hari = $daysNames[$days[$i]] ?? 'Unknown';  // Get the day name or 'Unknown' if not found
             toastr()->success("Mata Pelajaran pada hari $hari telah ditambahkan.");
         }
         $cekdata = grupMapel::where('id_mapel',$request->input('id_kelas'))->get();
         if($cekdata->count()){
            grupMapel::where('id_mapel',$mapelIds[$i])->update(['id_gtk'=> $gtkIds[$i] ?? null]);
         }
     }

     // Redirect back with a success message
     return redirect()->back()->with('refresh', 'Action was successful!');

    }

    public function leassonDelete($id){
        Lesson::where('id',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back()->with('refresh', 'Action was successful!');;
    }

    public function leassonView($id){
        $cek = Kelas::where('id',$id)->with('jurusanKelas')->get();
        foreach($cek as $item){
            $kelas =  $item->nama_kelas.' '.$item->jurusanKelas->nama_jurusan.' '. $item->sub_kelas;
            $id_kelas = $id;
        }
        return view('jadwal.view',[
            'title'=>'Jadwal Pelajaran '.$kelas,
            'senin'=> Lesson::where(['day'=>'1','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),
            'selasa'=> Lesson::where(['day'=>'2','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),
            'rabu'=> Lesson::where(['day'=>'3','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),
            'kamis'=> Lesson::where(['day'=>'4','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),
            'jumat'=> Lesson::where(['day'=>'5','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),
            'sabtu'=> Lesson::where(['day'=>'6','id_rombel'=>$id_kelas])->with(['mata_pelajaran','guru','ref'])->get(),

        ]);
    }
    public function reference(request $request){
        ref_jadwal::create([
            'ref'=>$request->ref,
            'ref_ID'=>mt_rand(),
            'status'=>'1'
        ]);
        toastr()->success('Data Berhasil ditambah');
        return redirect()->back()->with('ref', 5)->withInput();
    }
    public function referenceEdit(request $request){
        ref_jadwal::where('ref_ID',$request->ref_ID)->update([
            'ref'=>$request->ref
        ]);
        toastr()->success('Data Berhasil diubah');
        return redirect()->back()->with('ref', 5)->withInput();
    }
    public function referenceDelete($id){
        ref_jadwal::where('ref_ID',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back()->with('ref', 5)->withInput();
    }

    public function leassonTime(){
        return view('jadwal.jampelajaran',[
            'title'=>'Setelan Jam Pelajaran',
            'data'=>JamPelajaran::where('status',1)->get()
        ]);
    }

    public function addleassonTime(request $request){
         // Validasi input
         $request->validate([
            'jam_ke' => 'required|integer',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_berakhir' => 'required|date_format:H:i',
            'status' => 'required|string',
        ]);

        // Insert data ke model JamPelajaran
        JamPelajaran::create([
            'jam_ke' => $request->jam_ke,
            'jam_mulai' => $request->jam_mulai,
            'jam_berakhir' => $request->jam_berakhir,
            'status' => $request->status,
        ]);
        toastr()->success('Data Berhasil ditambahkan');
        return redirect()->back();
    }

    public function updateleassonTime(request $request){
        
        JamPelajaran::where('id',$request->id)->update([
            'jam_ke' => $request->jam_ke,
            'jam_mulai' => $request->jam_mulai,
            'jam_berakhir' => $request->jam_berakhir,
            'status' => $request->status,
        ]);
        toastr()->success('Data Berhasil diperbaharui');
        return redirect()->back();
       
    }

    public function deleteleassonTime($id){
        JamPelajaran::where('id',$id)->delete();
        toastr()->success('Data Berhasil dihapus');
        return redirect()->back();
    }
}
