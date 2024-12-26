<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\gtk;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Lesson;
use App\Models\Jurusan;
use App\Models\grupMapel;
use App\Models\ref_jadwal;
use App\Models\setelanHari;
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
            $jadwal = Lesson::where(['id_rombel'=>$id,'id_tahun_ajar'=>request('tahun_ajar')])->orderBy('day', 'asc')->with(['mata_pelajaran','guru','ref'])->get();
        }else{
            $jadwal = Lesson::where('id_rombel',$id)->orderBy('day', 'asc')->with(['mata_pelajaran','guru','ref'])->get();
        }
        // get data Kelas
        $cek = Kelas::where('id',$id)->with(['jurusanKelas'])->get();
        foreach($cek as $item){
            $kelas =  $item->nama_kelas.' '.$item->jurusanKelas->nama_jurusan.' '. $item->sub_kelas;
        }

        return view('jadwal.jadwalpelajaran',[
            'title' => 'Jadwal Pelajaran '.$kelas,


            'tahun_ajar'=>TahunPelajaran::where('status',1)->get(),
            'jadwal'=>$jadwal,

            'mapel' => grupMapel::where(['id_kelas'=> $id])->with(['mata_pelajaran'])->get(),
            'ref2'=>ref_jadwal::where('status','1')->get(),

            'hari'=>setelanHari::where('status',1)->get(),
            'jam'=>JamPelajaran::all(),

        ],compact('id'));
    }

    public function getgtk(request $request){
        $data = grupMapel::where([
            'id_mapel' => $request->id_mapel,
            'id_kelas' => $request->id_kelas
        ])->get();

        // Get all GTK (teachers)
        $gtk = gtk::all();

        $options = []; // Initialize an array to store options

        // Loop through the 'data' collection to fetch teacher names and NIK
        foreach ($data as $i) {
            // Check if 'id_gtk' exists, otherwise set default values
            if (empty($i->id_gtk)) {
                $nama = 'BELUM DISETEL';
                $id_gtk = 'BELUM DISETEL';
            } else {
                // Retrieve teacher details based on the 'id_gtk' relationship
                $guru = $i->guru; // Assuming 'guru' is a relationship defined on 'grupMapel'
                $nama = $guru->nama;
                $id_gtk = $guru->nik;
            }

            // Push the teacher data into the options array
            $options[] = [
                'nama' => $nama ?: 'BELUM DISETEL',
                'nik' => $id_gtk ?: 'BELUM DISETEL',
            ];
        }

        // Check if you want to return all teacher information or the last found one
        // Here, we return all options:
        return response()->json([
            'options' => $options // Send an array of options with teacher names and NIK
        ]);



    }
    public function leassonAdd(request $request){
    // Get all the submitted data
        $days = $request->input('day');  // Array of days
        $mapelIds = $request->input('id_mapel');  // Array of mapel IDs
        $gtkIds = $request->input('id_gtk');  // Array of GTK IDs
        $id_hari = $request->input('id_hari');  // Array of start times
        $sk = $request->input('sk');  // Array of SK values
        $tanggalSk = $request->input('tanggal_sk');  // Array of SK dates
        $id_jam = $request->input('id_jam');  // Array of SK dates

        // Retrieve the school start time (e.g., 07:00) from the settings
        $startSchoolTime = $request->input('start_school');  // Example: "07:00"

        // Create a DateTime object from the start school time
        $startTime = new DateTime($startSchoolTime);

        // Check if any lessons already exist for the same day and subject
        $cek = Lesson::where([
            'day' => $days,
        ])->orderBy('end', 'desc')->first();  // Get the last lesson by end time (latest)

        if ($cek) {
            // If a lesson exists, take the last lesson's end time as the start time for the new lesson
            $lastEndTime = new DateTime($cek->end);  // Convert the end time of the last lesson to DateTime
            $startTime = clone $lastEndTime;  // Set the new start time to the last lesson's end time
        }

        // Add the duration represented by $id_jam (in minutes) to the start time
        $endTime = clone $startTime;  // Clone to avoid modifying the original object
        $endTime->modify("+{$id_jam} minutes");

        // Format both start and end times in the desired "HH:MM" format
        $startFormatted = $startTime->format('H:i');
        $endFormatted = $endTime->format('H:i');

        // Now, the result will be a time range, such as "07:00 - 07:45"
        // Assuming you need the start time for your lesson creation, you can store it as a string
        $formattedTimeRange = "{$startFormatted} - {$endFormatted}";

        // Define the lesson data
        Lesson::create([
            'id_rombel' => $request->input('id_kelas'),  // Assuming id_kelas is hidden in your form
            'day' => $days,  // Store the array of days
            'id_mapel' => $mapelIds,  // Store the array of mapel IDs
            'id_gtk' => $gtkIds ?? null,  // GTK is nullable
            'start' => $startFormatted,  // Use the formatted start time
            'end' => $endFormatted,  // Use the formatted end time
            'sk' => $sk ?? null,  // SK is nullable
            'tanggal_sk' => $tanggalSk ?? null,  // Tanggal SK is nullable
            'id_tahun_ajar' => $request->tahun_ajar,  // Assuming you pass the academic year
            'status' => '1',  // Assuming active status
        ]);

        // Display success message
        toastr()->success("Mata Pelajaran telah ditambahkan.");

        // Redirect back with a success message
        return redirect()->back()->with('refresh', 'Action was successful!');



    }
    public function leassonUpate(request $request){
        $days = $request->input('day');  // Array of days
        $mapelIds = $request->input('id_mapel');  // Array of mapel IDs
        $gtkIds = $request->input('id_gtk');  // Array of GTK IDs
        $id_hari = $request->input('id_hari');  // Array of start times
        $sk = $request->input('sk');  // Array of SK values
        $tanggalSk = $request->input('tanggal_sk');  // Array of SK dates
        $id_jam = $request->input('id_jam');  // Array of SK dates
        $id = $request->id;
        Lesson::where('id',$id)->update([
            'id_rombel' => $request->input('id_kelas'),  // Assuming id_kelas is hidden in your form
            'day' => $days,
            'id_mapel' => $mapelIds,
            'id_gtk' => $gtkIds ?? null,  // GTK is nullable
            'id_jam' => $id_jam,
            'sk' => $sk ?? null,
            'tanggal_sk' => $tanggalSk ?? null,
            'id_tahun_ajar' => $request->tahun_ajar,
            'status' => '1',
        ]);
        toastr()->success("Mata Pelajaran telah diperbaharui.");
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
        $jadwal = Lesson::where('id_rombel',$id)->orderBy('day', 'asc')->with(['mata_pelajaran','guru','ref'])->get();
        return view('jadwal.view',[
            'title'=>'Jadwal Pelajaran '.$kelas,
            'jadwal'=>$jadwal,
            'hari'=>setelanHari::where('status',1)->get(),
            'jam'=>JamPelajaran::all(),

        ],compact('id'));
    }
    public function reference(request $request){
        ref_jadwal::create([
            'ref'=>$request->ref,
            'ref_ID'=>mt_rand(),
            'waktu'=>$request->waktu,
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
