@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>{{$user->name}}</h3></div>

                <div class="panel-body">
                    @foreach($user->services as $service)
                    {{$service->name}} <a href="{{route('service_profile',[$user->username,$service->url])}}"> ({{$service->duration}} mins)</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
