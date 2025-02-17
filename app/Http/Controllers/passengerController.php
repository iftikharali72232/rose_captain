<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Passengers;
use App\Models\Booking;
use Illuminate\Http\Request;

class passengerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    //    $bookings = Booking::withCount('passengers')->get();
        $bookings = Booking::with('user') // Load user details
            ->leftJoin('passengers', 'bookings.id', '=', 'passengers.booking_id')
            ->select('bookings.user_id')
            ->selectRaw('COUNT(bookings.id) as total_bookings, COUNT(passengers.id) as total_passengers')
            ->groupBy('bookings.user_id')
            ->get();


        return view('passenger.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $passenger = Passengers::join('bookings','bookings.id','=','passengers.booking_id')
       ->where('bookings.user_id',$id)->get();


        return view('passenger.index', compact('passenger'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
