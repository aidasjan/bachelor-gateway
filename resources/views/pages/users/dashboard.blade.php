@extends('layouts.app')

@section('content')
    <div class='container'>

        <div class='row py-5'>
            <div class='col'>
                <h5>{{auth()->user()->name}} | {{auth()->user()->email}}</h5>
                <h1 class='text-uppercase'>{{ __('main.dashboard') }}</h1>
            </div>
        </div>

        @if(Auth::user()->isSuperAdmin())
            <div class='row'>
                <div class='col-md py-4 my-3 dashboard_box container_lightblue'>
                    <h3>Add New Company</h3>
                    <div class='pb-3'><span>Add an admin and generate a password</span></div>
                    <a href="{{url('/companies/create')}}" class='btn btn-primary'>NEW COMPANY</a>
                </div>
            </div>

            <div class='row'>
                <div class='col-md py-4 mr-3 my-3 dashboard_box container_lightblue'>
                    <h3>Add New Admin</h3>
                    <div class='pb-3'><span>Add an admin and generate a password</span></div>
                    <a href="{{url('/users/create')}}" class='btn btn-primary'>NEW ADMIN</a>
                </div>
                <div class='col-md py-4 ml-3 my-3 dashboard_box container_lightblue'>
                    <h3>Admins</h3>
                    <div class='pb-3'><span>Edit and disable admins</span></div>
                    <a href="{{url('/users')}}" class='btn btn-primary'>MANAGE ADMINS</a>
                </div>
            </div>
        @endif

        <div class='row py-4'>
            <div class='col py-2 dashboard_box container_lightblue'>
                <div class='row py-3'>
                    <div class='col text-left'>
                        <h3>{{ __('main.my_account') }}</h3>
                        <span>{{ __('main.my_account_desc') }}</span>
                    </div>
                </div>

                <div class='row py-1'>
                    <div class='col text-left'>
                        <h5><b>{{ __('main.name_person') }}: </b>{{auth()->user()->name}}</h5>
                        <h5 class='pb-2'><b>{{ __('main.email') }}: </b>{{auth()->user()->email}}</h5>
                        <a href="{{url('/password')}}" class='link_main text-uppercase'>{{ __('main.change_password') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection