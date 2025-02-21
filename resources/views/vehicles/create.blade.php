@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Vehicle</h1>
    <form action="{{ route('vehicles.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_id">User</label>
            <select name="user_id" class="form-control" required>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="company_id">Company</label>
            <select name="company_id" class="form-control" required>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="vehicle_name">Vehicle Name</label>
            <input type="text" name="vehicle_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="vin_number">VIN Number</label>
            <input type="text" name="vin_number" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="number_plate">Number Plate</label>
            <input type="text" name="number_plate" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" name="color" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" name="model" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="0">Inactive</option>
                <option value="1">Active</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Vehicle</button>
    </form>
</div>
@endsection