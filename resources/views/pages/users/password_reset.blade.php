@extends('layouts.app')

@section('content')
    <div class='container'>
        <div class='row py-5 container_grey'>
            <div class='col'>
                <form action="{{ action('App\Http\Controllers\UsersController@sendPasswordReset') }}" method='POST'>
                    
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('main.email') }}</label>
                        <div class="col-md-5">
                            <input id="email" type="email" class="form-control" name="email" value="" required autofocus>
                        </div>
                    </div>

                    {{csrf_field()}}

                    <div class="form-group row mb-0">
                        <div class="col-md-4 offset-md-4">
                            <button type="submit" class="btn btn-primary text-uppercase">
                                {{ __('main.change') }}
                            </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
@endsection