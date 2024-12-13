<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
      // Menampilkan daftar pengumuman
      public function index(request $request)
      {
                // Paginate the announcements, 2 items per page
            $announcements = Announcement::paginate(5);

            if ($request->ajax()) {
                // Return the partial view when AJAX request is made
                return view('announcement.load-more', [
                    'title' => 'Papan Pengumuman',
                    'notice' => $announcements,
                ])->render();  // Render the partial view for AJAX
            }

            // Return the full page when it's not an AJAX request
            return view('announcement.index', [
                'title' => 'Papan Pengumuman',
                'notice' => $announcements,
            ]);  // Full page load

      }

      // Menyimpan pengumuman baru
      public function store(Request $request)
      {
            // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'recived' => 'nullable|array',  // Validate as an array, nullable if no checkboxes are selected
            'recived.*' => 'in:admin,walikelas,guru,siswa', // Validate each selected checkbox value

        ]);

        // Prepare data for insertion
        $announcementData = $request->only(['title', 'content', 'author', 'date']); // Only pick the fields you want to insert
        $announcementData['author'] = Auth::user()->nama;  // Manually add the author's name
        $announcementData['recived'] = json_encode($request->recived);  // Store recived as a JSON array

        // Create the announcement
        Announcement::create($announcementData);

        toastr()->success('Pengumuman Berhasil dibuat');

        // Redirect back with a success message
        return redirect()->back();
      }

      public function update(request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required',
            'recived' => 'required|array',
            'recived.*' => 'in:admin,walikelas,guru,siswa',
        ]);

        $announcement = Announcement::findOrFail($request->id);
        $announcementData = $request->only(['title', 'content', 'author', 'date', 'recived']);
        $announcementData['recived'] = json_encode($announcementData['recived']);

        $announcement->update($announcementData);

        toastr()->success('Pengumuman Berhasil diperbarui');
        return redirect()->back();
      }
}
