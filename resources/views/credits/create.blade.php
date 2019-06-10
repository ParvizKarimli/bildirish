@extends('layouts.app')

@section('content')
    <div class="row">
        <h1>Add Credit</h1>
        {!! Form::open(['action' => 'CreditsController@store', 'method' => 'POST']) !!}
            <div class="form-group">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('duration_months', 'Duration (months)')}}
                {{Form::number('duration_months', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('initial_amount', 'Initial Amount')}}
                {{Form::number('initial_amount', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('paid_amount', 'Paid Amount')}}
                {{Form::number('paid_amount', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('issuer', 'Issuer')}}
                {{Form::text('issuer', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('date', 'Date')}}
                {{Form::date('date', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('location', 'Location')}}
                {{Form::text('location', '', ['class' => 'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::label('phone', 'Phone')}}
                {{Form::text('phone', '', ['class' => 'form-control'])}}
            </div>
            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
        {!! Form::close() !!}
    </div>
@endsection
