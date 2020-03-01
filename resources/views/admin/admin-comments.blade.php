@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Comments</div>

                    <div class="card-body">
                    
                    <table id="Comm-table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Event ID</th>
                            <th>User</th>
                            <th>Body</th>
                            <th>Created at</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($comments as $i => $comment)
                        <tr>
                            <td>{{$comment['id']}}</td>
                            <td>{{$comment['event_id']}}</td>
                            <td>{{$users[$i]->name}}</td>
                            <td>{{$comment['body']}}</td>
                            <td>{{$comment['created_at']->diffForhumans()}}</td>
                            <td>{{ Form::open(['method' => 'DELETE', 'action' => ['CommentsController@destroy', $comment->id]]) }}
                                {{ Form::submit('delete')}}
                                {{ Form::close()}}
                            </td>
                        </tr>
                    @endforeach
                                               
                    </tbody>
                            
                    </table>

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
    $('#Comm-table').DataTable();
    } );
</script>
@endsection