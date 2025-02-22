<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletHistory;
use Illuminate\Http\Request;
use Auth;
use App\Models\Subscription;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

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
                'subscription_id' => 'required|exists:subscriptions,id',
            ]);

           $data  =  Subscription::find($request->subscription_id);


            $subscription = Subscription::where('user_id',Auth::id())
                ->where('subscription_id',$data->id)
                ->whereDate('from_date', '<=', Carbon::today())
                ->whereDate('to_date', '>=', Carbon::today())
                ->first();

            if ($subscription):

                return response()->json(['error' => 'Subscription Already Exists', 'data' => 'false'], 500);

                endif;


            $user_data = Wallet::where('user_id',Auth::id())->first();
            if ($user_data->amount < $data->amount)
            {
                return response()->json(['error' => 'Insufficient amount'], 500);
            }

            $subscription = new Subscription();
            $subscription->user_id = Auth::id();
            $subscription->wallet_id = $request->wallet_id;





            $subscription->subscription_type = ($data->subscription_type == 'booking_plans') ? 'booking' : 'driver_card';

            if ($data->duration_type == 'monthly') {
                $from_date = now()->format('Y-m-d'); // Today
                $day = now()->format('d'); // Current day
                $to_date = now()->addMonth()->format('Y-m-') . min($day, now()->addMonth()->daysInMonth); // Next month

            } else {
                // Default values (Modify as needed)
                $from_date = now()->format('Y-m-d');
                $to_date = now()->addDays(30)->format('Y-m-d'); // Default 30 days
            }

            $subscription->from_date = $from_date;
            $subscription->to_date = $to_date;
            $subscription->amount = $data->amount;
            $subscription->subscription_id = $data->id;
            $subscription->save();



            $wallet = new Wallet();
            $wallet = $wallet->find($request->wallet_id);
            $wallet->amount -= $subscription->amount;
            $wallet->save();


            WalletHistory::create([
                'wallet_id' => $wallet->id,
                'amount' => $subscription->amount,
                'is_deposite' => 0,
                'description' => 'Subscription '.$subscription->subscription_type,
            ]);


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



        if ($id == 'booking'):
            $subscription = Subscription::where('user_id',Auth::id())
                ->where('subscription_type',$id)
                ->whereDate('from_date', '<=', Carbon::today())
                ->whereDate('to_date', '>=', Carbon::today())
                ->first();
          if ($subscription):
              $subscription = 1;
              return response()->json(['subscription' => $subscription]);
              else:
                  $subscription = 0;
                  return response()->json(['subscription' => $subscription]);
          endif;

            elseif ($id == 'driver_card'):
                $subscription = Subscription::where('user_id',Auth::id())
                    ->where('subscription_type',$id)
                    ->whereDate('from_date', '<=', Carbon::today())
                    ->whereDate('to_date', '>=', Carbon::today())
                    ->first();
                if ($subscription):
                    $subscription = 1;
                    return response()->json(['subscription' => $subscription]);
                else:
                    $subscription = 0;
                    return response()->json(['subscription' => $subscription]);
                endif;

        elseif ($id == 'all'):
            $subscription = Subscription::where('user_id',Auth::id())

                ->whereDate('from_date', '<=', Carbon::today())
                ->whereDate('to_date', '>=', Carbon::today())
                ->get();
            if ($subscription):

                return response()->json(['subscription' => $subscription]);
            else:
                $subscription = 0;
                return response()->json(['subscription' => $subscription]);
            endif;

         elseIf($id == 'booking_plans'):
             $subscription = Subscription::
                  where('subscription_type','booking_plans')
                  ->where('user_id',0)
                 ->select('id','subscription_type','amount','duration_type')
                 ->get();

        elseIf($id == 'driver_card_plans'):
            $subscription = Subscription::
            where('subscription_type','driver_card_plans')
                ->where('user_id',0)
                ->select('id','subscription_type','amount','duration_type')
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
