@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Print Your Booking Ticket</h1>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Booking Details</h4>
            <p><strong>Booking Number:</strong> {{ $booking->booking_no }}</p>
            <p><strong>Table:</strong> {{ $booking->table->name }}</p>
            <p><strong>Date:</strong> {{ $booking->created_at->format('d-m-Y H:i') }}</p>

            <!-- Add any additional ticket details here -->

            <a href="#" class="btn btn-primary" onclick="window.print()">Print Ticket</a>
        </div>
    </div>
</div>
@endsection
