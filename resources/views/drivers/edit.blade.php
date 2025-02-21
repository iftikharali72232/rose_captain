
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password (leave blank to keep current password)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user_type">User Type</label>
            <select name="user_type" class="form-control" required>
                <option value="0" {{ $user->user_type == 0 ? 'selected' : '' }}>User</option>
                <option value="1" {{ $user->user_type == 1 ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection