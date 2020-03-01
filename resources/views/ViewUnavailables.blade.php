@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-12">
    <div class="card">
    <div class="card-header"> My Unavailables </div>
    <div class="card-body">
            
        <table class="table">
            <thead>
            <tr>
                <th>Start</th>
                <th>End</th>
                <th>Title</th>
                <th></th>
            </tr>
            </thead>
            
            <tbody>
            @if($unavailables)
                @foreach($unavailables as $i=>$unav)
                    <tr>
                        <td>{{Carbon\Carbon::parse($unav->start)->format('l j-M g:i A')}}</td>
                        <td>{{carbon\Carbon::parse($unav->end)->format('l j-M g:i A')}}</td>
                        <td>{{$unav->title}}
                        <td>   
                            {{ Form::open(['method' => 'DELETE', 'action' => ['UnavailablesController@destroy', $unav->id]]) }}
                            {{ Form::submit('delete')}}
                            {{ Form::close()}}
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        <table class="table">
            <thead>
            <tr>
                <th>Start</th>
                <th>End</th>
                <th>repeat every</th>
                <th>Title</th>
                <th></th>
            </tr>
            </thead>
            
            <tbody>
            @if($repeatables)
                @foreach($repeatables as $i=>$rep)
                    <tr>
                        <td>{{Carbon\Carbon::parse($rep->start)->format('g:i A')}}</td>
                        <td>{{carbon\Carbon::parse($rep->end)->format('g:i A')}}</td>
                        <td>@foreach ($days as $j=>$day)
                            @if ($rep->$day) {{$day.' '}} @endif 
                            @endforeach
                        </td>
                        <td>{{$rep->title}}</td>
                        <td>   
                            {{ Form::open(['method' => 'DELETE', 'action' => ['UnavailablesController@RepDestroy', $rep->id]]) }}
                            {{ Form::submit('delete')}}
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