@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Vehicles List</h2>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Owner</th>
                <th>Car Type</th>
                <th>Model</th>
                <th>Color</th>
                <th>License Plate</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehicles as $index => $vehicle)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $vehicle->user->name ?? 'N/A' }}</td>
                <td>{{ $vehicle->car_type }}</td>
                <td>{{ $vehicle->car_model }}</td>
                <td>{{ $vehicle->car_color }}</td>
                <td>{{ $vehicle->licence_plate_number }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
