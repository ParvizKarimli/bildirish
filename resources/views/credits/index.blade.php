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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Last Payment Date</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($credits as $credit)
                    <tr>
                        <td>{{$credit->id}}</td>
                        <td>{{$credit->name}}</td>
                        <td>{{$credit->last_payment_date}}</td>
                        <td>{{$credit->created_at}}</td>
                        <td>{{$credit->updated_at}}</td>
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
