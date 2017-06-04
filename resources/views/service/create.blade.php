@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Setup a New Service</h3></div>

                <div class="panel-body">
                    {!! form_start($form) !!}
                    <div class="row">
                        <div class="col-md-12">
                            {!! form_row($form->name)!!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {!! form_row($form->description)!!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {!! form_row($form->url)!!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            {!! form_row($form->duration)!!}
                        </div>
                        <div class="col-md-4">
                            {!! form_row($form->buffer_before)!!}
                        </div>
                        <div class="col-md-4">
                            {!! form_row($form->buffer_after)!!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            {!! form_row($form->limit)!!}
                        </div>
                    </div>
                        {!! form_rest($form)!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
