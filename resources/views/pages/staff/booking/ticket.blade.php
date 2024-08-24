@extends('layouts.app')

@section('content')
    <!--wrapper-->
    <div class="wrapper-main">
        <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-9">
                        <h2 class="text-center text-uppercase mb-4">Tiket Malam Gala</h2>
                        <div class="card ticket-card shadow-lg">
                            <div class="row">
                                <!-- Left Section: Ticket Info -->
                                <div class="col-12 col-md-8">
                                    <div class="ticket-info">
                                        <div class="ticket-header mb-4">
                                            <div class="text-center">
                                                <!-- Center the logo within the parent container -->
                                                <img src="{{ asset('public/assets/images/logo-malam-gala.png') }}"
                                                    alt="Logo Malam Gala" class="img-fluid mx-auto d-block mb-2"
                                                    style="max-width: 100%; height: auto;">
                                            </div>
                                        </div>
                                        <table class="table table-borderless mb-0">
                                            <tr>
                                                <th class="text-uppercase">No. Meja</th>
                                                <td style="font-weight:bold">{{ $booking->table->table_no }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-uppercase">Nama</th>
                                                <td style="font-weight:bold">{{ $booking->staff->name }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-uppercase">No. Pekerja</th>
                                                <td style="font-weight:bold">{{ $booking->staff->no_pekerja }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-uppercase">No. Tempahan</th>
                                                <td style="font-weight:bold">{{ $booking->booking_no }}</td>
                                            </tr>
                                        </table>

                                        <!-- Footer: Notes and Download Button -->
                                        <div class="ticket-footer mt-4">
                                            <div class="text-center mt-2">
                                                <em>Sila imbas kod QR ini kepada urusetia semasa hadir ke Malam Gala 25 Tahun UiTM</em>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- Right Section: QR Code or Logo -->
                                <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-center">
                                    <div
                                        class="qr-code-container d-flex justify-content-center align-items-center text-center">
                                        <img src="{{ $booking->qr_code }}" alt="QR Code" class="qr-code">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-3">
                            <a href="{{ route('staff.booking.print', $booking->id) }}" class="btn btn-primary w-100">
                                <i class="fas fa-download"></i> Muat Turun Tiket
                            </a>
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
