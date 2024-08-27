@extends('layouts.master')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Pengurusan Tempahan</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Senarai Tempahan</li>
            </ol>
        </nav>
    </div>
    @role('Superadmin')
    <div class="ms-auto">
        <a href="{{ route('booking.trash') }}">
            <button type="button" class="btn btn-primary mt-2 mt-lg-0">Senarai Rekod Dipadam</button>
        </a>
    </div>
    @endrole
</div>
<!--end breadcrumb-->
<h6 class="mb-0 text-uppercase">Senarai Tempahan</h6>
<hr />
@if (session('success'))
    <div class="alert alert-success mt-2">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger mt-2">
        {{ session('error') }}
    </div>
@endif
<div class="card">
    <div class="card-body">
        <div class="d-lg-flex align-items-center mb-4 gap-3">
            <div class="position-relative">
                <form action="{{ route('booking.search') }}" method="GET" id="searchForm"
                    class="d-lg-flex align-items-center gap-3">
                    <div class="input-group">
                        <input type="text" class="form-control rounded" placeholder="Carian..." name="search"
                            value="{{ request('search') }}" id="searchInput">

                        <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                        <button type="submit" class="btn btn-primary ms-1 rounded" id="searchButton">
                            <i class="bx bx-search"></i>
                        </button>
                        <button type="button" class="btn btn-secondary ms-1 rounded" id="resetButton">
                            Reset
                        </button>
                    </div>
                </form>
            </div>
            <div class="ms-auto d-flex gap-2 align-items-center">
                <!-- Tambah Button -->
                <a href="{{ route('booking.create') }}" class="btn btn-primary">
                    Tambah Tempahan
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>No. Meja</th>
                        <th>Nama</th>
                        <th>No. Pekerja</th>
                        <th>No. Tempahan</th>
                        <th>Tarikh Tempahan</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($bookingList) > 0)
                        @foreach ($bookingList as $booking)
                            <tr>
                                <td>{{ ($bookingList->currentPage() - 1) * $bookingList->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $booking->table->table_no }}</td>
                                <td>{{ $booking->staff->name }}</td>
                                <td>{{ $booking->staff->no_pekerja }}</td>
                                <td>{{ $booking->booking_no }}</td>
                                <td>{{ $booking->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-info btn-sm"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kemaskini">
                                        <i class="bx bxs-edit"></i>
                                    </a>
                                    <a href="{{ route('booking.show', $booking->id) }}" class="btn btn-primary btn-sm"
                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Papar">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a type="button" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Padam">
                                        <span class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $booking->id }}"><i class="bx bx-trash"></i></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td colspan="9">Tiada rekod</td>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="mt-3 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <span class="mr-2 mx-1">Jumlah rekod per halaman</span>
                <form action="{{ route('booking.search') }}" method="GET" id="perPageForm"
                    class="d-flex align-items-center">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="perPage" id="perPage" class="form-select form-select-sm"
                        onchange="document.getElementById('perPageForm').submit()">
                        <option value="10" {{ Request::get('perPage') == '10' ? 'selected' : '' }}>10</option>
                        <option value="20" {{ Request::get('perPage') == '20' ? 'selected' : '' }}>20</option>
                        <option value="30" {{ Request::get('perPage') == '30' ? 'selected' : '' }}>30</option>
                    </select>
                </form>
            </div>

            <div class="d-flex justify-content-end align-items-center">
                <span class="mx-2 mt-2 small text-muted">
                    Menunjukkan {{ $bookingList->firstItem() }} hingga {{ $bookingList->lastItem() }} daripada
                    {{ $bookingList->total() }} rekod
                </span>
                <div class="pagination-wrapper">
                    {{ $bookingList->appends([
    'search' => request('search'),
])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
@foreach ($bookingList as $booking)
    <div class="modal fade" id="deleteModal{{ $booking->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Pengesahan Padam Rekod</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @isset($booking)
                        Adakah anda pasti ingin memadam rekod <span style="font-weight: 600;">
                            {{ ucfirst($booking->name) }}</span>?
                    @else
                        Tiada rekod
                    @endisset
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    @isset($booking)
                        <form class="d-inline" method="POST" action="{{ route('booking.destroy', $booking->id) }}">
                            {{ method_field('delete') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger">Padam</button>
                        </form>
                    @endisset
                </div>
            </div>
        </div>
    </div>
@endforeach
<!--end page wrapper -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-submit the form on input change
        document.getElementById('searchInput').addEventListener('input', function () {
            document.getElementById('searchForm').submit();
        });

        // Reset form
        document.getElementById('resetButton').addEventListener('click', function () {
            document.getElementById('searchForm').reset();
            // Clear hidden fields to reset pagination and filters
            document.getElementById('searchForm').querySelector('input[name="search"]').value = '';
            document.getElementById('searchForm').submit();
        });
    });
</script>
@endsection