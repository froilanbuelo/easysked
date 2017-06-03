<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show($username){
    	$user = User::where('username',$username)->first();
    	if (!$user){
    		abort(405);
    	}
   		return view('profile',compact('user'));
    }
    public function service_profile($username, $service, Request $request){ 
    	$user = User::where('username',$username)->first();
    	if (!$user){
    		abort(405);
    	}
    	$service = $user->services()->where('url',$service)->first();
    	if (!$service){
    		abort(405);
    	}
        $availabilities = null;
        $date = Carbon::now();
        $days = 7;
        if ($request->has('date')){
            $date = Carbon::parse($request->get('date'));
        }
        if ($request->has('days')){
            $days = $request->get('days');
        }
        $availabilities = $service->generateAvailabilities($date->toDateString(),$days);
    	return view('service',compact('user','service','availabilities','date','days'));
    }
}
