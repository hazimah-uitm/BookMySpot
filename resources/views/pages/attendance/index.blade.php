@extends('layouts.master')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pengurusan Kehadiran</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Senarai Kehadiran</li>
                </ol>
            </nav>
        </div>
        @role('Superadmin')
        <div class="ms-auto">
            <a href="{{ route('attendance.trash') }}">
                <button type="button" class="btn btn-primary mt-2 mt-lg-0">Senarai Rekod Dipadam</button>
            </a>
        </div>
        @endrole
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">Senarai Kehadiran</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position_id-relative">
                    <form action="{{ route('attendance.search') }}" method="GET" id="searchForm"
                        class="d-lg-flex align-items-center gap-3">
                        <div class="input-group">
                            <input type="text" class="form-control rounded" placeholder="Carian..." name="search"
                                value="{{ request('search') }}" id="searchInput">

                            <!-- Type Filter -->
                            <select name="type" class="form-select form-select-sm ms-2" id="typeFilter">
                                <option value="">Pilih Jenis</option>
                                <option value="Staf" {{ request('type') == 'Staf' ? 'selected' : '' }}>Staf</option>
                                <option value="Bukan Staf" {{ request('type') == 'Bukan Staf' ? 'selected' : '' }}>Bukan
                                    Staf</option>
                            </select>

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
                <div class="ms-auto">
                    <a href="{{ route('attendance.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                        <i class="bx bxs-plus-square"></i> Tambah Kehadiran
                    </a>
                    <a href="{{ route('attendance.export', ['type' => $type]) }}" class="btn btn-success radius-30 mt-2 mt-lg-0">Export to
                        Excel</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No. Pekerja</th>
                            <th>Jenis Pengguna</th>
                            <th>Tarikh Imbas</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($attendanceList) > 0)
                            @foreach ($attendanceList as $attendance)
                                <tr>
                                    <td>{{ ($attendanceList->currentPage() - 1) * $attendanceList->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $attendance->staff->name }}</td>
                                    <td>{{ $attendance->staff->no_pekerja }}</td>
                                    <td>{{ $attendance->staff->booking->booking_no }}</td>
                                    <td>{{ $attendance->staff->type }}</td>
                                    <td>{{ $attendance->check_in }}</td>
                                    <td>
                                        <a type="button" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            data-bs-title="Padam">
                                            <span class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $attendance->id }}"><i
                                                    class="bx bx-trash"></i></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="6">Tiada rekod</td>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <span class="mr-2 mx-1">Jumlah rekod per halaman</span>
                    <form action="{{ route('attendance.search') }}" method="GET" id="perPageForm"
                        class="d-flex align-items-center">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="type" value="{{ request('type') }}">
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
                        Menunjukkan {{ $attendanceList->firstItem() }} hingga {{ $attendanceList->lastItem() }} daripada
                        {{ $attendanceList->total() }} rekod
                    </span>
                    <div class="pagination-wrapper">
                        {{ $attendanceList->appends([
                                'search' => request('search'),
                                'perPage' => request('perPage'),
                                'type' => request('type'),
                            ])->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @foreach ($attendanceList as $attendance)
        <div class="modal fade" id="deleteModal{{ $attendance->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Pengesahan Padam Rekod</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @isset($attendance)
                            Adakah anda pasti ingin memadam rekod <span style="font-weight: 600;">
                                {{ $attendance->attendance_no }}</span>?
                        @else
                            Tiada rekod
                        @endisset
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        @isset($attendance)
                            <form class="d-inline" method="POST"
                                action="{{ route('attendance.destroy', $attendance->id) }}">
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
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit the form on input change
            document.getElementById('searchInput').addEventListener('input', function() {
                document.getElementById('searchForm').submit();
            });

            document.getElementById('typeFilter').addEventListener('change', function() {
                document.getElementById('searchForm').submit();
            });

            // Reset form
            document.getElementById('resetButton').addEventListener('click', function() {
                document.getElementById('searchForm').reset();
                // Clear hidden fields to reset pagination and filters
                document.getElementById('searchForm').querySelector('input[name="search"]').value = '';
                document.getElementById('searchForm').querySelector('select[name="type"]').value = '';
                document.getElementById('searchForm').submit();
            });
        });
    </script>
@endsection
