<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class FullCalendarController extends Controller
{
    //retrive events from db
    public function getEvent(Request $request)
    {
        //dd($request->id);
        if ($request->id) {
            $user_id = $request->id;
        } else {
            $user_id = auth()->id();
        }
        //dd($user_id);
        if (request()->ajax()) {
            $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
            $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');
            //$user_id = (!empty($_GET["user_id"])) ? ($_GET["user_id"]) : ('');
            //dd($end);
            $events = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->where('user_id', '=', $user_id)
                ->get(['id', 'title', 'start', 'end', 'user_id']);

            return response()->json($events);
        }
        $users = User::all();
        return view('fullcalendar', ['users' => $users]);
    }

    //create a new event
    public function createEvent(Request $request)
    {

        $data = $request->except('_token');
        //dd($data);
        $data['user_id'] = auth()->id();
        $events = Event::insert($data);
        return response()->json($events);
    }

    //delete the event
    public function deleteEvent(Request $request)
    {

        $event = Event::find($request->id);
        return $event->delete();
        //return redirect('/')->with('message', 'listing deleted succesfully');
    }

    public function destroy(Event $event)
    {
        //make sure logded in user owner

        $event->delete();
        return redirect('/')->with('message', 'Event deleted succesfully');
    }

    // Manage Events
    public function manage(User $user, Event $event)
    {
        //dd(auth()->id());
        $users = User::all();
        return view('events.manage', ['events' => auth()->user()->getEvents()->get()], ['users' => $users]);
    }
}
