<?php

namespace App\Http\Controllers;
use Alert;
use App\Models\gtk;
use App\Models\Kelas;
use App\Models\absent;
use App\Models\Lesson;
use App\Models\rombel;
use App\Models\student;
use App\Models\grupMapel;
use App\Models\absentMapel;
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

        return view('absensi.teacher',[
            'title'=>'Absensi Guru dan Tenaga Kependidikan',
            'gtk'=>gtk::where(['status'=>'1'])->whereNotNull('id_rfid')->with('absent','rombelAbsent')->get(),
            'absentTanggal'=>absent::where(['tanggal'=>request('tanggal','absent')])->get(),
        ]);
    }

    public function absensiTeacherAdd(request $request){
        if($request->id_rfid == NULL && $request->data == NULL){
            toastr()->warning('Oopss..!! Ada RFID yang Belum disetel');
            return redirect()->back();
        }else{
            if($request->type == 'single'){
                foreach ($request->id_rfid as $id_rfid) {
                  // Find the index of the current RFID in the data array
                  $index = array_search($id_rfid, $request->id_rfid ?? null);
                  // Check for existing attendance record
                  $existingAttendance = absent::where(['tanggal' => $request->tanggal, 'id_rfid' => $id_rfid])->first();

                  // Prepare data for updating or creating
                  $attendanceData = [
                      "tanggal" => $request->tanggal,
                      "id_rfid" => $id_rfid ,
                      "entry" => date('H:i'),
                      "out" => $request->out, // Make sure to add this to your form if necessary
                      "status" => $request->status[$index] ?? '', // Use the index to find the status
                      "keterangan" => $request->keterangan ?? '', // Optional
                  ];

                  if ($existingAttendance) {
                      // Update existing record
                      $existingAttendance->update($attendanceData);
                  } else {
                      // Create new record
                      absent::create($attendanceData);
                  }
                  // Update the last absent date for the student
                  gtk::where('id_rfid', $id_rfid)->update(['last_absent' => $request->tanggal]);
                }
              }elseif ($request->type == 'ubahKeterangan'){

                  absent::where(['tanggal'=>$request->tanggal,'id_rfid'=>$request->id_rfid])
                  ->update(['keterangan'=>$request->keterangan]);

              }else{
                  foreach ($request->data as $id_rfid) {
                      // Find the index of the current RFID in the data array
                      $index = array_search($id_rfid, $request->data);
                      // Check for existing attendance record
                      $existingAttendance = absent::where(['tanggal' => $request->tanggal, 'id_rfid' => $id_rfid])->first();

                      // Prepare data for updating or creating
                      $attendanceData = [
                          "tanggal" => $request->tanggal,
                          "id_rfid" => $id_rfid,
                          "entry" => date('H:i'),
                          "out" => $request->out, // Make sure to add this to your form if necessary
                          "status" => $request->Mstatus ?? 'A', // Use the index to find the status
                          "keterangan" => $request->keterangan ?? '', // Optional
                      ];

                      if ($existingAttendance) {
                          // Update existing record
                          $existingAttendance->update($attendanceData);
                      } else {
                          // Create new record
                          absent::create($attendanceData);
                      }
                      // Update the last absent date for the student
                      gtk::where('id_rfid', $id_rfid)->update(['last_absent' => $request->tanggal]);
                  }
              }
              toastr()->success('Berhasil Disimpan');
              return redirect()->back();
        }
    }
    public function absensiStudentAdd(Request $request)
    {

        if($request->type == 'single'){
          foreach ($request->id_rfid as $id_rfid) {
            // Find the index of the current RFID in the data array
            $index = array_search($id_rfid, $request->id_rfid);
            // Check for existing attendance record
            $existingAttendance = absent::where(['tanggal' => $request->tanggal, 'id_rfid' => $id_rfid])->first();

            // Prepare data for updating or creating
            $attendanceData = [
                "tanggal" => $request->tanggal,
                "id_rfid" => $id_rfid,
                "entry" => date('H:i'),
                "out" => $request->out, // Make sure to add this to your form if necessary
                "status" => $request->status[$index] ?? '', // Use the index to find the status
                "keterangan" => $request->keterangan ?? '', // Optional
            ];

            if ($existingAttendance) {
                // Update existing record
                $existingAttendance->update($attendanceData);
            } else {
                // Create new record
                absent::create($attendanceData);
            }
            // Update the last absent date for the student
            gtk::where('id_rfid', $id_rfid)->update(['last_absent' => $request->tanggal]);
          }
        }elseif ($request->type == 'ubahKeterangan'){

            absent::where(['tanggal'=>$request->tanggal,'id_rfid'=>$request->id_rfid])
            ->update(['keterangan'=>$request->keterangan]);

        }else{
            foreach ($request->data as $id_rfid) {
                // Find the index of the current RFID in the data array
                $index = array_search($id_rfid, $request->data);
                // Check for existing attendance record
                $existingAttendance = absent::where(['tanggal' => $request->tanggal, 'id_rfid' => $id_rfid])->first();

                // Prepare data for updating or creating
                $attendanceData = [
                    "tanggal" => $request->tanggal,
                    "id_rfid" => $id_rfid,
                    "entry" => date('H:i'),
                    "out" => $request->out, // Make sure to add this to your form if necessary
                    "status" => $request->Mstatus ?? 'A', // Use the index to find the status
                    "keterangan" => $request->keterangan ?? '', // Optional
                ];

                if ($existingAttendance) {
                    // Update existing record
                    $existingAttendance->update($attendanceData);
                } else {
                    // Create new record
                    absent::create($attendanceData);
                }
                // Update the last absent date for the student
                gtk::where('id_rfid', $id_rfid)->update(['last_absent' => $request->tanggal]);
            }
        }
        toastr()->success('Berhasil Disimpan');
        return redirect()->back();
    }


    public function absensiClassStudent(request $request){
        $nisList = $request->input('data'); // Get selected NIS from checkboxes
        $statuses = $request->input('Mstatus'); // Get status for each NIS
    if($request->type == 'multiple'){
        foreach ($nisList as $nis) {
            $status = $statuses ?? null; // Get the corresponding status
            if(auth()->user()->role == 'admin' ||  auth()->user()->role == 'superadmin'){
                    $id_gtk = $request->id_gtk;
            }else{
                $id_gtk = auth()->user()->nomor;
            }

            // Update or create the attendance record
            absentMapel::updateOrCreate(
                [
                    'tanggal' => $request->input('tanggal')[0], // Assuming the first value is the intended date
                    'nis' => $nis,
                    'id_mapel' => $request->input('id_mapel')[0],
                    'id_kelas' => $request->input('id_kelas')[0],
                ],
                [
                    'id_gtk' => $id_gtk,
                    'entry' => now()->format('H:i'),
                    'status' => $status,
                    'keterangan'=>$request->keterangan ?? null
                    // Add any other fields you need here
                ]
            );
        }
    }elseif($request->type == 'ubahKeterangan'){
        absentMapel::where(['tanggal'=>$request->tanggal,'nis'=>$request->nis,'id_mapel'=>$request->id_mapel])
        ->update(['keterangan'=>$request->keterangan]);

    }else{
        $nisdata = $request->input('nis');
        $mystatuses = $request->input('status');
        foreach ($nisdata as $nis) {
            $status2 = $mystatuses[$nis] ?? null; // Get the corresponding status
            // Update or create the attendance record
            absentMapel::updateOrCreate(
                [
                    'tanggal' => $request->input('tanggal')[0], // Assuming the first value is the intended date
                    'nis' => $nis,
                    'id_mapel' => $request->input('id_mapel')[0],
                    'id_kelas' => $request->input('id_kelas')[0],
                ],
                [
                    'id_gtk' => auth()->user()->nomor,
                    'entry' => now()->format('H:i'),
                    'status' => $status2,
                    // Add any other fields you need here
                ]
            );
        }
    }

    session()->flash('refresh', true);
    toastr()->success('Berhasil Disimpan');
    return redirect()->back();
    }


    public function absensiClassManagement(){
        if(request()){
            $data =  rombel::where([
                'id_tahun_pelajaran'=> request('tahun'),
                'id_kelas'=>request('kelas'),
                ])->with(['rombelStudent','rombelAbsent','notRFID'])->paginate(10)->appends(request()->query());
         }

         if(request('kelas') == "all"){
            $data = rombel::where('status','1')->with(['rombelStudent','rombelAbsent','notRFID'])->paginate(10)->appends(request()->query());
         }

        return view('absensi.managementAbsensi.manageAbsent',[
            'title'=>'Absensi Siswa',
            'tahunAjar'=>TahunPelajaran::where(['status'=>'1'])->orderBy('id', 'DESC')->get(),
            'kelas'=>Kelas::where('status','1')->with('jurusanKelas')->get(),
            'rombel'=>$data,
            'mapel'=> Lesson::where(['status'=>'1','id_rombel'=>request('kelas')])->with(['mata_pelajaran','guru'])->get(),
            'absent'=>absentMapel::where(['tanggal'=>request('tanggal'),'id_mapel'=>request('mapel')])->get(),
        ]);
    }

}
