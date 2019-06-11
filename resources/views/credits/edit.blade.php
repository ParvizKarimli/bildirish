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
                {{Form::label('last_payment_date', 'Last Payment Date')}}
                {{Form::date('last_payment_date', $credit->last_payment_date, ['class' => 'form-control', 'required'])}}
            </div>
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
        <hr>
        <a class="btn btn-danger" href="" onclick="
            event.preventDefault();
            if(confirm('Delete credit?')) {
                document.getElementById('credit-{{$credit->id}}').submit();
            }
        ">
            Delete Credit (!)
        </a>
        {!! Form::open(['action' => ['CreditsController@destroy', $credit->id],
        'method' => 'DELETE', 'id' => 'credit-' . $credit->id]) !!}
        {!! Form::close() !!}
    </div>
@endsection
