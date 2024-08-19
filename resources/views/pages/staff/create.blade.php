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
                    <li class="breadcrumb-item active" aria-current="page">{{ $str_mode }} Staf</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <h6 class="mb-0 text-uppercase">{{ $str_mode }} Staf</h6>
    <hr />

    <div class="card">
        <div class="card-body">

            <form method="POST" action="{{ $save_route }}">
                {{ csrf_field() }}

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Penuh</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                        name="name" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">Sila isi Nama Penuh</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="staff_id" class="form-label">No. Pekerja</label>
                    <input type="number" class="form-control {{ $errors->has('staff_id') ? 'is-invalid' : '' }}" id="staff_id"
                        name="staff_id" value="{{ old('staff_id') }}">
                    @if ($errors->has('staff_id'))
                        <div class="invalid-feedback">Sila isi No. Pekerja</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <div class="form-check">
                        <input type="radio" id="pending" name="status" value="Pending"
                            {{ old('status', $staff->status ?? '') == 'Pending' ? 'checked' : '' }}
                            required>
                        <label class="form-check-label" for="pending">Pending</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="booked" name="status" value="Booked"
                            {{ old('status', $staff->status ?? '') == 'Booked' ? 'checked' : '' }}
                            required>
                        <label class="form-check-label" for="booked">Booked</label>
                    </div>
                    @if ($errors->has('status'))
                        <div class="invalid-feedback d-block">Sila pilih Status Staf</div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">{{ $str_mode }}</button>
            </form>
        </div>
    </div>
    <!-- End Page Wrapper -->
@endsection
