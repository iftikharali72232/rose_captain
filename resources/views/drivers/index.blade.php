@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Drivers List</h2>
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
@endsection
