<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\User;
use App\Models\WalletHistory;
use Auth;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {

            $wallet = Wallet::where('user_id',Auth::id())->first();

            $history = WalletHistory::where('wallet_id', $wallet->id)->orderBy('created_at', 'desc')->get();

            return response()->json([
                'wallet' => $wallet,
                'history' => $history,
            ], 200);
        } catch (Exception $e) {
            Log::error('Wallet Fetch Error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong', 'details' => $e->getMessage()], 500);
        }
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

        $lang = $request->input('lang', 'en'); // Default language is English

        $messages = [
            'amount.required' => $lang === 'ar' ? 'المبلغ مطلوب' : 'Amount is required',
            'amount.numeric' => $lang === 'ar' ? 'يجب أن يكون المبلغ رقمًا' : 'Amount must be a numeric value',

            'description.required' => $lang === 'ar' ? 'الوصف مطلوب' : 'Description is required',
            'description.string' => $lang === 'ar' ? 'يجب أن يكون الوصف نصًا' : 'Description must be a string',
        ];

        if ($request->has('transfer')):
        $user_data_another = User::where('mobile',$request->mobile_no)->first();
        if (!$user_data_another):
            return response()->json([
                'error' => $lang === 'ar' ? 'المستخدم غير موجود' : 'User not found'
            ], 500);
        endif;
     endif;


        try {
            $validated = $request->validate([
                'amount' => 'required|numeric',
                'description' => 'required|string',
            ],$messages);
            $user_id = AUth::id();

            $id = 0;
            $user_data = Wallet::where('user_id',$user_id)->first();

            $user_info = User::find(Auth::id());

            if ($user_data):
                $id = $user_data->id;
                endif;
            $wallet =  new Wallet();
            if ($id != 0):
            $wallet = Wallet::findOrFail($id);
            endif;

            $wallet->user_id = Auth::id();
            $deposit = 1;
            if ($request->has('transfer'))
            {


                if ($user_data->amount < $request->amount)
                {
                    return response()->json([
                        'error' => $lang === 'ar' ? 'المبلغ غير كافٍ' : 'Insufficient amount'
                    ], 500);
                }
                else
                {

                    $wallet->amount -= $request->amount;

                    $deposit = 0;
                }
            }
            else
            {
                $wallet->amount += $request->amount;
            }

            $wallet->save();

            // Save transaction history
            WalletHistory::create([
                'wallet_id' => $wallet->id,
                'amount' => $request->amount,
                'is_deposite' => 1,
                'description' => $request->description,
            ]);


            if ($request->has('transfer')):
                $user_data = Wallet::where('user_id',$user_data_another->id)->first();
                $id = 0;
                if ($user_data):
                    $id = $user_data->id;
                endif;

                $wallet =  new Wallet();
                if ($id != 0):
                    $wallet = Wallet::findOrFail($id);
                endif;

                $wallet->user_id = $user_data_another->id;
                $deposit = 1;
                $wallet->amount += $request->amount;
                $wallet->save();


                WalletHistory::create([
                    'wallet_id' => $wallet->id,
                    'amount' => $request->amount,
                    'is_deposite' => 1,
                    'description' => "Transferd From ".$user_info->name,
                ]);
                return response()->json([
                    'message' => $lang === 'ar' ? 'تم تحويل المبلغ بنجاح' : 'Amount transferred successfully',
                    'wallet' => $wallet,
                ], 200);
            endif;


            return response()->json([
                'message' => $lang === 'ar' ? 'تم تحديث المحفظة بنجاح' : 'Wallet updated successfully',
                'wallet' => $wallet,
            ], 200);
        } catch (Exception $e) {
            Log::error('Wallet API Error: ' . $e->getMessage());
            return response()->json(['error' => 'Something went wrong'], 500);
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
        //
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
