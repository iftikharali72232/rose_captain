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
                        <th>{{ trans('lang.license_image_url') }}</th>
                        <th>{{ trans('lang.status') }}</th>
                        <th>{{ trans('lang.action') }}</th>
                        <th>{{ trans('lang.company') }}</th>
                        <th>{{ trans('lang.vehicle') }}</th>
                        <th>{{ trans('lang.list_count') }}</th>
                        <th>{{ trans('lang.delete') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $index => $driver)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $driver->name }}</td>
                            <td>{{ $driver->mobile }}</td>
                            <td>{{ $driver->id_number }}</td>
                            <td>
                                @if ($driver->id_image)
                                    <a href="{{ asset('storage/' . $driver->id_image) }}"> ID Image</a>
                                @else
                                    {{ 'N/A' }}
                                @endif
                            </td>

                            <td>
                                @if ($driver->getRawOriginal('license_image_url'))
                                    <a href="{{ asset('storage/' . $driver->getRawOriginal('license_image_url')) }}">License
                                        Image</a>
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
                                    <button type="submit"
                                        class="btn btn-sm {{ $driver->status ? 'btn-danger' : 'btn-success' }}">
                                        {{ $driver->status ? trans('lang.unapprove') : trans('lang.approve') }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                @if ($driver->company)
                                    <a href="{{ route('company.show', ['company' => $driver->company->id]) }}">
                                        {{ trans('lang.view_company') }}
                                    </a>
                                @else
                                    {{ 'N/A' }}
                                @endif
                            </td>
                            <td>
                                @if ($driver->vehicle)
                                    <a href="{{ route('vehicles.show', ['vehicle' => $driver->vehicle->id]) }}">
                                        {{ trans('lang.view_vehicle') }}
                                    </a>
                                @else
                                    {{ 'N/A' }}
                                @endif
                            </td>

                            <td>
                                @if ($driver->booking_count)
                                    <a target="_blank" href="{{ route('passenger.show',$driver->id) }}">
                                        {{ $driver->booking_count }}
                                    </a>
                                @else
                                    {{ 'N/A' }}
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('users.destroy', $driver->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this driver?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        {{ trans('lang.delete') }}
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
