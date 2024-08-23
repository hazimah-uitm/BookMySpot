@extends('layouts.master')

@section('content')
<!-- Breadcrumb -->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Tempahan</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('booking') }}">Senarai Tempahan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah Tempahan</li>
            </ol>
        </nav>
    </div>
</div>
<!-- End Breadcrumb -->

<h6 class="mb-0 text-uppercase">Tambah Tempahan</h6>
<hr />
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <!-- Layout Plan Accordion -->
        <div class="accordion" id="layoutAccordion">
            <div class="accordion-item">
                <h4 class="accordion-header" id="headingOne">
                    <button class="accordion-button text-uppercase" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseLayout" aria-expanded="true" aria-controls="collapseLayout">
                        Paparan Pelan Meja Sebenar
                    </button>
                </h4>
                <div id="collapseLayout" class="accordion-collapse collapse" aria-labelledby="headingOne"
                    data-bs-parent="#layoutAccordion">
                    <div class="accordion-body">
                        <img src="{{ asset('public/assets/images/layout.jpg') }}" alt="Pelan Meja" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ $save_route }}" class="mt-3">
            {{ csrf_field() }}

            <div class="mb-3">
                <label for="staff_id" class="form-label">Pilih Staf</label>
                <select class="form-select select2 {{ $errors->has('staff_id') ? 'is-invalid' : '' }}" id="staff_id"
                    name="staff_id">
                    <option value="">Sila pilih Staf</option>
                    @foreach ($staffs as $staff)
                        <option value="{{ $staff->id }}" {{ old('staff_id') == $staff->id ? 'selected' : '' }}>
                            {{ $staff->no_pekerja }} - {{ $staff->name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('staff_id'))
                    <div class="invalid-feedback">Sila pilih Staf</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="table_id" class="form-label">Pilih No. Meja</label>
                <select class="form-select select2 {{ $errors->has('table_id') ? 'is-invalid' : '' }}" id="table_id"
                    name="table_id">
                    <option value="">Sila pilih No. Meja</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                            {{ $table->table_no }} <!-- or any attribute that represents the table -->
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('table_id'))
                    <div class="invalid-feedback">Sila pilih No. Meja</div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>

<!-- Initialize Select2 -->
<script>
    $(document).ready(function () {
        $('.select2').select2({
            width: 'resolve', // Adjust width as needed
            placeholder: 'Sila pilih',
            allowClear: true
        });
    });
</script>
@endsection