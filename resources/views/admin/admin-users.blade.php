@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Users</div>

                    <div class="card-body">
            
                    <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Created at</th>
                            <th>Delete</th>
                            <th>Make admin</th>
                        </td>
                    </thead>
                    <tbody>

                    @if($users)
                        @foreach($users as $user)
                    <tr>
                        <td>{{$user['id']}}</td>
                        <td>{{$user['name']}}</td>
                        <td>{{$user['email']}}</td>
                        <td>{{$user['created_at']->diffForhumans()}}</td>                  
                        <td>{{ Form::open(['method' => 'DELETE', 'action' => ['UsersController@destroy', $user->id]]) }}
                            {{ Form::submit('delete')}}
                            {{ Form::close()}}
                        </td>
                        @if (!$user->hasRole('admin'))
                        <td>{{ Form::open(['method' => 'POST', 'action' => ['AdminController@MakeAdmin', $user->id]]) }}
                            {{ Form::submit('Make Admin')}}
                            {{ Form::close()}}
                        </td>
                        @endif
                        @if ($user->hasRole('admin'))
                        <td>
                        </td>
                        @endif    
                    </tr>
                    @endforeach
                    @endif
                        
                    </tbody>
                            
                    </table>
                    {{-- <div class ="row justify-content-center">
                        {{$users->links()}}
                    </div> --}}

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