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
                <li class="breadcrumb-item"><a href="{{ route('table') }}"></i>Senarai Meja</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Senarai Meja Dipadam</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<h6 class="mb-0 text-uppercase">Senarai Meja Dipadam</h6>
<hr />
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No. Meja</th>
                        <th>Jumlah Tempat Duduk</th>
                        <th>Jumlah Tempat Duduk Available</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($trashList) > 0)
                    @foreach ($trashList as $table)
                    <tr>
                        <td>{{ $table->table_no }}</td>
                        <td>{{ $table->total_seat }}</td>
                        <td>{{ $table->available_seat }}</td>
                        <td>
                            @if ($table->status == 'Available')
                            <span class="badge bg-success">Available</span>
                            @else
                            <span class="badge bg-warning">Booked</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('table.restore', $table->id) }}" class="btn btn-success btn-sm"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Kembalikan">
                                <i class="bx bx-undo"></i>
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
        <div class="mt-3 d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <span class="mr-2 mx-1">Jumlah rekod per halaman</span>
                <form action="{{ route('table') }}" method="GET" id="perPageForm">
                    <select name="perPage" id="perPage" class="form-select"
                        onchange="document.getElementById('perPageForm').submit()">
                        <option value="10" {{ Request::get('perPage') == '10' ? 'selected' : '' }}>10</option>
                        <option value="20" {{ Request::get('perPage') == '20' ? 'selected' : '' }}>20</option>
                        <option value="30" {{ Request::get('perPage') == '30' ? 'selected' : '' }}>30</option>
                    </select>
                </form>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                <div class="mx-1 mt-2">{{ $trashList->firstItem() }} – {{ $trashList->lastItem() }} dari
                    {{ $trashList->total() }} rekod
                </div>
                <div>{{ $trashList->links() }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
@foreach ($trashList as $table)
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
                <form class="d-inline" method="POST" action="{{ route('table.forceDelete', $table->id) }}">
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
@endsection