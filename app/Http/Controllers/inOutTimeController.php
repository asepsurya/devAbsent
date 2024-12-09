<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\inOutTime;
use Illuminate\Http\Request;

class inOutTimeController extends Controller
{
    public function indexClass(request $request){
        return view('datakelas.index',[
            'title'=> 'Jadwal Waktu Masuk dan Pulang',
            'kelas'=>Kelas::orderBy('id', 'DESC')->with(['jurusanKelas','jmlRombel','inOutTime'])->get(),

        ]);
    }

    public function classTimeUpdate(Request $request)
        {

    // Loop through each input row
    for ($i = 0; $i < count($request->id_kelas); $i++) {
        // Check if the record already exists for the specific id_kelas
        $existingRecord = inOutTime::where('id_kelas', $request->id_kelas[$i])->first();

        if ($existingRecord) {
            // If record exists, update it
            $existingRecord->update([
                'jam_masuk' => $request->jam_masuk[$i],
                'jam_pulang' => $request->jam_keluar[$i],
            ]);
        } else {
            // If record does not exist, create a new one
            inOutTime::create([
                'id_kelas' => $request->id_kelas[$i],
                'jam_masuk' => $request->jam_masuk[$i],
                'jam_pulang' => $request->jam_keluar[$i], // Ensure jam_keluar is being passed
            ]);
        }
    }

    toastr()->success("Data Berhasil Diperbaharui");
    return redirect()->back();
}


}
