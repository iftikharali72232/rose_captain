@extends('layouts.app')

@section('content')

    @if(isset($bookings))



            <div class="max-w-4xl mx-auto bg-white p-4 rounded-2 shadow-sm">
                <h2 class="fw-bold mb-6">{{ trans('lang.passengers_list') }}</h2>
                <hr>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>

                            <th>{{ trans('lang.driver_name') }}</th>
                            <th>{{ trans('lang.passengers_count') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($bookings as $index => $booking)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('passenger.show',$booking->user_id) }}">
                                        {{ $booking->total_passengers }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Passenger Details Modal -->

            </div>




@else

<div class="max-w-2xl mx-auto bg-white p-4 rounded-2 shadow-sm">
    <h2 class="fw-bold mb-6">{{ trans('lang.passengers_list') }}</h2>
    <hr>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('lang.passenger_name') }}</th>
                    <th>{{ trans('lang.id_number') }}</th>
                    <th>{{ trans('lang.nationality') }}</th>
                    <th>{{ trans('lang.mobile_no') }}</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($passenger as $index => $data)
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
