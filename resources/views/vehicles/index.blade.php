@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Vehicles</h1>
    <a href="{{ route('vehicles.create') }}" class="btn btn-primary mb-3">Create New Vehicle</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vehicle Name</th>
                <th>User</th>
                <th>Company</th>
                <th>VIN Number</th>
                <th>Number Plate</th>
                <th>Color</th>
                <th>Model</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehicles as $vehicle)
            <tr>
                <td>{{ $vehicle->id }}</td>
                <td>{{ $vehicle->vehicle_name }}</td>
                <td>{{ $vehicle->user->name }}</td>
                <td>{{ $vehicle->company->name }}</td>
                <td>{{ $vehicle->vin_number }}</td>
                <td>{{ $vehicle->number_plate }}</td>
                <td>{{ $vehicle->color }}</td>
                <td>{{ $vehicle->model }}</td>
                <td>{{ $vehicle->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection