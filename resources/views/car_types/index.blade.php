@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Car Types</h2>
    <a href="{{ route('car_types.create') }}" class="btn btn-primary">Add New Car Type</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carTypes as $carType)
                <tr>
                    <td>{{ $carType->id }}</td>
                    <td>{{ $carType->name }}</td>
                    <td>
                        <a href="{{ route('car_types.edit', $carType->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('car_types.destroy', $carType->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
