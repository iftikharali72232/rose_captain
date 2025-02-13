<?php
namespace App\Http\Controllers;

use App\Models\CarType;
use Illuminate\Http\Request;

class CarTypeController extends Controller
{
    public function index()
    {
        $carTypes = CarType::all();
        return view('car_types.index', compact('carTypes'));
    }

    public function create()
    {
        return view('car_types.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|unique:car_types|max:255','name_ar' => 'required']);

        CarType::create(['name' => $request->name, 'name_ar' => $request->name_ar]);

        return redirect()->route('car_types.index')->with('success', 'Car Type added successfully.');
    }

    public function edit($id)
    {
        $carType = CarType::findOrFail($id);
        return view('car_types.edit', compact('carType'));
    }

    public function update(Request $request, $id)
    {
        $carType = CarType::findOrFail($id);

        $request->validate(['name' => 'required|unique:car_types,name,' . $id . '|max:255']);

        $carType->update(['name' => $request->name]);

        return redirect()->route('car_types.index')->with('success', 'Car Type updated successfully.');
    }

    public function destroy($id)
    {
        CarType::findOrFail($id)->delete();
        return redirect()->route('car_types.index')->with('success', 'Car Type deleted successfully.');
    }
}
