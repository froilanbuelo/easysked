@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Accounts</h3></div>

                <div class="panel-body">
                    @foreach($users as $user)
                    <div><a href="{{route('profile',[$user->username])}}">{{$user->name}}</a></div>
                    @endforeach
                    {{$users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
