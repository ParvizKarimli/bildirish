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
                $credit->last_payment_date . '</td><td>' .
                $credit->last_notified_at . '</td>' .
                '<td><a href="/credits/' . $credit->id . '/edit" class="btn btn-warning">Redaktə Et</a></td></tr>';
        }
    }

    // Notification sender method
    public function notify()
    {
        $credits = Credit::all();
        foreach($credits as $credit)
        {
            /* Check when the last payment was and when the last notification was.
               If their differences from now are greater than specified number of days,
               then send notification to related people, and change the last notification date & time to now
            */
            if((strtotime(date('Y-m-d')) - strtotime($credit->last_payment_date))/86400 >= 1 &&
            (strtotime(date('Y-m-d H:i:s')) - strtotime($credit->last_notified_at))/86400 >= 1)
            {
                $to = 'devparviz@gmail.com';
                $subject = 'Bildirish Notification';
                $message = 'This is a notification to ' . $credit->phone . '/' . $credit->name;
                $headers = "From:Bildirish<noreply@example.com>";

                if(mail($to, $subject, $message, $headers))
                {
                    $credit->last_notified_at = date('Y-m-d H:i:s');
                    $credit->save();
                    echo 'Notification sent to ' . $credit->phone . '/' . $credit->name . '<br>';
                }
            }
        }
    }
}
