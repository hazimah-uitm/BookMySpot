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
            <form method="POST" action="{{ $save_route }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Penuh</label>
                    <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                        name="name" value="{{ old('name', $staff->name ?? '') }}">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('name') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="no_pekerja" class="form-label">No. Pekerja</label>
                    <input type="string" class="form-control {{ $errors->has('no_pekerja') ? 'is-invalid' : '' }}"
                        id="no_pekerja" name="no_pekerja" value="{{ old('no_pekerja', $staff->no_pekerja ?? '') }}">
                    @if ($errors->has('no_pekerja'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('no_pekerja') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>


                <div class="mb-3">
                    <label class="form-label">Jenis Pengguna</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input {{ $errors->has('type') ? 'is-invalid' : '' }}"
                            id="typeStaf" name="type" value="Staf"
                            {{ old('type', $staff->type ?? '') == 'Staf' ? 'checked' : '' }}>
                        <label class="form-check-label" for="typeStaf">
                            Staf
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input {{ $errors->has('type') ? 'is-invalid' : '' }}"
                            id="typeBukanStaf" name="type" value="Bukan Staf"
                            {{ old('type', $staff->type ?? '') == 'Bukan Staf' ? 'checked' : '' }}>
                        <label class="form-check-label" for="typeBukanStaf">
                            Bukan Staf
                        </label>
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
                    <label class="form-label">Kehadiran</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input {{ $errors->has('attendance') ? 'is-invalid' : '' }}"
                            id="attendancePresent" name="attendance" value="Hadir"
                            {{ old('attendance', $staff->attendance ?? '') == 'Hadir' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="attendancePresent">
                            Hadir
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input {{ $errors->has('attendance') ? 'is-invalid' : '' }}"
                            id="attendanceAbsent" name="attendance" value="Tidak Hadir"
                            {{ old('attendance', $staff->attendance ?? '') == 'Tidak Hadir' ? 'checked' : '' }}>
                        <label class="form-check-label" for="attendanceAbsent">
                            Tidak Hadir
                        </label>
                    </div>
                    @if ($errors->has('attendance'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('attendance') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Emel</label>
                    <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        id="email" name="email" value="{{ old('email', $staff->email ?? '') }}">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('email') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input {{ $errors->has('category') ? 'is-invalid' : '' }}"
                            id="categoryAcademic" name="category" value="Staf Akademik"
                            {{ old('category', $staff->category ?? '') == 'Staf Akademik' ? 'checked' : '' }}>
                        <label class="form-check-label" for="categoryAcademic">
                            Staf Akademik
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input {{ $errors->has('category') ? 'is-invalid' : '' }}"
                            id="categoryAdmin" name="category" value="Staf Pentadbiran"
                            {{ old('category', $staff->category ?? '') == 'Staf Pentadbiran' ? 'checked' : '' }}>
                        <label class="form-check-label" for="categoryAdmin">
                            Staf Pentadbiran
                        </label>
                    </div>
                    @if ($errors->has('category'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('category') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="department" class="form-label">Jabatan</label>
                    <input type="text" class="form-control {{ $errors->has('department') ? 'is-invalid' : '' }}"
                        id="department" name="department" value="{{ old('department', $staff->department ?? '') }}">
                    @if ($errors->has('department'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('department') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="campus" class="form-label">Kampus</label>
                    <select class="form-select {{ $errors->has('campus') ? 'is-invalid' : '' }}" id="campus"
                        name="campus">
                        <option value="" disabled selected>Pilih Kampus</option>
                        <option value="Kampus Samarahan"
                            {{ old('campus', $staff->campus ?? '') == 'Kampus Samarahan' ? 'selected' : '' }}>
                            Kampus Samarahan
                        </option>
                        <option value="Kampus Samarahan 2"
                            {{ old('campus', $staff->campus ?? '') == 'Kampus Samarahan 2' ? 'selected' : '' }}>
                            Kampus Samarahan 2
                        </option>
                        <option value="Kampus Mukah"
                            {{ old('campus', $staff->campus ?? '') == 'Kampus Mukah' ? 'selected' : '' }}>
                            Kampus Mukah
                        </option>
                    </select>
                    @if ($errors->has('campus'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('campus') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="club" class="form-label">Keahlian Kelab</label>
                    <select class="form-select {{ $errors->has('club') ? 'is-invalid' : '' }}" id="club"
                        name="club">
                        <option value="">Pilih Keahlian Kelab</option>
                        <option value="Ahli KEKiTA"
                            {{ old('club', $staff->club ?? '') == 'Ahli KEKiTA' ? 'selected' : '' }}>Ahli KEKiTA</option>
                        <option value="Ahli PEWANI"
                            {{ old('club', $staff->club ?? '') == 'Ahli PEWANI' ? 'selected' : '' }}>Ahli PEWANI</option>
                        <option value="Bukan Ahli (Bayaran RM20 dikenakan)"
                            {{ old('club', $staff->club ?? '') == 'Bukan Ahli (Bayaran RM20 dikenakan)' ? 'selected' : '' }}>
                            Bukan Ahli (Bayaran RM20 dikenakan)</option>
                    </select>
                    @if ($errors->has('club'))
                        <div class="invalid-feedback">
                            @foreach ($errors->get('club') as $error)
                                {{ $error }}
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="payment" class="form-label">Pautan Bayaran</label>
                    <input type="text" class="form-control {{ $errors->has('payment') ? 'is-invalid' : '' }}"
                        id="payment" name="payment" value="{{ old('payment', $staff->payment ?? '') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check">
                        <input type="radio" id="BelumTempah" name="status" value="Belum Tempah"
                            {{ old('status', $staff->$status) === 'Belum Tempah' ? 'checked' : '' }}>
                        <label class="form-check-label" for="BelumTempah">Belum Tempah</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" id="SelesaiTempah" name="status" value="Selesai Tempah"
                            {{ old('status', $staff->$status) === 'Selesai Tempah' ? 'checked' : '' }}>
                        <label class="form-check-label" for="SelesaiTempah">Selesai Tempah</label>
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
