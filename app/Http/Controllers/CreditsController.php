<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credit;

class CreditsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $credits = Credit::orderBy('id', 'desc')->paginate(50);
        return view('credits.index')->with('credits', $credits);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('credits.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'duration_months' => 'required',
            'initial_amount' => 'required',
            'paid_amount' => 'required',
            'issuer' => 'required',
            'date' => 'required',
            'location' => 'required',
            'phone' => 'required'
        ]);

        $credit = new Credit;
        $credit->name = $request->input('name');
        $credit->duration_months = $request->input('duration_months');
        $credit->initial_amount = $request->input('initial_amount');
        $credit->paid_amount = $request->input('paid_amount');
        $credit->remained_amount = $credit->initial_amount - $credit->paid_amount;
        $credit->issuer = $request->input('issuer');
        $credit->date = date('Y-m-d', strtotime($request->input('date')));
        $credit->location = $request->input('location');
        $credit->phone = $request->input('phone');
        $credit->status = 0;
        $credit->save();

        return redirect('credits')->with('success', 'Credit Added');
    }

    // Empty show method to prevent error
    public function show()
    {}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $credit = Credit::find($id);
        return view('credits.edit')->with('credit', $credit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'duration_months' => 'required',
            'initial_amount' => 'required',
            'paid_amount' => 'required',
            'issuer' => 'required',
            'date' => 'required',
            'location' => 'required',
            'phone' => 'required'
        ]);

        $credit = Credit::find($id);
        $credit->name = $request->input('name');
        $credit->duration_months = $request->input('duration_months');
        $credit->initial_amount = $request->input('initial_amount');
        $credit->paid_amount = $request->input('paid_amount');
        $credit->remained_amount = $credit->initial_amount - $credit->paid_amount;
        $credit->issuer = $request->input('issuer');
        $credit->date = date('Y-m-d', strtotime($request->input('date')));
        $credit->location = $request->input('location');
        $credit->phone = $request->input('phone');
        $credit->status = 0;
        $credit->save();

        return redirect('credits')->with('success', 'Credit Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $credit = Credit::find($id);
        $credit->delete();

        return redirect('credits')->with('success', 'Credit Removed');
    }

    // Search name for credits/index view
    public function search(Request $request)
    {
        $search_term = $request->input('search_term');
        $credits = Credit::where('name', 'like', '%' . $search_term . '%')
            ->orderBy('id', 'desc')
            ->paginate(50);

        foreach($credits as $credit)
        {
            echo '
                <tr><td>' . $credit->id . '</td><td>' .
                $credit->name . '</td><td>' .
                $credit->duration_months . '</td><td>' .
                $credit->initial_amount . '</td><td>' .
                $credit->paid_amount . '</td><td>' .
                $credit->remained_amount . '</td><td>' .
                $credit->issuer . '</td><td>' .
                $credit->date . '</td><td>' .
                $credit->location . '</td><td>' .
                $credit->phone . '</td><td>' .
                $credit->status . '</td><td>' .
                $credit->created_at . '</td><td>' .
                $credit->updated_at . '</td><td>' .
                '<a href="/credits/' . $credit->id . '/edit" class="btn btn-warning">Edit</a></td><td>' .
                '<a class="btn btn-danger" href="" onclick="event.preventDefault();
                    if(confirm(\'Delete credit?\')) {
                        document.getElementById(\'credit-' . $credit->id . '\').submit();
                    }
                ">Delete</a></td>' .
                '<form accept-charset="UTF-8" method="POST" class="pull-right" action="/credits/' . $credit->id .
                '" id="credit-' . $credit->id . '">' .
                '<input name="_method" type="hidden" value="DELETE">' .
                csrf_field() .
                '</form></tr>';
        }
    }
}
