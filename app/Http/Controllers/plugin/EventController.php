<?php

namespace App\Http\Controllers\plugin;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
     /**
     * Write code on Method
     *
     * @return response()
     */

    // Fetch all events from the database
    public function events()
    {
        // Fetch all events
        $events = Event::all();

        // Format events for FullCalendar
        $formattedEvents = $events->map(function($event) {
            return [
                'title' => $event->title,
                'start' => $event->start, // Ensure this is a valid date string or ISO format
                'end' => $event->end, // Optional
                'warna' => $event->warna, // Optional
                'id' => $event->id, // Optional
            ];
        });

        return response()->json($formattedEvents);
    }

    public function destroy($id){
        $event = Event::find($id);
        if ($event) {
            $event->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Event not found'], 404);
    }

    public function index(Request $request)
    {
        if($request->ajax()) {

             $data = Event::whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['id', 'title', 'start', 'end']);

             return response()->json($data);
        }
        return view('fullcalender');
    }

    public function ajax(Request $request): JsonResponse
    {

        switch ($request->type) {
           case 'add':
              $event = Event::create([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
                  'type' => 'event',
              ]);

              return response()->json($event);
             break;

           case 'update':
              $event = Event::find($request->id)->update([
                  'title' => $request->title,
                  'start' => $request->start,
                  'end' => $request->end,
                  'type' => 'event',
              ]);

              return response()->json($event);
             break;

           case 'delete':
              $event = Event::find($request->id)->delete();

              return response()->json($event);
             break;

           default:
             # code...
             break;
        }
    }

    public function addEventModal(request $request){
        Event::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'type' => $request->type,
            'warna' => $request->warna,
        ]);
        toastr()->success('Event Berhasil disimpan');
        return redirect()->back();
    }

    public function kalender(){
        return view('plugin.kalender_akademik.index',[
            'title'=>'Kalender Akademik'
        ]);
    }

}
