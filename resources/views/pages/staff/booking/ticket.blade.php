@extends('layouts.app')

@section('content')
<!--wrapper-->
<div class="wrapper-main">
    <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                <h2 class="text-center text-uppercase mb-4">Maklumat Tempahan Meja</h2>
                    <div class="card bg-light text-dark shadow-sm">
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th class="text-uppercase">No. Meja</th>
                                    <td>{{ $booking->table->table_no }}</td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase">Nama</th>
                                    <td>{{ $booking->staff->name }}</td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase">No. Pekerja</th>
                                    <td>{{ $booking->staff->no_pekerja }}</td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase">No. Tempahan</th>
                                    <td>{{ $booking->booking_no }}</td>
                                </tr>
                                <tr>
                                    <th class="text-uppercase">Tarikh Tempahan</th>
                                    <td>{{ $booking->created_at->format('d-m-Y H:i') }}</td>
                                </tr>
                            </table>
                            <div class="alert alert-info mt-4">
                                <strong>Nota:</strong> Sila tunjukkan tiket ini kepada urusetia ketika hadir ke Malam Gala.
                            </div>
                            <div class="text-center">
                                <a href="{{ route('staff.booking.print', $booking->id) }}" class="btn btn-primary mt-3" target="_blank">
                                    <i class="fas fa-download"></i> Muat Turun Tiket
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end wrapper-->
@endsection