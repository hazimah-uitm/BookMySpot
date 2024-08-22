@extends('layouts.app')

@section('content')
<!--wrapper-->
<div class="wrapper-main">
    <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="text-center">
                <!-- Banner Container -->
                <div class="d-flex align-items-center justify-content-center flex-column flex-md-row mb-4 position-relative">
                    <div class="banner-container">
                        <img src="{{ asset('assets/images/banner.png') }}" class="banner-main img-fluid rounded" alt="banner">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <form action="{{ route('staff.booking.check') }}" method="POST" class="d-flex">
                        {{ csrf_field() }}
                        <div class="form-group flex-grow-1 me-2">
                            <input type="number" class="form-control custom-placeholder"
                                id="no_pekerja" name="no_pekerja" placeholder="Sila masukkan No. Pekerja"
                                value="{{ old('no_pekerja') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Semak</button>
                    </form>

                    @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first('no_pekerja') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!--end wrapper-->
@endsection