@extends('layouts.master')

@section('content')
<!-- Breadcrumb -->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Pengurusan Meja</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i class="bx bx-home-alt"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('table') }}">Senarai Meja</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $str_mode }} Meja</li>
            </ol>
        </nav>
    </div>
</div>
<!-- End Breadcrumb -->

<h6 class="mb-0 text-uppercase">{{ $str_mode }} Meja</h6>
<hr />

<div class="card">
    <div class="card-body">

        <form method="POST" action="{{ $save_route }}">
            {{ csrf_field() }}

            <div class="mb-3">
                <label for="table_no" class="form-label">No. Meja</label>
                <input type="text" class="form-control {{ $errors->has('table_no') ? 'is-invalid' : '' }}" id="table_no"
                    name="table_no" value="{{ old('table_no') }}">
                @if ($errors->has('table_no'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('table_no') as $error)
                    {{ $error }}
                    @endforeach
                </div>
                @endif
            </div>


            <div class="mb-3">
                <label for="total_seat" class="form-label">Jumlah Tempat Duduk</label>
                <input type="number" class="form-control {{ $errors->has('total_seat') ? 'is-invalid' : '' }}" id="total_seat"
                    name="total_seat" value="{{ old('total_seat') }}">
                @if ($errors->has('total_seat'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('total_seat') as $error)
                    {{ $error }}
                    @endforeach
                </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="available_seat" class="form-label">Jumlah Tempat Duduk Kosong</label>
                <input type="number" class="form-control {{ $errors->has('available_seat') ? 'is-invalid' : '' }}" id="available_seat"
                    name="available_seat" value="{{ old('available_seat') }}">
                @if ($errors->has('available_seat'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('available_seat') as $error)
                    {{ $error }}
                    @endforeach
                </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Jenis Meja</label>
                <div class="form-check">
                    <input type="radio" id="Ditempah" name="type" value="Ditempah"
                        {{ old('type') == 'Ditempah' ? 'checked' : '' }}
                        required>
                    <label class="form-check-label" for="Ditempah">Ditempah</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="Terbuka" name="type" value="Terbuka"
                        {{ old('type') == 'Terbuka' ? 'checked' : '' }}
                        required>
                    <label class="form-check-label" for="Terbuka">Terbuka</label>
                </div>
                @if ($errors->has('type'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('type') as $error)
                    {{ $error }}
                    @endforeach
                </div>
                @endif
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <div class="form-check">
                    <input type="radio" id="available" name="status" value="Available"
                        {{ old('status') == 'Available' ? 'checked' : '' }}
                        required>
                    <label class="form-check-label" for="available">Available</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="booked" name="status" value="Booked"
                        {{ old('status') == 'Booked' ? 'checked' : '' }}
                        required>
                    <label class="form-check-label" for="booked">Booked</label>
                </div>
                @if ($errors->has('status'))
                <div class="invalid-feedback">
                    @foreach ($errors->get('status') as $error)
                    {{ $error }}
                    @endforeach
                </div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">{{ $str_mode }}</button>
        </form>
    </div>
</div>
<!-- End Page Wrapper -->
@endsection