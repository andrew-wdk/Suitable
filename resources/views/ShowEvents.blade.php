@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Events</div>

                    <div class="card-body">

                    <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Discription</th>
                            <th>Created at</th>
                        </thead>
                        <tbody>

                        @if($events)
                            @foreach($events as $event)

                        <tr>
                            <td>{{$event['title']}}</td>
                            <td>{{$event['discription']}}</td>
                            <td>{{$event['created_at']->diffForhumans()}}</td>
                            <td><a href="{{ route('events.show', ['event' => $event->id]) }}">Show</a></td>
                            @can('view-participants',[$event])
                                <td><a href="{{ route('shareEvent', ['id' => $event->id]) }}">Get sharable link</a>
                                @if(isset($link) && $link->shareable_id == $event->id)
                                    <br>
                                    <input type="text" id="Id" name="link" value="{{$link->url}}">
                                @endif
                            @endcan
                            </td>
                            <td>{{ Form::open(['method' => 'DELETE', 'action' => ['EventsController@destroy', $event->id]]) }}
                                @can('delete', [$event]) {{ Form::submit('delete')}} @endcan
                                {{ Form::close()}}
                            </td>
                        </tr>
                            @endforeach
                        @endif

                    </tbody>
                    </table>

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
