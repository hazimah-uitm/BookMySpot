@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pengurusan Staf</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('booking') }}">Senarai Staf</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Maklumat {{ ucfirst($booking->booking_no) }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('booking.edit', $booking->id) }}">
                <button type="button" class="btn btn-primary mt-2 mt-lg-0">Kemaskini Maklumat</button>
            </a>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <h6 class="mb-0 text-uppercase">Maklumat {{ ucfirst($booking->booking_no) }}</h6>
    <hr />

    <!-- Campus Information Table -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>No. Meja</th>
                            <td>{{ $booking->table->table_no }}</td>
                        </tr>
                        <tr>
                            <th>No. Pekerja</th>
                            <td>{{ $booking->staff->no_pekerja }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $booking->staff->name }}</td>
                        </tr>
                        <tr>
                            <th>No. Tempahan</th>
                            <td>{{ $booking->booking_no }}</td>
                        </tr>
                        <tr>
                            <th>Tarikh Tempahan</th>
                            <td>{{ $booking->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Campus Information Table -->
    <!-- End Page Wrapper -->
@endsection
