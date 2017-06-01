<?php

namespace App\Http\Controllers;

use App\User;
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
    public function service_profile($username, $service){ 
    	$user = User::where('username',$username)->first();
    	if (!$user){
    		abort(405);
    	}
    	$service = $user->services()->where('url',$service)->first();
    	if (!$service){
    		abort(405);
    	}
    	return view('service',compact('user','service'));
    }
}
