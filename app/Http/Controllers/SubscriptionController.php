<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    public function index()
    {

       $subscription =  Subscription::with('user')->where('user_id','!=',0)->get();

       return view('subscription.index',compact('subscription'));
    }
}
