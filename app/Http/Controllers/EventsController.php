<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    public function getEventListView(){
        $events = Event::where('user_id', Auth::user()->id)->get();
        return view('events')->with(['events' => $events]);
    }

    public function getAddEventView()
    {
        $category = Category::all();
        return view('add-event')->with(['category' => $category]);
    }

    public function saveEvent(Request $request)
    {
        $event = new Event();
        $event->user_id = Auth::user()->id;
        $event->title = $request->title;
        $event->start = $request->start;
        $event->end = date("Y-m-d", strtotime("+1 days"));
        $event->category = $request->category;
        $event->description = $request->description;
        $result = $event->save();
        if ($result == true) {
            return redirect('events')->with('message', "Event Saved Successfully");
        } else {
            return redirect()->back()->with('message', $result);
        }
    }

    public function deleteEvent($eventId)
    {
        Event::where('id', $eventId)->delete();
        return redirect()->back();
    }

    public function editEvent($eventId)
    {
        $category = Category::all();
        $events = Event::where('id', $eventId)->first();
        return view('edit-event')->with(['events' => $events, 'category' => $category]);
    }

    public function saveEditedEvent(Request $request)
    {
        $event = Event::where('id', $request->eventId)->first();
        $event->title = $request->title;
        $event->start = $request->start;
        $event->end = date("Y-m-d", strtotime("+1 days"));
        $event->category = $request->category;
        $event->description = $request->description;
        $result = $event->update();
        if ($result == true) {
            return redirect('events')->with('message', "Event updated Successfully");
        } else {
            return redirect()->back()->with('message', $result);
        }
    }

}
