@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Set an Appointment</h3></div>

                <div class="panel-body">
                <div><a href="{{route('service_profile',[$service->owner->username,$service->url])}}">{{$service->name}}</a></div>
                    <div><a href="{{route('profile',$service->owner->username)}}">{{$service->owner->name}}</a></div>
                    <div>{{$start->format('F j\\, Y l')}}</div>
                    <div>{{$start->format('h:i')}} - {{$end->format('h:i A')}}</div>
                    <br>
                    {!! form($form) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
