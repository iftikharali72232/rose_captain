<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Subscription;
use Carbon\Carbon;
class SubscritionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validated = $request->validate([

            'subscription_type' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after:from_date',
            'amount' => 'required|numeric|min:0'
        ]);

        $validated['user_id'] = Auth::id();
        $subscription = Subscription::create($validated);
        return response()->json(['message' => 'Subscription created', 'data' => $subscription], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = Auth::id();


        $subscription = Subscription::where('user_id', $user_id)
            ->where('subscription_type',$id)
            ->whereDate('from_date', '<=', Carbon::today())
            ->whereDate('to_date', '>=', Carbon::today())
            ->first();

        if (!$subscription) {

            return response()->json(['message' => 'No active subscription found'], 404);
        }


        return response()->json(['subscription' => $subscription]);
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
