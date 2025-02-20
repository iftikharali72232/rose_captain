<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Passengers;
use App\Models\Subscription;
use Auth;
use Carbon\Carbon;
class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            // Retrieve all bookings with passengers
            $bookings = Booking::with('passengers')->get();

            return response()->json([
                'status' => 'success',
                'bookings' => $bookings
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch bookings!',
                'error' => $e->getMessage()
            ], 500);
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
       /*$user_id =Auth::id();
        $subscription = Subscription::where('user_id', $user_id)
            ->where('subscription_type','booking')
            ->whereDate('from_date', '<=', Carbon::today())
            ->whereDate('to_date', '>=', Carbon::today())
            ->first();

        if (!$subscription) {
            // Subscription not found, handle accordingly
            return response()->json(['message' => 'No active subscription found'], 404);
        }*/
        // Validate the request
        $validated = $request->validate([
            'from' => 'required|string',
            'to' => 'required|string',
            'passengers' => 'required|array|min:1',
            'passengers.*.id_number' => 'required|string',
            'passengers.*.name' => 'required|string',
            'passengers.*.nationality' => 'required|string',
            'passengers.*.mobile_number' => 'required|string'
        ]);

        // Start DB Transaction
        DB::beginTransaction();

        try {
            // Create Booking
            $booking = Booking::create([
                'from' => $validated['from'],
                'to' => $validated['to'],
                'passenger_qty' => count($validated['passengers']),
                'user_id' => Auth::id()
            ]);

            // Insert passengers
            foreach ($validated['passengers'] as $passenger) {
                Passengers::create([
                    'booking_id' => $booking->id,
                    'id_number' => $passenger['id_number'], // Fix id_number spelling
                    'name' => $passenger['name'],
                    'nationality' => $passenger['nationality'],
                    'mobile_number' => $passenger['mobile_number'],

                ]);
            }

            // Commit transaction
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Booking Created Successfully!',
                'booking' => $booking->load('passengers')
            ], 201); // HTTP 201 for resource creation

        } catch (\Exception $e) {
            // Rollback transaction in case of error
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Booking failed!',
                'error' => $e->getMessage()
            ], 500); // HTTP 500 for internal server error
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
