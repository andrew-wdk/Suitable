@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-12">
    <div class="card">
    <div class="card-header"> {{$event->title}} </div>
    <div class="card-body">
            
        <table class="table">
            <thead>
            <tr>
                <th>Start</th>
                <th>End</th>
                <th>length</th>
                <th>comments</th>
            </tr>
            </thead>
            
            <tbody>
            @if($availables)
                @foreach($availables as $i=>$av)
                    <tr>
                        <td>{{$av->startDate->format('l j-M g:i A')}}</td>
                        <td>{{$av->endDate->format('l j-M g:i A')}}</td>
                        <td>{{$av->startDate->floatDiffInHours($av->endDate)}} hours </td>
                        <td>
                            {{-- new comment text box --}}
                            {{ Form::open(['method' => 'POST', 'action' => 'CommentsController@store']) }}
                            {{ Form::text('body', null) }}
                            {{ Form::hidden('event_id', $event->id)}}
                            {{ Form::hidden('start', $av->startDate)}}
                            {{ Form::submit('>') }}
                            {{ Form::close()}}

                            {{-- comments and delete button --}}
                            @foreach($comments[$i] as $comment)                            
                                {{ Form::open(['method' => 'DELETE', 'action' => ['CommentsController@destroy', $comment->id]]) }}
                                <font color="red">{{$comment->user->name}}: &nbsp</font> {{$comment->body}}
                                @can('delete', [$comment]) {{ Form::submit('del')}} @endcan
                                {{ Form::close()}}
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
                    
        @can('view-participants',[$event])
            <br>
            <h2> Participants: </h2>
            <ol>
                @foreach($guests as $user)
                    <li> {{$user->name}} </li>
                @endforeach 
            </ol>
        @endcan
                    
    </div>
    </div>
    </div>
    </div>
    </div>
</div>
@endsection