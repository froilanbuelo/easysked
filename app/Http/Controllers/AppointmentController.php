<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Client;
use App\Http\Requests\NewAppointmentStoreRequest;
use App\Service;
use App\User;
use Carbon\Carbon;
use Auth;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,FormBuilder $formBuilder)
    {
        // dd($request);
        $p_service = $request->get('service_id');
        $p_date = $request->get('date');
        $p_time = $request->get('time');
        $service = Service::with('owner')->find($p_service);        
        $start = Carbon::parse($p_date.' '.$p_time);
        if (!$service->isAvailableOnDateTime($start->toDateString(),$start->format('g:i a'))){
            return view('errors.service_not_available', compact('service'));
        }
        $end = $start->copy()->addMinutes($service->duration);
        if (!$service){
            abort(403);
        }
        $data = array();
        $data['service_id'] = $p_service;
        $data['start'] = $start->toDateTimeString();
        if (Auth::check()){
            $data['user_id'] = Auth::user()->id;
            $data['name'] = Auth::user()->name;
            $data['email'] = Auth::user()->email;
        }
        $form = $formBuilder->create('App\Forms\AppointmentNewForm', [
            'method' => 'POST',
            'url' => route('new_appointment_save')
        ],$data);

        return view('reservation.create',compact('service','p_date','p_time','start','end','form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewAppointmentStoreRequest $request)
    {
        $service = Service::with('owner')->findOrFail($request->get('service_id'));
        $start = Carbon::parse($request->get('start'));
        if (!$service->isAvailableOnDateTime($start->toDateString(),$start->format('g:i a'))){
            return view('errors.service_not_available', compact('service'));
        }
        $appointment = Appointment::firstOrCreate([
            'service_id' => $request->get('service_id'),
            'start' => $request->get('start'),
            'end' => Carbon::parse($request->get('start'))->addMinutes($service->duration)->toDateTimeString(),
        ]);
        if ($appointment->available_slots > 0){
            $appointment->available_slots -= 1;
        }
        $appointment->save();
        $client = new Client;
        $client->name = $request->get('name');
        $client->email = $request->get('email');
        if ($request->has('note')){
            $client->note = $request->get('note');
        }
        if ($request->has('user_id')){
            $client->user_id = $request->get('user_id');
        }
        $client->appointment_id = $appointment->id;
        $client->save();

        // $appointment->clients()->save($client);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
