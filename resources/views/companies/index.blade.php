@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Companies List</h2>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Company Name</th>
                <th>Owner</th>
                <th>Registration Number</th>
                <th>Company Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($companies as $index => $company)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $company->company_name }}</td>
                <td>{{ $company->user->name ?? 'N/A' }}</td>
                <td>{{ $company->company_registration_number }}</td>
                <td>{{ $company->company_type }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
