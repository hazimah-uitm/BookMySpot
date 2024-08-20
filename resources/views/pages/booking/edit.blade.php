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
                    <li class="breadcrumb-item active" aria-current="page">Kemas Kini Tempahan</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <h6 class="mb-0 text-uppercase">Kemas Kini Tempahan</h6>
    <hr />

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ $save_route }}">
                {{ csrf_field() }}

                <div class="mb-3">
                    <!-- Staff Select Dropdown -->
                    <label for="staff_id">Staff</label>
                    <select class="form-select {{ $errors->has('staff_id') ? 'is-invalid' : '' }}" id="staff_id"
                        name="staff_id">
                        <option value="">Sila pilih Staf</option>
                        @foreach ($staffs as $staff)
                            <option value="{{ $staff->id }}"
                                {{ old('staff_id', $currentStaffId) == $currentStaffId ? 'selected' : '' }}>
                                {{ $staff->name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('staff_id'))
                        <div class="invalid-feedback">Sila pilih Staf</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="table_id" class="form-label">Pilih No. Meja</label>
                    <select class="form-select {{ $errors->has('table_id') ? 'is-invalid' : '' }}" id="table_id"
                        name="table_id">
                        <option value="">Sila pilih No. Meja</option>
                        @foreach ($tables as $table)
                            <option value="{{ $table->id }}"
                                {{ old('table_id', $booking->table_id) == $table->id ? 'selected' : '' }}>
                                {{ $table->table_no }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('table_id'))
                        <div class="invalid-feedback">Sila pilih No. Meja</div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Kemas Kini</button>
            </form>
        </div>
    </div>
    <!-- End Page Wrapper -->
@endsection
