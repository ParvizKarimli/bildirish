@extends('layouts.app')

@section('content')
    <div class="row">
        <a href="/credits/create" class="btn btn-default">Add Credit</a>
        <h3>Credits</h3>
        {!! Form::open(['action' => 'CreditsController@search', 'method' => 'GET']) !!}
            <div class="form-group">
                {{Form::text('search_term', '', ['class' => 'form-control', 'placeholder' => 'Search name',
                'id' => 'search_term', 'onkeyup' => 'getCreditsBySearchTerm(this.value)'])}}
            </div>
        {!! Form::close() !!}
        <table class="table table-striped" id="credits_table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Last Payment Date</th>
                    <th>Last Notified At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($credits as $credit)
                    <tr>
                        <td>{{$credit->name}}</td>
                        <td>{{$credit->phone}}</td>
                        <td>{{$credit->last_payment_date}}</td>
                        <td>{{$credit->last_notified_at}}</td>
                        <td>
                            <a href="/credits/{{$credit->id}}/edit" class="btn btn-warning">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$credits->links()}}
    </div>
@endsection
