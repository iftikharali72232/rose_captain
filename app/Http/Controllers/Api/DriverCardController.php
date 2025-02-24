<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DriverCard;
use Auth;
class DriverCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = DriverCard::where('user_id',Auth::id())->get();
        return response()->json(['status' => 'success', 'drivers' => $drivers]);
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
            'name.required' => $lang === 'ar' ? 'الاسم مطلوب' : 'Name is required',
            'name.string' => $lang === 'ar' ? 'يجب أن يكون الاسم نصًا' : 'Name must be a string',

            'id_number.required' => $lang === 'ar' ? 'رقم الهوية مطلوب' : 'ID number is required',
            'id_number.string' => $lang === 'ar' ? 'يجب أن يكون رقم الهوية نصًا' : 'ID number must be a string',
            'id_number.unique' => $lang === 'ar' ? 'رقم الهوية مستخدم بالفعل' : 'ID number already exists',

            'mobile.required' => $lang === 'ar' ? 'رقم الهاتف مطلوب' : 'Mobile number is required',
            'mobile.string' => $lang === 'ar' ? 'يجب أن يكون رقم الهاتف نصًا' : 'Mobile number must be a string',

            'image.required' => $lang === 'ar' ? 'الصورة مطلوبة' : 'Image is required',
            'image.image' => $lang === 'ar' ? 'يجب أن يكون الملف صورة' : 'The file must be an image',
            'image.mimes' => $lang === 'ar' ? 'يجب أن تكون الصورة بصيغة: jpeg, png, jpg, gif, webp' : 'The image must be a file of type: jpeg, png, jpg, gif, webp',
            'image.max' => $lang === 'ar' ? 'يجب ألا يزيد حجم الصورة عن 2 ميغابايت' : 'The image must not be greater than 2MB',
        ];

        $validated = $request->validate([
            'name' => 'required|string',
            'id_number' => 'required|string|unique:drivers,id_number',
            'mobile' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ],$messages);

        if (DriverCard::where('user_id', Auth::id())->exists())
        {
            return response()->json(['status' => 'error', 'message' => 'You are already registered.'], 400);
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('driversCard', 'public');
            $validated['image'] = $imagePath;
        }

        $driver = DriverCard::create([
            'user_id' => Auth::id(), // Logged-in user ID
            'name' => $validated['name'],
            'id_number' => $validated['id_number'],
            'mobile' => $validated['mobile'],
            'image' => $imagePath
        ]);

        return response()->json(['status' => 'success', 'driver' => $driver], 201);
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
