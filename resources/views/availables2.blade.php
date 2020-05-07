@extends('layouts.app')

@section('styles')
<style>
    .block {
        position: absolute;
        border: solid;
        border-width: 1px;
        border-radius: 6px;
        text-align: center;
        /* background-color: hsl(100, 100%, 50%); */
        opacity: 0.3;
    }
    .block:hover{
        border-width: 3px;
    }
</style>

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-12">
    <div class="card">
    <div class="card-header"> {{$event->title}} </div>
    <div class="card-body">

    <div id="block" class="block" style=left:10%></div>
    <div id="container" class="block_container"></div>

        {{-- {{dd($blocks)}} --}}










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
                    @if($av->startDate->floatDiffInHours($av->endDate) < $event->duration)
                        @continue;
                    @endif
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


@section('scripts')
@javascript('test', $blocks)
<script>
    var cols = Array("#ff0000", "#808000", "#696969", "#2e8b57", "#800000", "#191970", "#ff8c00", "#ffd700", "#0000cd", "#ba55d3", "#00ff7f", "#adff2f", "#ff00ff",
    "#fa8072", "#4b0082", "#87cefa", "#00ff00", "#778899");

    var blocks = JSON.parse(test);
    console.log(blocks);

    var cont = document.getElementById("container");
    // cont.style.position = "relative";
    var block = document.getElementById("block");
    var day = new Date(blocks[0].startDate);
    var startTime = day;
    day = day.getDate() - 1;
    startTime = startTime.setHours(0,0,0);
    console.log(startTime);
    var row, br;
    var style = getComputedStyle(block);
    var hsl = style.backgroundColor;
    console.log(hsl);
    for (let i = 0; i < blocks.length; i++) {
        var date = new Date(blocks[i].startDate);
        var endDate = new Date(blocks[i].endDate);
        var child = document.createElement("DIV");
        // var child = block;
        var date = new Date(blocks[i].startDate);
        var endDate = new Date(blocks[i].endDate);
        var left = Math.round(((date.getTime()-startTime)%86400000)/900000);
        console.log(left);
        // if (endDate.getHours() < date.getHours()){
        //     var width = (endDate.getHours()-date.getHours()+24)*4;}
        // else{
        //     var width = (endDate.getHours()-date.getHours())*4;}
        var width = Math.round((endDate.getTime()-date.getTime())/900000);

        console.log(width);

        child.innerHTML = blocks[i].user_id;
        child.className = "block";
        child.style.left = left + "%";
        child.style.width = width + "%";
        child.style.backgroundColor = cols[i%18];
        if (date.getDate() == day+1){
            row = document.createElement("DIV");
            row.className = "row";
            row.style.position = "relative";
            br = document.createElement("br");
            cont.appendChild(br);

            cont.appendChild(row);
            day += 1;
            console.log("in");
        }

        row.appendChild(child);
    }
</script>

@endsection

