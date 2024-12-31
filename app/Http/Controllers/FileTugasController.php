<?php

namespace App\Http\Controllers;

use App\Models\fileTugas;
use App\Models\StudentScore;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileTugasController extends Controller
{
    public function store(Request $request)
    {
        // Validate the uploaded files
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'mimes:jpg,jpeg,png,docx,pdf,txt|max:10240', // example validation
        ]);

        // Process each uploaded file
        foreach ($request->file('files') as $file) {
            // Store the file in the 'files' directory and get its path
            $path = $file->store('files_tugas');

            // Create a new FileTugas entry in the database
            fileTugas::create([
                'task_id' => $request->task_id,
                'student_id' => $request->student_id,
                'file_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'path' => $path,
                'status'=> '1'
            ]);
        }
        toastr()->success('Tugas Berhasi diunggah');
        return redirect()->back();
    }

    public function destroy($file_id)
    {
        // Find the file by ID
        $file = fileTugas::findOrFail($file_id);

        // Delete the file from storage
        if (Storage::exists($file->path)) {
            Storage::delete($file->path);
        }

        // Delete the file record from the database
        $file->delete();

        toastr()->success('File Berhasil di hapus');
        return redirect()->back();
    }

    public function verifikasi(Request $request){
       // Validate that the 'id' array is provided and is not empty
       $request->validate([
        'id' => 'required|array',  // Ensure it's an array
        'id.*' => 'exists:file_tugas,id'  // Ensure all ids exist in the file_tugas table
        ]);

        // Get the array of file IDs from the request
        $fileIds = $request->input('id'); 

        // Update the status of all files with the given IDs
        FileTugas::whereIn('id', $fileIds)->update(['status' => 2]);
        StudentScore::updateOrCreate(
            [
                'task_id' => $request->task_id,  // Unique field(s) to check if the record exists
                'student_id' => $request->student_id,  // Unique field(s) to check if the record exists
            ],
            [
                'benar' => '0',
                'nilai' => $request->score,
                'status' => '1',
            ]
        );
        
        // Show success message
        toastr()->success('File Berhasil di verifikasi');

        // Redirect back to the previous page
        return redirect()->back();
    }
}
