<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events;
use App\Http\Resources\EventsResource;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Events $event)
    {
        $events = Events::all()->last();
        // $finalDates = $event->getDatesInBetween($events);
        return new EventsResource($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Events;
        $event->eventName = $request->input('eventName');
        $event->startDate = $request->input('startDate');
        $event->endDate = $request->input('endDate');
        $event->filteredDates = $request->input('filteredDates');
        if($event->save()){
            return new EventsResource($event);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

}
