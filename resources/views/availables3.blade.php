@extends('layouts.app')

@section('styles')
<style>
    .block {
        height: 1.5em;
        float: left;
        text-overflow: clip;
        text-indent: -9999px;
    }
    .block:hover, .level:hover{
        box-shadow: 1px 1px 3px;
    }
    .blocks_canvas{
        /* margin-left: 4%; */
        background-image: url('../picture1.png');
        background-size: 96%;
    }
    .row{
        margin-left: 0px !important;
        margin-right: 0px !important;
    }
    .level{
        text-align: center;
        font-size: 1vw;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <div class="col-md-12">
    <div class="card">
    <div class="card-header"> {{$event->title}} </div>
    <div class="card-body">

    <div id="container" class = "blocks_canvas">
    <div class ="row" id="first_row"></div>
    </div>
    <hr style="width:100%;text-align:left;margin-left:0;margin-bottom:0">
    <div id="levels" class="row"></div>
    {{-- <div style="position: absolute; left:0%">| 12:00AM</div>
        <div style="position: absolute; left:8%">| 02:00AM</div>
        <div style="position: absolute; left:16%">| 04:00AM</div>
        <div style="position: absolute; left:24%">| 06:00AM</div>
        <div style="position: absolute; left:32%">| 08:00AM</div>
        <div style="position: absolute; left:40%">| 10:00AM</div>
        <div style="position: absolute; left:48%">| 12:00PM</div>
        <div style="position: absolute; left:56%">| 02:00PM</div>
        <div style="position: absolute; left:64%">| 04:00PM</div>
        <div style="position: absolute; left:72%">| 06:00PM</div>
        <div style="position: absolute; left:80%">| 08:00PM</div>
        <div style="position: absolute; left:88%">| 10:00PM</div> --}}
    <br><br>


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


        @if($user->can('view-participants',$event) || $user->hasRole('admin|super_admin'))
        {{-- @can('view-participants',[$event]) --}}
            <br>
            <h2> Participants: </h2>
            <ol>
                @foreach($guests as $user)
                    <li> {{$user->name}} </li>
                @endforeach
            </ol>
        {{-- @endcan --}}
        @endif

    </div>
    </div>
    </div>
    </div>
    </div>
</div>
@endsection


@section('scripts')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@javascript('test', $blocks)
<script>

    var blocks = JSON.parse(test);
    console.log(blocks);
    var drawn = document.getElementsByClassName("js");
    if(drawn.length > 0){
        for (var i = 0; i < drawn.length; i++) {
            drawn[i].remove()
        }
    }

    var cont = document.getElementById("container");
    var startDate = new Date(blocks[0].startDate);
    var day = startDate.getDate();

    var row = document.getElementById("first_row");
    var first_block = document.createElement("DIV");
    first_block.style.width = (startDate.getTime()-startDate.setHours(0,0,0))/900000+"%";
    first_block.className = "js"
    row.appendChild(first_block);

    var sorted = Object.create(blocks);
    sorted.sort(function(a, b){return b.user_id - a.user_id});
    var max_level = sorted[0].user_id;
    if (max_level < 12) max_level = 12;

    function heatMap(level, max){
        var h = 21.25*level*12/max;
        var r = Math.floor(h);
        var g = Math.floor(12-h*0.8);
        var b = Math.floor(255-h);
        var a = 0.5+(h/10*0.04);
        var col = "rgba(" + r + "," + g + "," + b + "," + a + ")";
        return col;
    }

    for (let i = 0; i < blocks.length; i++) {

        var date = new Date(blocks[i].startDate);
        var endDate = new Date(blocks[i].endDate);
        var child = document.createElement("DIV");

        child.style.backgroundColor = heatMap(blocks[i].user_id, max_level);


        if (endDate.getDate() != date.getDate()){
            var overflow = endDate.getTime()-endDate.setHours(0,0,0);
            var child2 = document.createElement("DIV");
            child2.className = "block";
            child2.innerHTML = blocks[i].user_id;
            child2.style.width = overflow/900000 + "%";
            child2.style.backgroundColor = heatMap(blocks[i].user_id, max_level);
            var width = (endDate-date)/900000;
        }
        else{
            var width = blocks[i].length*4;
        }

        child.className = "block";
        child.innerHTML = blocks[i].user_id;
        child.style.width = width + "%";

        function newRow(){
            row = document.createElement("DIV");
            row.className = "row";
            cont.appendChild(row);
            day += 1;
        }
        if (date.getDate() == day+1){
            newRow();
            row.appendChild(child);
        }
        else if(overflow > 0){
            row.appendChild(child);
            newRow();
            overflow = 0;
            row.appendChild(child2)
        }
        else{
            row.appendChild(child);
        }
    }
    row = document.getElementById("levels");
    row.style.marginTop = "1em";
    for (var i = 0; i <= max_level; i++){
        var level_block = document.createElement("div");
        level_block.innerHTML = i;
        level_block.style.backgroundColor = heatMap(i, max_level);
        level_block.style.width = 3/Math.ceil(max_level/30) + "%";
        level_block.className = "level";
        row.appendChild(level_block);
    }

    function hide(level){
        var block_divs = document.getElementsByClassName("block");
        for (var i = 0; i < block_divs.length; i++){
            block_divs[i].style.opacity = null;
            if (level == null) continue;
            if(block_divs[i].innerHTML > level){
                block_divs[i].style.opacity = 0;
            }else{
                console.log(block_divs[i].innerHTML, level)
            }
        }
    }

    $(document).ready(function(){
    $(".level").hover(function(){
    hide(Number($(this).text()));
    }, function(){
    hide(null);
  });
});
</script>

@endsection

