@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-4 rounded-lg shadow-sm">
        <h2 class="fw-bold mb-4">{{ trans('lang.vehicle_details') }}</h2>
        <hr>

        <table class="table table-striped mt-3">
            <tbody>
                <tr>
                    <th>{{ trans('lang.car_type') }}</th>
                    <td>{{ $vehicle->car_type ?? trans('lang.not_available') }}</td>
                </tr>
                <tr>
                    <th>{{ trans('lang.number_of_passengers') }}</th>
                    <td>{{ $vehicle->number_of_passengers ?? trans('lang.not_available') }}</td>
                </tr>
                <tr>
                    <th>{{ trans('lang.car_model') }}</th>
                    <td>{{ $vehicle->car_model ?? trans('lang.not_available') }}</td>
                </tr>
                <tr>
                    <th>{{ trans('lang.car_color') }}</th>
                    <td>{{ $vehicle->car_color ?? trans('lang.not_available') }}</td>
                </tr>
                <tr>
                    <th>{{ trans('lang.licence_plate_number') }}</th>
                    <td>{{ $vehicle->licence_plate_number ?? trans('lang.not_available') }}</td>
                </tr>
                <tr>
                    <th>{{ trans('lang.car_image') }}</th>
                    <td>
                        @if (!empty($vehicle->car_image))
                            <img src="{{ asset('storage/' . $vehicle->car_image) }}" alt="{{ trans('lang.car_image') }}"
                                class="img-fluid rounded" style="max-width: 200px;">
                        @else
                            <span class="text-muted">{{ trans('lang.not_available') }}</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4 text-end">
            <a href="{{ route('drivers.index') }}" class="btn btn-primary">{{ trans('lang.back_to_drivers') }}</a>
        </div>
    </div>
@endsection
