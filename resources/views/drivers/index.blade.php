@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-4 rounded-2 shadow-sm">
    <h2 class="fw-bold mb-6">Drivers List</h2>
    <hr>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>ID Number</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($drivers as $index => $driver)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $driver->name }}</td>
                    <td>{{ $driver->mobile }}</td>
                    <td>{{ $driver->id_number }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
