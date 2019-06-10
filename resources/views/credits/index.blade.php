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
        <table class="table table-striped table-dark" id="credits_table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Duration (months)</th>
                    <th>Initial Amount</th>
                    <th>Paid Amount</th>
                    <th>Remained Amount</th>
                    <th>Issuer</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($credits as $credit)
                    <tr>
                        <td>{{$credit->id}}</td>
                        <td>{{$credit->name}}</td>
                        <td>{{$credit->duration_months}}</td>
                        <td>{{$credit->initial_amount}}</td>
                        <td>{{$credit->paid_amount}}</td>
                        <td>{{$credit->remained_amount}}</td>
                        <td>{{$credit->issuer}}</td>
                        <td>{{$credit->date}}</td>
                        <td>{{$credit->location}}</td>
                        <td>{{$credit->phone}}</td>
                        <td>{{$credit->status}}</td>
                        <td>{{$credit->created_at}}</td>
                        <td>{{$credit->updated_at}}</td>
                        <td>
                            <a href="/credits/{{$credit->id}}/edit" class="btn btn-warning">Edit</a>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="" onclick="
                                event.preventDefault();
                                if(confirm('Delete credit?')) {
                                    document.getElementById('credit-<?= $credit->id ?>').submit();
                                }
                            ">
                                Delete
                            </a>
                            {!! Form::open(['action' => ['CreditsController@destroy', $credit->id],
                            'method' => 'DELETE', 'class' => 'pull-right', 'id' => 'credit-' . $credit->id]) !!}
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$credits->links()}}
    </div>
@endsection
