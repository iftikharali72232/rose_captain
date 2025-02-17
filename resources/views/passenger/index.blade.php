@extends('layouts.app')

@section('content')

    @if(isset($bookings))



            <div class="max-w-4xl mx-auto bg-white p-4 rounded-2 shadow-sm">
                <h2 class="fw-bold mb-6">{{ trans('lang.booking') }}</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>

                            <th>{{ trans('lang.driver_name') }}</th>
                            <th>{{ trans('lang.list_count') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($bookings as $index => $booking)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                <td>
                                    <a target="_blank" href="{{ route('passenger.show',$booking->user_id) }}">
                                        {{ $booking->total_passengers }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>




@elseif(isset($bookings_detail))
        <div class="max-w-4xl mx-auto bg-white p-4 rounded-2 shadow-sm">
        <h2 class="fw-bold mb-6">{{ trans('lang.booking') }}</h2>
        <hr>
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>

                    <th>{{ trans('lang.driver_name') }}</th>
                    <th>{{ trans('lang.from') }}</th>
                    <th>{{ trans('lang.to') }}</th>
                    <th>{{ trans('lang.passengers_count') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($bookings_detail as $index => $booking)
                    <tr>
                        <td>{{ $index + 1 }}</td>

                        <td>{{ $booking->user->name ?? 'N/A' }}</td>
                        <td>{{ $booking->from  }}</td>
                        <td>{{ $booking->to  }}</td>
                        <td>
                            <a target="_blank" href="{{ route('passenger.detaild',$booking->id) }}">
                                {{ $booking->passengers->count() }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        </div>
        @else

<div class="max-w-2xl mx-auto bg-white p-4 rounded-2 shadow-sm">
    <h2 class="fw-bold mb-6">{{ trans('lang.passengers_list') }}</h2>
    <hr>
    <div class="table-responsive">
        <table class="table">
            <thead>

            <tr>
                <th colspan="2">{{ trans('lang.driver_name') }}: {{ $passenger->user->name ?? 'N/A' }}</th>
                <th colspan="2">{{ trans('lang.vehicle_name') }}: {{ $passenger->user->vehicles->first()->car_type ?? 'N/A' }}</th>

            </tr>
                <tr>
                    <th>#</th>
                    <th>{{ trans('lang.passenger_name') }}</th>
                    <th>{{ trans('lang.id_number') }}</th>
                    <th>{{ trans('lang.nationality') }}</th>
                    <th>{{ trans('lang.mobile_no') }}</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($passenger->passengers as $index => $data)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $data->name }}</td>
                    <td>{{ $data->id_number }}</td>
                    <td>{{ $data->nationality }}</td>
                    <td>{{ $data->mobile_number }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
    @endif
@endsection
