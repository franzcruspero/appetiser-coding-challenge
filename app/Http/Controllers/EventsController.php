<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events;
use App\Http\Resources\EventsResource;

class EventsController extends Controller
{
    public function index(Events $event){
        $events = Events::all()->last();
        return new EventsResource($events);
    }

    public function store(Request $request){
        $event = new Events;
        $event->eventName = $request->input('eventName');
        $event->startDate = $request->input('startDate');
        $event->endDate = $request->input('endDate');
        $event->filteredDates = $request->input('filteredDates');
        if($event->save()){
            return new EventsResource($event);
        }
    }
}
