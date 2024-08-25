@extends('layouts.master')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Pengurusan Meja</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Senarai Meja</li>
                </ol>
            </nav>
        </div>
        @role('Superadmin')
        <div class="ms-auto">
            <a href="{{ route('table.trash') }}">
                <button type="button" class="btn btn-primary mt-2 mt-lg-0">Senarai Rekod Dipadam</button>
            </a>
        </div>
        @endrole
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">Senarai Meja</h6>
    <hr />
    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <div class="position_id-relative">
                    <form action="{{ route('table.search') }}" method="GET">
                        <div class="input-group">
                            <!-- Search Input Field -->
                            <input type="text" class="form-control rounded" placeholder="Carian..." name="search"
                                value="{{ request('search') }}">

                            <!-- Search Button -->
                            <button type="submit" class="btn btn-primary ms-1 rounded">
                                <i class="bx bx-search"></i>
                            </button>

                            <!-- Reset Button -->
                            <button type="reset" class="btn btn-secondary ms-1 rounded" onclick="resetForm()">
                                Reset
                            </button>
                        </div>
                    </form>
                </div>
                <div class="ms-auto">
                    <a href="{{ route('table.create') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                        <i class="bx bxs-plus-square"></i> Tambah Meja
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>No. Meja</th>
                            <th>Jumlah Tempat Duduk</th>
                            <th>Jumlah Tempat Duduk Kosong</th>
                            <th>Jenis Meja</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($tableList) > 0)
                            @foreach ($tableList as $table)
                                <tr>
                                    <td>{{ ($tableList->currentPage() - 1) * $tableList->perPage() + $loop->iteration }}
                                    </td>
                                    <td>{{ $table->table_no }}</td>
                                    <td>{{ $table->total_seat }}</td>
                                    <td>{{ $table->available_seat }}</td>
                                    <td>{{ $table->type }}</td>
                                    <td>
                                        @if ($table->status == 'Tersedia')
                                            <span class="badge bg-success">Tersedia</span>
                                        @else
                                            <span class="badge bg-warning">Penuh</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('table.edit', $table->id) }}" class="btn btn-info btn-sm"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kemaskini">
                                            <i class="bx bxs-edit"></i>
                                        </a>
                                        <a href="{{ route('table.show', $table->id) }}" class="btn btn-primary btn-sm"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Papar">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        <a type="button" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            data-bs-title="Padam">
                                            <span class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $table->id }}"><i
                                                    class="bx bx-trash"></i></span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <td colspan="4">Tiada rekod</td>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="mt-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <span class="mr-2 mx-1">Jumlah rekod per halaman</span>
                    <form action="{{ route('table.search') }}" method="GET" id="perPageForm"
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
                        Menunjukkan {{ $tableList->firstItem() }} hingga {{ $tableList->lastItem() }} daripada
                        {{ $tableList->total() }} rekod
                    </span>
                    <div class="pagination-wrapper">
                        {{ $tableList->appends(['search' => request('search'), 'perPage' => $perPage])->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @foreach ($tableList as $table)
        <div class="modal fade" id="deleteModal{{ $table->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Pengesahan Padam Rekod</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @isset($table)
                            Adakah anda pasti ingin memadam rekod <span style="font-weight: 600;">
                                {{ $table->table_no }}</span>?
                        @else
                            Tiada rekod
                        @endisset
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        @isset($table)
                            <form class="d-inline" method="POST" action="{{ route('table.destroy', $table->id) }}">
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
        document.querySelector('button[type="reset"]').addEventListener('click', function() {
            // Redirect to another page or reload the page
            window.location.href = "{{ route('table') }}"; // Adjust the route as needed
        });
    </script>
@endsection
