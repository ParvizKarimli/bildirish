@extends('layouts.app')

@section('content')
    <div class="row">
        <h1>Edit Credit</h1>
        {!! Form::open(['action' => ['CreditsController@update', $credit->id], 'method' => 'PUT']) !!}
            <div class="form-group">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', $credit->name, ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group">
                {{Form::label('duration_months', 'Duration (months)')}}
                {{Form::number('duration_months', $credit->duration_months, ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group">
                {{Form::label('initial_amount', 'Initial Amount')}}
                {{Form::number('initial_amount', $credit->initial_amount, ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group">
                {{Form::label('paid_amount', 'Paid Amount')}}
                {{Form::number('paid_amount', $credit->paid_amount, ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group">
                {{Form::label('issuer', 'Issuer')}}
                {{Form::text('issuer', $credit->issuer, ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group">
                {{Form::label('date', 'Date')}}
                {{Form::date('date', $credit->date, ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group">
                {{Form::label('location', 'Location')}}
                {{Form::text('location', $credit->location, ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group">
                {{Form::label('phone', 'Phone')}}
                {{Form::text('phone', $credit->phone, ['class' => 'form-control', 'required'])}}
            </div>
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection
