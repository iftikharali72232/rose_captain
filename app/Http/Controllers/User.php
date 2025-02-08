<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;

class User extends Controller
{
    // List all users
    public function index()
    {
        $users = ModelsUser::all();
        return view('users.index', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        return view('users.create');
    }
    
    public function updateStatus($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->status = $driver->status ? 0 : 1; // Toggle status between 0 and 1
        $driver->save();

        return redirect()->back()->with('success', 'Driver status updated successfully.');
    }

    // Store a newly created user in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'status' => 'required',
            'user_type' => 'required',
        ]);

        ModelsUser::create($request->all());

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Show the form for editing the specified user
    public function edit(ModelsUser $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update the specified user in the database
    public function update(Request $request, ModelsUser $user)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'status' => 'required',
            'user_type' => 'required',
        ]);

        $data = $request->except('password'); // Exclude password by default

        // Update password only if a new one is provided
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified user from the database
    public function destroy(ModelsUser $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
