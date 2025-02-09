@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('car_types.add_title') }}</h2>
    
    <form action="{{ route('car_types.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>{{ __('car_types.name') }}:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">{{ __('car_types.save') }}</button>
        <a href="{{ route('car_types.index') }}" class="btn btn-secondary">{{ __('car_types.back') }}</a>
    </form>
</div>
@endsection
