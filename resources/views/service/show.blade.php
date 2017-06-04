@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div>
                        <h3>{{ $service->name}}</h3>
                        <div>{{ $service->owner->name }}</div>
                        <div>{{ $service->duration }} minutes</div>
                        <div>{{ $service->description }}</div>
                    </div>
                </div>

                <div class="panel-body">
                    <h4>Schedule</h4>
                    <div>
                        @if (count($service->schedules) > 0)
                        @else
                        No Schedule Yet. <a href="">Add</a>
                        @endif
                    </div>
                    <h4>Questions</h4>
                        @if (count($service->questions) > 0)
                        @else
                        No Questions Yet. <a href="">Add</a>
                        @endif
                    <h4>Payment</h4>
                    <div>{{$service->is_payment_required?"Payment is Required":"Payment is not Required to book this service."}}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
