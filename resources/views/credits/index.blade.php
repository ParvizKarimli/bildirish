@extends('layouts.app')

@section('content')
    <div class="row">
        <a href="/credits/create" class="btn btn-default">Kredit Əlavə Et</a>
        <h3>Kreditlər</h3>
        {!! Form::open(['action' => 'CreditsController@search', 'method' => 'GET']) !!}
            <div class="form-group">
                {{Form::text('search_term', '', ['class' => 'form-control', 'placeholder' => 'Ad axtar',
                'id' => 'search_term', 'onkeyup' => 'getCreditsBySearchTerm(this.value)'])}}
            </div>
        {!! Form::close() !!}
        <table class="table table-striped" id="credits_table">
            <thead>
                <tr>
                    <th>Ad</th>
                    <th>Telefon</th>
                    <th>Son Ödəniş Tarixi</th>
                    <th>Son Bildiriş Tarixi & Vaxtı</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($credits as $credit)
                    <tr>
                        <td>{{$credit->name}}</td>
                        <td>{{$credit->phone}}</td>
                        <td>{{$credit->last_payment_date}}</td>
                        <td>
                            @if($credit->last_notified_at == '1970-01-01 00:00:00')
                                -
                            @else
                                {{date('Y-m-d H:i:s', strtotime($credit->last_notified_at))}}
                            @endif
                        </td>
                        <td>
                            <a href="/credits/{{$credit->id}}/edit" class="btn btn-warning">Redaktə Et</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$credits->links()}}
    </div>
@endsection
