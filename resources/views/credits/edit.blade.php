@extends('layouts.app')

@section('content')
    <div class="row">
        <h1>Krediti Redaktə Et</h1>
        {!! Form::open(['action' => ['CreditsController@update', $credit->id], 'method' => 'PUT']) !!}
            <div class="form-group">
                {{Form::label('name', 'Ad')}}
                {{Form::text('name', $credit->name, ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group">
                {{Form::label('phone', 'Telefon')}}
                {{Form::text('phone', $credit->phone, ['class' => 'form-control', 'required'])}}
            </div>
            <div class="form-group">
                {{Form::label('last_payment_date', 'Son Ödəniş Tarixi')}}
                {{Form::date('last_payment_date', $credit->last_payment_date, ['class' => 'form-control', 'required'])}}
            </div>
            {{Form::submit('Təsdiqlə', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
        <hr>
        <a class="btn btn-danger" href="" onclick="
            event.preventDefault();
            if(confirm('Krediti silmək?')) {
                document.getElementById('credit-{{$credit->id}}').submit();
            }
        ">
            Krediti Sil
        </a>
        {!! Form::open(['action' => ['CreditsController@destroy', $credit->id],
        'method' => 'DELETE', 'id' => 'credit-' . $credit->id]) !!}
        {!! Form::close() !!}
    </div>
@endsection
