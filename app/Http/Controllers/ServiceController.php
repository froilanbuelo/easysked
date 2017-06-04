<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceStoreRequest;
use App\Service;
use Auth;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class ServiceController extends Controller
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
    public function create(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('App\Forms\ServiceForm', [
            'method' => 'POST',
            'url' => route('service.store')
        ]);
        return view('service.create',compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceStoreRequest $request)
    {
        $service = Service::create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'url' => $request->get('url'),
            'duration' => $request->get('duration'),
            'buffer_before' => $request->get('buffer_before'),
            'buffer_after' => $request->get('buffer_after'),
            'limit' => $request->get('limit'),
            'user_id' => Auth::user()->id,
        ]);
        // Auth::user()->services()->save($service);
        return redirect()->action('ServiceController@show',$service->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = Service::with('owner')->findOrFail($id);
        return view('service.show',compact('service'));
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
