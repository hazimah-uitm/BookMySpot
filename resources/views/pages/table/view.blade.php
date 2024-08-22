@extends('layouts.master')

@section('content')
<!-- Breadcrumb -->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Pengurusan Staf</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('table') }}">Senarai Staf</a></li>
                <li class="breadcrumb-item active" aria-current="page">Maklumat {{ $table->table_no }}</li>
            </ol>
        </nav>
    </div>
    <div class="ms-auto">
        <a href="{{ route('table.edit', $table->id) }}">
            <button type="button" class="btn btn-primary mt-2 mt-lg-0">Kemaskini Maklumat</button>
        </a>
    </div>
</div>
<!-- End Breadcrumb -->

<h6 class="mb-0 text-uppercase">Maklumat {{ $table->table_no }}</h6>
<hr />

<!-- Campus Information Table -->
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>No. Meja</th>
                        <td>{{ $table->table_no }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Tempat Duduk</th>
                        <td>{{ $table->total_seat }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Tempat Duduk Kosong</th>
                        <td>{{ $table->available_seat }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $table->status }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Campus Information Table -->
<!-- End Page Wrapper -->
@endsection