@extends('layouts.app')

@section('content')
    <div class="row">
        <h1>Add Credit</h1>
        {!! Form::open(['action' => 'CreditsController@store', 'method' => 'POST']) !!}
            <div class="form-group">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', '', ['class' => 'form-control', 'required'])}}
            </div>
        <div class="form-group">
            {{Form::label('phone', 'Phone')}}
            {{Form::text('phone', '', ['class' => 'form-control', 'required'])}}
        </div>
            <div class="form-group">
                {{Form::label('last_payment_date', 'Last Payment Date')}}
                {{Form::date('last_payment_date', '', ['class' => 'form-control', 'required'])}}
            </div>
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection
