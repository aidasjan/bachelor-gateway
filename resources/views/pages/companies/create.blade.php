@extends('layouts.app')

@section('content')
<div class='container'>

    <div class='row'>
        <div class='col container_grey py-5'>
            <h1 class='pb-3'>NEW COMPANY</h1>
            <form method="POST" action="{{ route('companies.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                    <div class="col-md-5">
                        <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="logo" class="col-md-4 col-form-label text-md-right">Logo URL</label>
                    <div class="col-md-5">
                        <input id="logo" class="form-control" name="logo" value="" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="code" class="col-md-4 col-form-label text-md-right">Code</label>
                    <div class="col-md-5">
                        <input id="code" type="text" class="form-control" name="code" value="" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="webpage_url" class="col-md-4 col-form-label text-md-right">Webpage URL</label>
                    <div class="col-md-5">
                        <input id="webpage_url" type="text" class="form-control" name="webpage_url" value="" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="portal_url" class="col-md-4 col-form-label text-md-right">Portal URL</label>
                    <div class="col-md-5">
                        <input id="portal_url" type="text" class="form-control" name="portal_url" value="" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                    <div class="col-md-5">
                        <input id="address" type="text" class="form-control" name="address" value="" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                    <div class="col-md-5">
                        <input id="email" type="email" class="form-control" name="email" value="" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>
                    <div class="col-md-5">
                        <input id="phone" type="text" class="form-control" name="phone" value="" required autofocus>
                    </div>
                </div>

                <div class="form-group row mb-0 pt-3">
                    <div class="col-md-4 offset-md-4">
                        <button type="submit" class="btn btn-primary">ADD</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection
