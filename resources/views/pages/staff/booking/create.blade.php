@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Make a Booking</h1>
    <form action="{{ route('staff.booking.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="table_id">Select Table</label>
            <select name="table_id" id="table_id" class="form-control">
                @foreach($tables as $table)
                    <option value="{{ $table->id }}">{{ $table->name }} ({{ $table->available_seat }} seats available)</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="staff_id" value="{{ $staff->id }}">
        <button type="submit" class="btn btn-primary">Book</button>
    </form>
</div>
@endsection
