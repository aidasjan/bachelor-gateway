@extends('layouts.app')

@section('content')
<div class='container'>

    <div class='row'>
        <div class='col container_grey py-5'>
            <h1 class='text-uppercase pb-3'>EDIT - {{$company->name}}</h1>
            <form method="POST" action="{{ action('App\Http\Controllers\CompaniesController@update', $company->id) }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                    <div class="col-md-5">
                        <input id="name" type="text" class="form-control" name="name" value="{{$company->name}}" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="logo" class="col-md-4 col-form-label text-md-right">Logo URL</label>
                    <div class="col-md-5">
                        <input id="logo" class="form-control" name="logo" value="{{$company->logo}}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="code" class="col-md-4 col-form-label text-md-right">Code</label>
                    <div class="col-md-5">
                        <input id="code" type="text" class="form-control" name="code" value="{{$company->code}}" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="webpage_url" class="col-md-4 col-form-label text-md-right">Webpage URL</label>
                    <div class="col-md-5">
                        <input id="webpage_url" type="text" class="form-control" name="webpage_url" value="{{$company->webpage_url}}" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="portal_url" class="col-md-4 col-form-label text-md-right">Portal URL</label>
                    <div class="col-md-5">
                        <input id="portal_url" type="text" class="form-control" name="portal_url" value="{{$company->portal_url}}" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                    <div class="col-md-5">
                        <input id="address" type="text" class="form-control" name="address" value="{{$company->address}}" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                    <div class="col-md-5">
                        <input id="email" type="email" class="form-control" name="email" value="{{$company->email}}" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>
                    <div class="col-md-5">
                        <input id="phone" type="text" class="form-control" name="phone" value="{{$company->phone}}" required autofocus>
                    </div>
                </div>

                <input type='hidden' name='_method' value='PUT'>

                <div class="form-group row mb-0 pt-3">
                    <div class="col-md-4 offset-md-4">
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>

    <div class='row'>
        <div class='col py-3'>
            <form method="POST" action="{{ action('App\Http\Controllers\CompaniesController@update', $company->id) }}">
                @csrf
                <input type='hidden' name='_method' value='DELETE'>
                <button type="submit" class="btn btn-link link_red">DISABLE COMPANY</button>
            </form>
        </div>
    </div>
</div>
@endsection
