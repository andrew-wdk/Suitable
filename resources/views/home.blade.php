@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!

                </div>

                <div class="card-body">
                <a href="{{ route('events.create') }}">Create new Event</a>
                <br>
                <a href="{{ route('events.index') }}">My Events</a>
                <br>
                <a href="{{ route('unavailables.create') }}">Insert Unavailables</a>
                <br>
                <a href="{{ route('unavailables.index') }}">My Unavailables</a>
                <br>
                {{-- <a href="{{ route('MakeAdmin') }}">MakeAdmin</a> --}}
                </div>

                @role('admin')
                <div class="card-body">
                <a href="{{ route('admin') }}">admin</a>
                </div>
                @endrole

            </div>
        </div>
    </div>
</div>
@endsection
