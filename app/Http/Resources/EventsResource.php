<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        EventsResource::withoutWrapping();
        return [
            'eventName' => $this->eventName,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'filteredDates' => $this->filteredDates
        ];
    }

    public function with($request) {
        return [
          'meta' => $request->meta
        ];
    }
}
