@extends('layouts.app')

@section('content')
<div class='container'>

    <div class='row'>
        <div class='col container_grey py-5'>
            <h1 class='pb-3'>NEW ADMIN</h1>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                    <div class="col-md-5">
                        <input id="name" type="text" class="form-control" name="name" value="" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                    <div class="col-md-5">
                        <input id="email" type="email" class="form-control" name="email" value="" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-4 col-form-label text-md-right">Company</label>
                    <div class="col-md-5">
                        <select class="form-control" name="company_id">
                            @foreach($companies as $company)
                                <option value="{{$company->id}}">{{$company->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-0 pt-3">
                    <div class="col-md-4 offset-md-4">
                        <button type="submit" class="btn btn-primary">REGISTER</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection
