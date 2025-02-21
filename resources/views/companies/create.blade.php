
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Company</h1>
    <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="0">Inactive</option>
                <option value="1">Active</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Company</button>
    </form>
</div>
@endsection