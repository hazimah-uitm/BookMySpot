@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Print Your Booking Ticket</h1>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Booking Details</h4>
            <p><strong>No. Tempahan:</strong> {{ $booking->booking_no }}</p>
            <p><strong>Nama:</strong> {{ $booking->staff->name }}</p>
            <p><strong>No. Pekerja:</strong> {{ $booking->staff->no_pekerja }}</p>
            <p><strong>No. Meja:</strong> {{ $booking->table->table_no }}</p>
            <p><strong>Tarikh Tempahan:</strong> {{ $booking->created_at->format('d-m-Y H:i') }}</p>

            <!-- Add any additional ticket details here -->

            <a href="#" class="btn btn-primary" onclick="window.print()">Print Ticket</a>
        </div>
    </div>
</div>
@endsection
