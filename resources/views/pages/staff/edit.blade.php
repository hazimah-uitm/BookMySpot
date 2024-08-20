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
                <label for="name" class="form-label">Nama Pertama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    name="name" value="{{ old('name') ?? ($staff->name ?? '') }}">
                @if ($errors->has('name'))
                <div class="invalid-feedback">Sila isi Nama Penuh</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="no_pekerja" class="form-label">No. Pekerja</label>
                <input type="number" class="form-control @error('no_pekerja') is-invalid @enderror" id="no_pekerja"
                    name="no_pekerja" value="{{ old('no_pekerja') ?? ($staff->no_pekerja ?? '') }}">
                @if ($errors->has('no_pekerja'))
                <div class="invalid-feedback">Sila isi No. Pekerja</div>
                @endif
            </div>


            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" value="{{ old('email') ?? ($staff->email ?? '') }}">
                 @if ($errors->has('email'))
                    <div class="invalid-feedback">Sila isi Email</div>
                @endif
            </div>

            <!-- Kehadiran -->
            <div class="mb-3">
                <label for="attendance" class="form-label">Kehadiran</label>
                <select class="form-control @error('attendance') is-invalid @enderror" id="attendance" name="attendance">
                    <option value="Hadir" {{ (old('attendance') ?? ($staff->attendance ?? '')) == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="Tidak Hadir" {{ (old('attendance') ?? ($staff->attendance ?? '')) == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                </select>
                 @if ($errors->has('attendance'))
                    <div class="invalid-feedback">Sila pilih Kehadiran</div>
                @endif
            </div>

            <!-- Kategori -->
            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                    <option value="Staf Akademik" {{ (old('category') ?? ($staff->category ?? '')) == 'Staf Akademik' ? 'selected' : '' }}>Staf Akademik</option>
                    <option value="Staf Pentadbiran" {{ (old('category') ?? ($staff->category ?? '')) == 'Staf Pentadbiran' ? 'selected' : '' }}>Staf Pentadbiran</option>
                </select>
                 @if ($errors->has('category'))
                    <div class="invalid-feedback">Sila pilih Kategori</div>
                @endif
            </div>

            <!-- Jabatan -->
            <div class="mb-3">
                <label for="department" class="form-label">Jabatan</label>
                <input type="text" class="form-control @error('department') is-invalid @enderror" id="department"
                    name="department" value="{{ old('department') ?? ($staff->department ?? '') }}">
                 @if ($errors->has('department'))
                    <div class="invalid-feedback">Sila isi Jabatan</div>
                @endif
            </div>

            <!-- Kampus -->
            <div class="mb-3">
                <label for="campus" class="form-label">Kampus</label>
                <input type="text" class="form-control @error('campus') is-invalid @enderror" id="campus"
                    name="campus" value="{{ old('campus') ?? ($staff->campus ?? '') }}">
                 @if ($errors->has('campus'))
                    <div class="invalid-feedback">Sila isi Kampus</div>
                @endif
            </div>

            <!-- Kelab -->
            <div class="mb-3">
                <label for="club" class="form-label">Kelab</label>
                <select class="form-control @error('club') is-invalid @enderror" id="club" name="club">
                    <option value="Ahli KEKiTA" {{ (old('club') ?? ($staff->club ?? '')) == 'Ahli KEKiTA' ? 'selected' : '' }}>Ahli KEKiTA</option>
                    <option value="Ahli PEWANI" {{ (old('club') ?? ($staff->club ?? '')) == 'Ahli PEWANI' ? 'selected' : '' }}>Ahli PEWANI</option>
                    <option value="Bukan Ahli (Bayaran RM20 dikenakan)" {{ (old('club') ?? ($staff->club ?? '')) == 'Bukan Ahli (Bayaran RM20 dikenakan)' ? 'selected' : '' }}>Bukan Ahli (Bayaran RM20 dikenakan)</option>
                </select>
                 @if ($errors->has('club'))
                    <div class="invalid-feedback">Sila pilih Kelab</div>
                @endif
            </div>

            <!-- Pembayaran -->
            <div class="mb-3">
                <label for="payment" class="form-label">Pembayaran</label>
                <input type="text" class="form-control @error('payment') is-invalid @enderror" id="payment"
                    name="payment" value="{{ old('payment') ?? ($staff->payment ?? '') }}">
                 @if ($errors->has('payment'))
                    <div class="invalid-feedback">Sila isi Pembayaran</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <div class="form-check">
                    <input type="radio" id="pending" name="status" value="Pending"
                        {{ ($staff->status ?? '') == 'Pending' ? 'checked' : '' }}>
                    <label class="form-check-label" for="pending">Pending</label>
                </div>
                <div class="form-check">
                    <input type="radio" id="booked" name="status" value="Booked"
                        {{ ($staff->status ?? '') == 'Booked' ? 'checked' : '' }}>
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