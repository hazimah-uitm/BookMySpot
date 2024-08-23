@extends('layouts.app')

@section('content')
<!--wrapper-->
<div class="wrapper-main">
    <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9">
                    <h2 class="text-center text-uppercase mb-4">Maklumat Tempahan Meja</h2>
                    <div class="card border rounded shadow-lg p-3">
                        <div class="row">
                            <!-- Left Section: Ticket Info -->
                            <div class="col-8">
                                <div class="ticket-info">
                                    <h5 class="text-uppercase">Malam Gala</h5>
                                    <h6 class="text-uppercase">No. Tempahan: {{ $booking->booking_no }}</h6>
                                    <hr>
                                    <table class="table table-borderless mb-0">
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
                                            <th class="text-uppercase">Tarikh Tempahan</th>
                                            <td>{{ $booking->created_at->format('d-m-Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Right Section: QR Code or Logo (Optional) -->
                            <div class="col-4 text-center">
                                <div class="ticket-logo">
                                    <img src="{{ asset('public/assets/images/25tahun.png') }}" style="max-width: 100px; height: auto;" alt="25" class="img-fluid mb-2">
                                </div>
                                <div class="ticket-barcode">
                                    <!-- Placeholder for QR Code or Barcode -->
                                    <img src="{{ asset('public/assets/images/putih.png') }}" style="max-width: 100px; height: auto;" alt="Logo UiTM" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <!-- Footer: Notes and Download Button -->
                        <div class="ticket-footer mt-3">
                            <div class="alert alert-info text-center">
                                <strong>Nota:</strong> Sila tunjukkan tiket ini kepada urusetia ketika hadir ke Malam Gala.
                            </div>
                            <div class="text-center">
                                <a href="{{ route('staff.booking.print', $booking->id) }}" class="btn btn-primary w-100" target="_blank">
                                    <i class="fas fa-download"></i> Muat Turun Tiket
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="card bg-light text-dark shadow-sm mt-3">
                        <div class="card-body">
                            <!-- Layout Plan Accordion -->
                            <div class="mt-4">
                                <div class="accordion" id="layoutAccordion">
                                    <div class="accordion-item">
                                        <h4 class="accordion-header" id="headingOne">
                                            <button class="accordion-button text-uppercase" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseLayout"
                                                aria-expanded="true" aria-controls="collapseLayout">
                                                Paparan Pelan Meja Sebenar
                                            </button>
                                        </h4>
                                        <div id="collapseLayout" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#layoutAccordion">
                                            <div class="accordion-body">
                                                <img src="{{ asset('public/assets/images/layout.jpg') }}"
                                                    alt="Pelan Meja" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hall Layout -->
                            <div class="hall-layout position-relative text-center mt-4">
                                <!-- Tables -->
                                <div class="row justify-content-center mt-4">
                                    @foreach ($tables as $table)
                                    <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center mb-4">
                                        <div class="table-round p-3 
                                        @if ($table->id == $booking->table_id) bg-warning 
                                        @elseif ($table->available_seat > 0) bg-success
                                        @else bg-secondary text-light @endif"
                                            id="table-container-{{ $table->id }}">
                                            <div>
                                                <label class="text-dark">
                                                    <strong>{{ $table->table_no }}</strong>
                                                </label>
                                            </div>
                                            <div class="table-info">
                                                @if ($table->available_seat == 0)
                                                <p>Penuh</p>
                                                @else
                                                <p>{{ $table->available_seat }} kerusi kosong</p>
                                                @endif
                                                @if ($table->id == $booking->table_id)
                                                <p style="font-size: 10px; font-weight:bold">
                                                    {{ $booking->staff->name }}
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
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