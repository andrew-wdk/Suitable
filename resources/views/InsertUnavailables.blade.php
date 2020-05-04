@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Unavailable</div>

                    <div class="card-body">

                    {{ Form::open(['method' => 'POST', 'action' => 'UnavailablesController@store']) }}

                    <dev>
                    {{ Form::label('start', 'Start:') }}
                    {{ Form::datetime('start', date('Y-m-d H:i').':00') }}
                    <br>
                    </dev>

                    <dev>
                    {{ Form::label('end', 'End:') }}
                    {{ Form::datetime('end', date('Y-m-d H:i').':00') }}
                    <br>
                    </dev>

                    <dev>
                    {{ Form::label('title', 'Title:') }}
                    {{ Form::text('title', null) }}
                    <br>
                    </dev>

                    <dev>
                    {{ Form::label('Repeat', 'Repeat every: Sun ') }}
                    {{ Form::checkbox('7', true)}}
                    {{ Form::label('Mon', ' Mon ') }}
                    {{ Form::checkbox('1', true)}}
                    {{ Form::label('Tue', ' Tue ') }}
                    {{ Form::checkbox('2', true)}}
                    {{ Form::label('Wed', ' Wed ') }}
                    {{ Form::checkbox('3', true)}}
                    {{ Form::label('Thu', ' Thu ') }}
                    {{ Form::checkbox('4', true)}}
                    {{ Form::label('Fri', ' Fri ') }}
                    {{ Form::checkbox('5', true)}}
                    {{ Form::label('Sat', ' Sat ') }}
                    {{ Form::checkbox('6', true)}}
                    <br>
                    </dev>

                    <dev>
                    {{ Form::text('priority', '1', $attributes = array('hidden')) }}
                    </dev>

                    {{ Form::submit('insert') }}

                    {{ Form::close() }}

                    <div class="text-danger"><br>{{$errors->first()}}<div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
