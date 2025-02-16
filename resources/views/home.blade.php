@extends('layouts.app')

@section('content')


<!-- Driver and Vehicle Information Form  -->
<style>
    .card {
        transition: 0.3s ease-in-out;
        border-radius: 10px;
        position: relative;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .stretched-link {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
</style>

<<div class="container mt-4">
    <div class="row g-4">
        <!-- User Box -->
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 p-3 text-center">
                <div class="card-body">
                    <i class="bi bi-people fs-1 text-primary"></i>
                    <h5 class="mt-2">{{ trans('lang.users') }}</h5>
                    <p class="fs-4 fw-bold">{{ $usersCount }}</p>
                    <a target="_blank" href="{{ route('drivers.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Vehicle Box -->
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 p-3 text-center">
                <div class="card-body">
                    <i class="bi bi-car-front fs-1 text-success"></i>
                    <h5 class="mt-2">{{ trans('lang.vehicles') }}</h5>
                    <p class="fs-4 fw-bold">{{ $vehiclesCount }}</p>
                    <a target="_blank" href="{{ route('drivers.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Company Box -->
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 p-3 text-center">
                <div class="card-body">
                    <i class="bi bi-building fs-1 text-warning"></i>
                    <h5 class="mt-2">{{ trans('lang.companies') }}</h5>
                    <p class="fs-4 fw-bold">{{ $companiesCount }}</p>
                    <a target="_blank" href="{{ route('companies.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <!-- Passenger Box -->
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 p-3 text-center">
                <div class="card-body">
                    <i class="bi bi-person-check fs-1 text-danger"></i>
                    <h5 class="mt-2">{{ trans('lang.passengers') }}</h5>
                    <p class="fs-4 fw-bold">{{ $passengersCount }}</p>
                    <a href="{{ route('passenger.index') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
</div>
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


