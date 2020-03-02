@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Event</div>

                    <div class="card-body">
                    <p>Event name: {{$event->title}}</p>
                    <p>Description: {{$event->description}}</p>
                    <p>Host: {{$host->name}}</p>
                    <p>Range: {{Carbon\Carbon::parse($event->startDate)->format('l j-M g:i A')}} - 
                    {{Carbon\Carbon::parse($event->endDate)->format('l j-M g:i A')}}</p>
                    <p>Duration: {{$event->duration}} hours</p>
                    {{ Form::open(['method' => 'GET', 'action' => ['EventsController@confirmParticipation', $event->id]]) }}
                    {{ Form::submit('Participate')}}
                    {{ Form::close()}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection