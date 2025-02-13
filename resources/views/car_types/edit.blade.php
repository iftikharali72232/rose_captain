@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Car Type</h2>
    
    <form action="{{ route('car_types.update', $carType->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $carType->name }}" required>
        </div>
        <div class="form-group">
            <label>Arabic Name:</label>
            <input type="text" name="name_ar" class="form-control" value="{{ $carType->name_ar }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('car_types.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
