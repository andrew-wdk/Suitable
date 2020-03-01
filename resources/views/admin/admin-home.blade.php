@extends('layouts.main')


@section('content')
<div class="col-lg-8">
    <section class="content-max-width">
        <section id="info-box">
            <h3>App Statistics</h3>
            <!-- Info Boxes -->
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue"><a href="{{route('users.index')}}"><i class="fa fa-user"></i></a></span>
                        <div class="info-box-content">
                            <span class="info-box-text">User</span>
                            <span class="info-box-number">{{$users}}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-cyan"><a href="{{route('admin.events')}}"><i class="far fa-calendar-alt"></i></a></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Events</span>
                            <span class="info-box-number">{{$events}}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-teal"><a href="{{route('admin.unavailables')}}"><i class="far fa-flag"></i></a></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Unavailables</span>
                            <span class="info-box-number">{{$unavailables}}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><a href="{{route('admin.comments')}}"><i class="fa fa-comments"></i></a></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Comments</span>
                            <span class="info-box-number">{{$comments}}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section>
    </section>
</div>


@endsection