@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Unavailables</div>

                    <div class="card-body">
                    
                    <table id="unav-table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Created at</th>
                            <th>Title</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($unavailables as $i => $unav)
                        <tr>
                            <td>{{$unav['id']}}</td>
                            <td>{{$users[$i]->name}}</td>
                            <td>{{Carbon\Carbon::parse($unav->start)->format('D j-M g:i A')}}</td>
                            <td>{{Carbon\Carbon::parse($unav->end)->format('D j-M g:i A')}}</td>
                            <td>{{$unav['created_at']->diffForhumans()}}</td>
                            <td>{{$unav['title']}}</td>
                            <td>{{ Form::open(['method' => 'DELETE', 'action' => ['UnavailablesController@destroy', $unav->id]]) }}
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Repeatables</div>
                    <div class="card-body">

                    <table id="rep-table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Days</th>
                            <th>Created at</th>
                            <th>Title</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($repeatables as $i=>$rep)
                        <tr>
                            <td>{{$rep['id']}}</td>
                            <td>{{$users2[$i]->name}}</td>
                            <td>{{Carbon\Carbon::parse($rep->start)->format('g:i A')}}</td>
                            <td>{{carbon\Carbon::parse($rep->end)->format('g:i A')}}</td>
                            <td>@foreach ($days as $j=>$day)
                                @if ($rep->$day) {{$day.' '}} @endif 
                                @endforeach
                            </td>
                            <td>{{$rep['created_at']->diffForhumans()}}</td>
                            <td>{{$rep->title}}</td>
                            <td>   
                                {{ Form::open(['method' => 'DELETE', 'action' => ['UnavailablesController@RepDestroy', $rep->id]]) }}
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
    $('#unav-table').DataTable();
    } );
    $(document).ready( function () {
    $('#rep-table').DataTable();
    } );
</script>
@endsection