<?php

namespace App\Http\Controllers;

use App\Googl;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function calendar(Googl $googl, Request $request){
        $client = $googl->client();
        if ($request->has('code')) {
        }else{
            $auth_url = $client->createAuthUrl();
            return redirect($auth_url);
        }
    }
}
