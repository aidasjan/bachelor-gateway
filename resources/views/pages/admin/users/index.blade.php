@extends('layouts.app')

@section('content')
    <div class='container'>

        <div class='row py-5'>
            <div class='col'>
            <h1>USERS</h1>
            </div>
        </div>

        <div class='row py-3'>
            <div class='col'>
                <table class='table table-responsive-md table_main'>
                    <tr><th></th><th>NAME</th><th>EMAIL</th><th>ROLE</th><th>COMPANY</th><th></th></tr>
                    <?php $counter = 1 ?>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$counter++}}.</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->role}}</td>
                            <td>@if ($user->company) {{$user->company->name}} @endif</td>
                            <td>@if (!$user->isSuperAdmin()) <a href="{{url('users/'.$user->id.'/edit')}}" class='link_main'>EDIT</a> @endif</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        
    </div>
@endsection