<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Subscription;
use Carbon\Carbon;
use Exception;
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
        try {
            $validated = $request->validate([
                'subscription_type' => 'required',
                'from_date' => 'required|date',
                'to_date' => 'required|date|after:from_date',
                'amount' => 'required|numeric|min:0'
            ]);

            $validated['user_id'] = Auth::id();
            $subscription = Subscription::create($validated);

            return response()->json(['message' => 'Subscription created', 'data' => $subscription], 201);

        } catch (Exception $e) {
            Log::error('Subscription API Error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
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



        if ($id == 'all'):
            $subscription = Subscription::where('user_id',Auth::id())

                ->whereDate('from_date', '<=', Carbon::today())
                ->whereDate('to_date', '>=', Carbon::today())
                ->get();
         elseIf($id == 'booking_plans'):
             $subscription = Subscription::
                  where('subscription_type','booking_plans')
                  ->where('user_id',0)
                 ->select('subscription_type','amount','duration_type')
                 ->get();

        elseIf($id == 'driver_card_plans'):
            $subscription = Subscription::
            where('subscription_type','driver_card_plans')
                ->where('user_id',0)
                ->select('subscription_type','amount','duration_type')
                ->get();
        else:
            $subscription = Subscription::
            where('subscription_type',$id)
          /*      ->whereDate('from_date', '<=', Carbon::today())
                ->whereDate('to_date', '>=', Carbon::today())*/
                ->get();

        endif;

        if (!$subscription) {

            return response()->json(['message' => 'No active subscription found',
                'data'=>false], 404);
        }


        return response()->json(['subscription' => $subscription]);
    }

    public function detaild()
    {
        dd('sa');
        $user_id = Auth::id();


        $subscription = Subscription::where('user_id',$id)
        ->where('subscription_type',$id)
            ->whereDate('from_date', '<=', Carbon::today())
            ->whereDate('to_date', '>=', Carbon::today())
            ->get();

        if (!$subscription) {

            return response()->json(['message' => 'No active subscription found',
                'data'=>false], 404);
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
