@extends('layouts.app')

@section('content')
    <div class="container bg-white p-4 rounded-2 shadow-sm">
        <div class="d-flex align-items-center mb-4">
            <h1 class="fw-bold me-3">{{ $company->name }}</h1>
            <span class="badge {{ $company->status ? 'bg-success' : 'bg-danger' }}">
                {{ $company->status ? trans('lang.active') : trans('lang.inactive') }}
            </span>
        </div>

        <hr>

        <div class="row">
            <div class="col-md-4 text-center">
                @if ($company->image)
                    <img src="{{ asset('storage/' . $company->image) }}" alt="{{ $company->name }}" class="img-fluid rounded"
                        style="max-width: 250px;">
                @else
                    <div class="bg-light p-3 rounded border text-muted">
                        {{ trans('lang.no_image_available') }}
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <table class="table">
                    <tr>
                        <th>{{ trans('lang.company_name') }}</th>
                        <td>{{ $company->name }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('lang.status') }}</th>
                        <td>
                            <span class="badge {{ $company->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $company->status ? trans('lang.active') : trans('lang.inactive') }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>{{ trans('lang.email') }}</th>
                        <td>{{ $company->email ?? trans('lang.not_available') }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('lang.phone') }}</th>
                        <td>{{ $company->phone ?? trans('lang.not_available') }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('lang.address') }}</th>
                        <td>{{ $company->address ?? trans('lang.not_available') }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('lang.created_at') }}</th>
                        <td>{{ $company->created_at->format('d M, Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="d-flex justify-content-between">
            <a href="{{ route('companies.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> {{ trans('lang.back_to_companies') }}
            </a>

            <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> {{ trans('lang.edit_company') }}
            </a>

            <form action="{{ route('companies.destroy', $company->id) }}" method="POST"
                onsubmit="return confirm('{{ trans('lang.confirm_delete') }}');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> {{ trans('lang.delete') }}
                </button>
            </form>
        </div>
    </div>
@endsection
