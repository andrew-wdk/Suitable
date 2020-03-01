@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Events</div>

                    <div class="card-body">
            
                    <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Host</th>
                            <th>Created at</th>
                        </thead>
                        <tbody>

                        @if($events)
                            @foreach($events as $i => $event)
                        <tr>
                            <td>{{$event['id']}}</td>
                            <td>{{$event['title']}}</td>
                            <td>{{$hosts[$i]->name}}</td>
                            <td>{{$event['created_at']->diffForhumans()}}</td>                            
                            <td>{{ Form::open(['method' => 'DELETE', 'action' => ['EventsController@destroy', $event->id]]) }}
                                {{ Form::submit('delete')}}
                                {{ Form::close()}}
                            </td>
                        </tr>
                            @endforeach
                        @endif
                        
                    </tbody>
                            
                    </table>
                    <div class ="row justify-content-center">
                        {{$events->links()}}
                    </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection