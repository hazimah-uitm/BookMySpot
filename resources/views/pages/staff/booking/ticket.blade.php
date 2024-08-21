@extends('layouts.app')

@section('content')
<!--wrapper-->
<div class="wrapper-main">
    <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <h1 class="text-center text-white mb-4">Tiket Tempahan</h1>
                    <div class="card bg-light text-dark">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Keterangan Tempahan</h4>
                            <p><strong>No. Tempahan:</strong> {{ $booking->booking_no }}</p>
                            <p><strong>Nama:</strong> {{ $booking->staff->name }}</p>
                            <p><strong>No. Pekerja:</strong> {{ $booking->staff->no_pekerja }}</p>
                            <p><strong>No. Meja:</strong> {{ $booking->table->table_no }}</p>
                            <p><strong>Tarikh Tempahan:</strong> {{ $booking->created_at->format('d-m-Y H:i') }}</p>
                            <p><strong>Sila tunjuk tiket ini kepada urusetia semasa datang ke Malam Gala Dinner.</strong></p>

                            <a href="{{ route('staff.booking.print', $booking->id) }}" class="btn btn-primary mt-3" target="_blank">Muat Turun</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end wrapper-->
@endsection
