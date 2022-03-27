@extends('layouts.app')

@section('content')
<div class='container'>

    <div class='row pt-3 pb-4'>
        <div class='col'>
            <h1 class='text-uppercase'>{{__('main.browse_companies')}}</h1>
        </div>
    </div>
    
    <hr>

    <div class='row py-3'>
        <div class='col'>
            <?php $counter=0; ?>
            @foreach ($companies as $company)
                @if ($counter % 2 == 0)
                    <div class='row'>
                @endif
                <div class='col-md py-2 px-3'>
                    <div>
                        <a href='{{isset($accessToken) && isset($userId) ? $company->portal_url . '/login/' . $userId . '/' . $accessToken : $company->portal_url}}'
                            target='_blank'>
                            <div class='button_big py-3 px-2'>
                                <div>
                                    <img src="{{asset($company->logo)}}" width="100px" class="mr-4" />
                                    <div>{{$company->name}}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @if (Auth::user() && Auth::user()->isSuperAdmin())
                        <div class="pt-2">
                            <a href="{{url('/companies/'.$company->id.'/edit')}}" class='link_main'>EDIT</a>
                        </div>
                    @endif
                </div>
                @if ($counter % 2 != 0)
                    </div>
                @endif
                <?php $counter++; ?>
            @endforeach
            @if ($counter % 2 != 0) </div> @endif
        </div>
    </div>

</div>
@endsection