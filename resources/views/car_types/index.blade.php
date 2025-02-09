@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ trans('lang.car_type_list') }}</h2>
    <a href="{{ route('car_types.create') }}" class="btn btn-primary">{{ trans('lang.add_car_type') }}</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>{{ trans('lang.id') }}</th>
                <th>{{ trans('lang.name') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($carTypes as $carType)
                <tr>
                    <td>{{ $carType->id }}</td>
                    <td>{{ $carType->name }}</td>
                    <td>
                        <a href="{{ route('car_types.edit', $carType->id) }}" class="btn btn-warning">{{ trans('lang.edit') }}</a>
                        <form action="{{ route('car_types.destroy', $carType->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('{{ trans('lang.are_you_sure') }}')">{{ trans('lang.delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
