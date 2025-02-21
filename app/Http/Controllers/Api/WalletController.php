<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\User;
use App\Models\WalletHistory;
use Auth;
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
        try {
            $validated = $request->validate([
                'amount' => 'required|numeric',
                'description' => 'required|string',
            ]);
            $user_id = AUth::id();

            $id = 0;
            $user_data = Wallet::where('user_id',$user_id)->first();

            if ($user_data):
                $id = $user_data->id;
                endif;
            $wallet =  new Wallet();
            if ($id != 0):
            $wallet = Wallet::findOrFail($id);
            endif;

            $wallet->user_id = Auth::id();
            $wallet->amount += $request->amount;
            $wallet->save();

            // Save transaction history
            WalletHistory::create([
                'wallet_id' => $wallet->id,
                'amount' => $request->amount,
                'description' => $request->description,
            ]);

            return response()->json([
                'message' => 'Wallet updated successfully',
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
