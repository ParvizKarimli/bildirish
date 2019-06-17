@extends('layouts.app')

@section('content')
    <div class="row">
        <h1>Kredit Əlavə Et</h1>
        {!! Form::open(['action' => 'CreditsController@store', 'method' => 'POST']) !!}
            <div class="form-group">
                {{Form::label('name', 'Ad')}}
                {{Form::text('name', '', ['class' => 'form-control', 'required'])}}
            </div>
        <div class="form-group">
            {{Form::label('phone', 'Telefon')}}
            {{Form::text('phone', '', ['class' => 'form-control', 'required'])}}
        </div>
            <div class="form-group">
                {{Form::label('last_payment_date', 'Son Ödəniş Tarixi')}}
                {{Form::date('last_payment_date', '', ['class' => 'form-control', 'required'])}}
            </div>
            {{Form::submit('Təsdiqlə', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection
