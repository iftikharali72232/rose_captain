@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-4 rounded-2 shadow-sm">
    <h2 class="fw-bold mb-6">{{ trans('lang.driver_vehicle_info') }}</h2>
    <hr>
    <form action="{{ route('form.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            <!-- Driver Information -->
            <div class="col-md-6">
                <label class="form-label">{{ trans('lang.driver_name') }}</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ trans('lang.id_number') }}</label>
                <input type="text" name="id_number" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ trans('lang.mobile_number') }}</label>
                <input type="text" name="mobile" class="form-control" required>
            </div>

            <!-- Vehicle Information -->
            <div class="col-md-6">
                <label class="form-label">{{ trans('lang.car_type') }}</label>
                <input type="text" name="car_type" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ trans('lang.num_passengers') }}</label>
                <input type="number" name="number_of_passengers" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ trans('lang.car_model') }}</label>
                <input type="text" name="car_model" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ trans('lang.car_color') }}</label>
                <input type="text" name="car_color" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ trans('lang.licence_plate') }}</label>
                <input type="text" name="licence_plate_number" class="form-control" required>
            </div>

            <!-- Company Information -->
            <div class="col-md-6">
                <label class="form-label">{{ trans('lang.company_name') }}</label>
                <input type="text" name="company_name" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ trans('lang.company_reg_num') }}</label>
                <input type="text" name="company_registration_number" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">{{ trans('lang.company_type') }}</label>
                <input type="text" name="company_type" class="form-control" required>
            </div>

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary px-4 py-2 rounded">{{ trans('lang.submit') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection
