@extends('layouts.app')

@section('content')


<!-- Driver and Vehicle Information Form  -->
<div class="d-none max-w-2xl mx-auto bg-white p-4 rounded-2 shadow-sm">
        <h2 class="fw-bold mb-6">Driver and Vehicle Information</h2>
        <hr>
        <form action="{{ route('form.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <!-- User Fields -->
                <div class="col-md-6">
                    <label class="block text-gray-700">Driver Name</label>
                    <div class="">
                        <input type="text" name="name" class="w-100 bg-gray p-2 border rounded" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label class="block text-gray-700">ID Number</label>
                    <div class="">
                        <input type="text" name="id_number" class="w-100 bg-gray p-2 border rounded" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label class="block text-gray-700">Mobile Number</label>
                    <div class="">
                        <input type="text" name="mobile" class="w-100 bg-gray p-2 border rounded" required>
                    </div>
                </div>

                <!-- Vehicle Fields -->
                <div class="col-md-6">
                    <label class="block text-gray-700">Car Type</label>
                    <div class="">
                        <input type="text" name="car_type" class="w-100 bg-gray p-2 border rounded" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="block text-gray-700">Number of Passengers</label>
                    <div class="">
                        <input type="number" name="number_of_passengers" class="w-100 bg-gray p-2 border rounded" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="block text-gray-700">Car Model</label>
                    <div class="">
                        <input type="text" name="car_model" class="w-100 bg-gray p-2 border rounded" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="block text-gray-700">Car Color</label>
                    <div class="">
                        <input type="text" name="car_color" class="w-100 bg-gray p-2 border rounded" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="block text-gray-700">Licence Plate Number</label>
                    <div class="">
                        <input type="text" name="licence_plate_number" class="w-100 bg-gray p-2 border rounded" required>
                    </div>
                </div>

                <!-- Company Fields -->
                <div class="col-md-6">
                    <label class="block text-gray-700">Company Name</label>
                    <div class="">
                        <input type="text" name="company_name" class="w-100 bg-gray p-2 border rounded" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="block text-gray-700">Company Registration Number</label>
                    <div class="">
                        <input type="text" name="company_registration_number" class="w-100 bg-gray p-2 border rounded" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="block text-gray-700">Company Type</label>
                    <div class="">
                        <input type="text" name="company_type" class="w-100 bg-gray p-2 border rounded" required>
                    </div>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="custom-btn px-4 py-2 rounded">Submit</button>
                </div>
            </div>
        </form>
</div>
@endsection


