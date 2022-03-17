@extends('layouts.app')

@section('content')
    <div class='container'>

        <div class='row py-5'>
            <div class='col'>
                <h5>{{auth()->user()->name}} | {{auth()->user()->email}}</h5>
                <h1 class='text-uppercase'>{{ __('main.dashboard') }}</h1>
            </div>
        </div>

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