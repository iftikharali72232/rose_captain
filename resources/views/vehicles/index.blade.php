@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-4 rounded-2 shadow-sm">
    <h2 class="fw-bold mb-6">{{ trans('lang.vehicles_list') }}</h2>
    <hr>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('lang.owner') }}</th>
                    <th>{{ trans('lang.car_type') }}</th>
                    <th>{{ trans('lang.model') }}</th>
                    <th>{{ trans('lang.color') }}</th>
                    <th>{{ trans('lang.license_plate') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vehicles as $index => $vehicle)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $vehicle->user->name ?? trans('lang.na') }}</td>
                    <td>{{ $vehicle->car_type }}</td>
                    <td>{{ $vehicle->car_model }}</td>
                    <td>{{ $vehicle->car_color }}</td>
                    <td>{{ $vehicle->licence_plate_number }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
