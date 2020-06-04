@extends('layouts.app')

@section('styles')
<link href="{{url('../resources/rome-master/dist/rome.css')}}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Unavailable</div>

                    <div class="card-body">


                    {{ Form::open(['method' => 'POST', 'action' => 'UnavailablesController@store']) }}


                    <div>
                    {{ Form::label('start', 'Start:') }}
                    {{ Form::datetime('start', date('Y-m-d H:i'), ['id' => 'start']) }}
                    <br>
                    </div>

                    <div>
                    {{ Form::label('end', 'End:') }}
                    {{ Form::datetime('end', date('Y-m-d H:i'), ['id' => 'end']) }}
                    <br>
                    </div>

                    <div>
                    {{ Form::label('title', 'Title:') }}
                    {{ Form::text('title', null) }}
                    <br>
                    </div>

                    <div>
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
                    </div>

                    <div>
                    {{ Form::text('priority', '1', $attributes = array('hidden')) }}
                    </div>

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

@section('scripts')
<script src="{{url('../resources/rome-master/dist/rome.js')}}"></script>
<script>
rome(start);
rome(end);
</script>
@endsection
