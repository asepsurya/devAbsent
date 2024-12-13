<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    // Fetch all events from the database
    public function index()
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


}
