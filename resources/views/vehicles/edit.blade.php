@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Vehicle</h1>
    <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="user_id">User</label>
            <select name="user_id" class="form-control" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $vehicle->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="company_id">Company</label>
            <select name="company_id" class="form-control" required>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" {{ $vehicle->company_id == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="vehicle_name">Vehicle Name</label>
            <input type="text" name="vehicle_name" class="form-control" value="{{ $vehicle->vehicle_name }}" required>
        </div>
        <div class="form-group">
            <label for="vin_number">VIN Number</label>
            <input type="text" name="vin_number" class="form-control" value="{{ $vehicle->vin_number }}" required>
        </div>
        <div class="form-group">
            <label for="number_plate">Number Plate</label>
            <input type="text" name="number_plate" class="form-control" value="{{ $vehicle->number_plate }}" required>
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" name="color" class="form-control" value="{{ $vehicle->color }}" required>
        </div>
        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" name="model" class="form-control" value="{{ $vehicle->model }}" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="0" {{ $vehicle->status == 0 ? 'selected' : '' }}>Inactive</option>
                <option value="1" {{ $vehicle->status == 1 ? 'selected' : '' }}>Active</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Vehicle</button>
    </form>
</div>
@endsection