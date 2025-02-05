@ -1,30 +0,0 @@
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Company</h1>
    <form action="{{ route('companies.update', $company->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $company->name }}" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
            @if ($company->image)
                <img src="{{ asset( $company->image) }}" alt="{{ $company->name }}" width="100" class="mt-2">
            @endif
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="0" {{ $company->status == 0 ? 'selected' : '' }}>Inactive</option>
                <option value="1" {{ $company->status == 1 ? 'selected' : '' }}>Active</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Company</button>
    </form>
</div>
@endsection