@ -1,41 +0,0 @@
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New User</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" class="form-control" required>
                <option value="0">Inactive</option>
                <option value="1">Active</option>
            </select>
        </div>
        <div class="form-group">
            <label for="user_type">User Type</label>
            <select name="user_type" class="form-control" required>
                <option value="1">User</option>
                <option value="0">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection