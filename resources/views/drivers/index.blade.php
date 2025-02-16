@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-4 rounded-2 shadow-sm">
    <h2 class="fw-bold mb-6">{{ trans('lang.drivers_list') }}</h2>
    <hr>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('lang.name') }}</th>
                    <th>{{ trans('lang.mobile') }}</th>
                    <th>{{ trans('lang.id_number') }}</th>
                    <th>{{ trans('lang.id_image') }}</th>
                    <th>{{ trans('lang.status') }}</th>
                    <th>{{ trans('lang.action') }}</th>
                </tr>
            </thead>
            <tbody>
            @php
                {{ $filePath = storage_path('app/public/your-file.jpg');}}
            @endphp
                @foreach ($drivers as $index => $driver)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $driver->name }}</td>
                    <td>{{ $driver->mobile }}</td>
                    <td>{{ $driver->id_number }}</td>
                    <td>
                        @if($driver->id_image)
                        <a href="{{ asset('storage/'.$driver->id_image) }}"> ID Image</a>
                        @else
                        {{ 'N/A' }}
                            @endif
                    </td>
                    <td>
                        <span class="badge {{ $driver->status ? 'bg-success' : 'bg-danger' }}">
                            {{ $driver->status ? trans('lang.approved') : trans('lang.unapproved') }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('drivers.update_status', $driver->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $driver->status ? 'btn-danger' : 'btn-success' }}">
                                {{ $driver->status ? trans('lang.unapprove') : trans('lang.approve') }}
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
