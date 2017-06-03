@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-danger">
                <div class="panel-heading">Oops...something went wrong.</div>

                <div class="panel-body">
                    This time slot is not available now. <br>Please click <a href="{{route('service_profile',[$service->owner->username, $service->url])}}">here</a> to go back to the available time slots.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
