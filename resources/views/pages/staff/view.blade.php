@extends('layouts.master')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pengurusan Staf</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('staff') }}">Senarai Staf</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Maklumat {{ ucfirst($staff->name) }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <a href="{{ route('staff.edit', $staff->id) }}">
                <button type="button" class="btn btn-primary mt-2 mt-lg-0">Kemaskini Maklumat</button>
            </a>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <h6 class="mb-0 text-uppercase">Maklumat {{ ucfirst($staff->name) }}</h6>
    <hr />

    <!-- Campus Information Table -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama Penuh</th>
                            <td>{{ ucfirst($staff->name) }}</td>
                        </tr>
                        <tr>
                            <th>ID Pekerja</th>
                            <td>{{ $staff->no_pekerja }}</td>
                        </tr>
                        <tr>
                            <th>Emel</th>
                            <td>{{ $staff->email }}</td>
                        </tr>
                        <tr>
                            <th>Kehadiran</th>
                            <td>{{ $staff->attendance }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $staff->category }}</td>
                        </tr>
                        <tr>
                            <th>Unit/Bahagian</th>
                            <td>{{ $staff->department }}</td>
                        </tr>
                        <tr>
                            <th>Kampus</th>
                            <td>{{ $staff->campus }}</td>
                        </tr>
                        <tr>
                            <th>Keahlian Kelab</th>
                            <td>{{ $staff->club }}</td>
                        </tr>
                        <tr>
                            <th>Bukti Pembayaran</th>
                            <td>
                                @if ($staff->payment)
                                    <a href="{{ $staff->payment }}" target="_blank">Lihat Bukti Pembayaran</a>
                                @else
                                    Tiada bukti pembayaran.
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if ($staff->status == 'Belum Tempah')
                                    <span class="badge bg-warning">Belum Tempah</span>
                                @else
                                    <span class="badge bg-success">Selesai Tempah</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Campus Information Table -->
    <!-- End Page Wrapper -->
@endsection
