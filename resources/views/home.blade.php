@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6">Driver and Vehicle Information</h1>
        <form action="{{ route('form.store') }}" method="POST">
            @csrf
            <!-- User Fields -->
            <div class="mb-4">
                <label class="block text-gray-700">Driver Name</label>
                <input type="text" name="name" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">ID Number</label>
                <input type="text" name="id_number" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Mobile Number</label>
                <input type="text" name="mobile" class="w-full p-2 border rounded" required>
            </div>

            <!-- Vehicle Fields -->
            <div class="mb-4">
                <label class="block text-gray-700">Car Type</label>
                <input type="text" name="car_type" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Number of Passengers</label>
                <input type="number" name="number_of_passengers" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Car Model</label>
                <input type="text" name="car_model" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Car Color</label>
                <input type="text" name="car_color" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Licence Plate Number</label>
                <input type="text" name="licence_plate_number" class="w-full p-2 border rounded" required>
            </div>

            <!-- Company Fields -->
            <div class="mb-4">
                <label class="block text-gray-700">Company Name</label>
                <input type="text" name="company_name" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Company Registration Number</label>
                <input type="text" name="company_registration_number" class="w-full p-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Company Type</label>
                <input type="text" name="company_type" class="w-full p-2 border rounded" required>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
        </form>
    </div>
@endsection


