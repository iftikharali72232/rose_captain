@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-4 rounded-2 shadow-sm">
    <h2 class="fw-bold mb-6">{{ trans('lang.companies_list') }}</h2>
    <hr>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('lang.company_name') }}</th>
                    <th>{{ trans('lang.owner') }}</th>
                    <th>{{ trans('lang.registration_number') }}</th>
                    <th>{{ trans('lang.company_type') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $index => $company)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $company->company_name }}</td>
                    <td>{{ $company->user->name ?? trans('lang.not_available') }}</td>
                    <td>{{ $company->company_registration_number }}</td>
                    <td>{{ $company->company_type }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
