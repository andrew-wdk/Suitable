@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Events</div>

                    <div class="card-body">

                    <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Host</th>
                            <th>Created at</th>
                            <th>Action</th>
                        </thead>
                        <tbody>

                        @if($events)
                            @foreach($events as $i => $event)
                        <tr>
                            <td>{{$event['id']}}</td>
                            <td>{{$event['title']}}</td>
                            <td>{{$hosts[$i]->name}}</td>
                            <td>{{$event['created_at']->diffForhumans()}}</td>
                            <td>
                                <div class="row">
                                    <div>
                                        {{ Form::open(['method' => 'DELETE', 'action' => ['EventsController@destroy', $event->id]]) }}
                                        {{ Form::submit('delete')}}
                                        {{ Form::close()}}
                                    </div>
                                    <div>
                                        {{ Form::open(['method' => 'GET', 'action' => ['EventsController@show', $event->id]]) }}
                                        {{ Form::submit('show')}}
                                        {{ Form::close()}}
                                    </div>
                                </div>
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

@section('scripts')
<script type="text/javascript">
    $(document).ready( function () {
    $('#table').DataTable();
    } );
</script>
@endsection
