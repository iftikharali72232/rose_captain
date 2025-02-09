@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Car Type</h2>
    
    <form action="{{ route('car_types.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('car_types.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
