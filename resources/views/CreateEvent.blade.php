
@extends('layouts.app')

@section('styles')
<link href="{{url('../resources/rome-master/dist/rome.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Event</div>

                    <div class="card-body">

                    {{ Form::open(['method' => 'POST', 'action' => 'EventsController@store']) }}

                    <dev>
                    {{ Form::label('title', 'Title:') }}
                    {{ Form::text('title', null) }}
                    <br>
                    </dev>

                    <dev>
                    {{ Form::label('description', 'Description:') }}
                    {{ Form::text('description', '') }}
                    <br>
                    </dev>

                    <dev>
                    {{ Form::label('duration', 'Duration:') }}
                    {{ Form::number('duration', null) }}
                    <br>
                    </dev>

                    <dev>
                    {{ Form::label('DateTimeRange', 'Date-time range:') }}
                    {{ Form::datetime('startDate', date('Y-m-d H:i'), ['id' => 'start']) }}
                    {{ Form::datetime('endDate', date('Y-m-d H:i'), ['id' => 'end']) }}
                    <br>
                    </dev>

                    <dev>
                    {{ Form::text('participants', 1, $attributes = array('hidden')) }}
                    </dev>

                    {{ Form::submit('Create') }}

                    {{ Form::close() }}

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{url('../resources/rome-master/dist/rome.js')}}"></script>
<script>
rome(start);
rome(end);
</script>
@endsection
