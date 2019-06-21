<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credit;
use Twilio\Rest\Client;

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
        date_default_timezone_set('Asia/Baku');
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
            'phone' => 'required',
            'last_payment_date' => 'required'
        ]);

        $credit = new Credit;
        $credit->name = $request->input('name');
        $credit->phone = $request->input('phone');
        $credit->last_payment_date = $request->input('last_payment_date');
        $credit->save();

        return redirect('credits')->with('success', 'Kredit uğurla əlavə edildi.');
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
            'phone' => 'required',
            'last_payment_date' => 'required'
        ]);

        $credit = Credit::find($id);
        $credit->name = $request->input('name');
        $credit->phone = $request->input('phone');
        $credit->last_payment_date = $request->input('last_payment_date');
        $credit->save();

        return redirect('credits')->with('success', 'Kredit uğurla redaktə edildi.');
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

        return redirect('credits')->with('success', 'Kredit uğurla silindi.');
    }

    // Search name on credits/index view
    public function search(Request $request)
    {
        $search_term = $request->input('search_term');
        $credits = Credit::where('name', 'like', '%' . $search_term . '%')
            ->orderBy('id', 'desc')
            ->paginate(50);

        foreach($credits as $credit)
        {
            echo '<tr><td>' . $credit->name . '</td><td>' .
                $credit->phone . '</td><td>' .
                $credit->last_payment_date . '</td><td>';
            if($credit->last_notified_at == '1970-01-01 00:00:00')
            {
                echo '-';
            }
            else
            {
                echo $credit->last_notified_at;
            }
            echo '</td><td><a href="/credits/' . $credit->id . '/edit" class="btn btn-warning">Redaktə Et</a></td></tr>';
        }
    }
}
