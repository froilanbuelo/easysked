@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                <h3><a href="{{route('profile',$user->username)}}">{{$user->name}}</a></h3>
                <h4>{{$service->name}}</h4>
                <h5>{{$service->duration}} mins</h5>
                
                </div>

                <div class="panel-body">
                    <p>{{$service->description}}</p>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    @foreach($service->generateAvailabilities() as $k => $v)
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="heading{{$k}}">
                            <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$k}}" aria-expanded="true" aria-controls="collapse{{$k}}">
                              @if (count($v) > 0 ) 
                              <span class="text-primary">{{Carbon\Carbon::parse($k)->format('F j\\, Y l')}} ( {{count($v)}} )</span>
                              @else
                              {{Carbon\Carbon::parse($k)->format('F j\\, Y l')}} 
                              @endif
                            </a>
                            </h4>
                        </div>

                        <div id="collapse{{$k}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$k}}">
                            <div class="panel-body">
                                @foreach($v as $kk => $vv)
                                    <div><a href=''>{{$vv[0]->format('g:i')}} - {{$vv[1]->format('g:i a')}}</a></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
