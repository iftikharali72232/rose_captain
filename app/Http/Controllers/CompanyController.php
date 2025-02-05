<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // List all companies
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    // Show the form for creating a new company
    public function create()
    {
        return view('companies.create');
    }

    // Store a newly created company in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required',
        ]);

        $data = $request->all();

        // Handle image upload using move()
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Unique filename
            $destinationPath = public_path('company_images'); // Storage path in public folder

            // Move the file to the destination path
            $image->move($destinationPath, $imageName);

            // Save the image path in the database
            $data['image'] = 'company_images/' . $imageName;
        }

        Company::create($data);

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }


    // Show the form for editing the specified company
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    // Update the specified company in the database
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required',
        ]);

        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Unique filename
            $destinationPath = public_path('company_images'); // Storage path in public folder

            // Move the file to the destination path
            $image->move($destinationPath, $imageName);

            // Save the image path in the database
            $data['image'] = 'company_images/' . $imageName;
        }

        $company->update($data);

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    // Remove the specified company from the database
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }
}
