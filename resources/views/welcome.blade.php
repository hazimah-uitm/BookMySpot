@extends('layouts.app')

@section('content')
    <!--wrapper-->
    <div class="wrapper-main">
        <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="text-center">
                    <!-- Banner Container -->
                    <div
                        class="d-flex align-items-center justify-content-center flex-column flex-md-row mb-4 position-relative">
                        <div class="banner-overlay position-absolute top-0 start-0 w-100 h-100"></div>
                        <img src="{{ asset('assets/images/banner.png') }}" class="banner-main img-fluid shadow-lg rounded"
                            alt="banner" style="z-index: 1;">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <!-- Form Container -->
                        <form action="" method="POST" class="d-flex">
                            {{ csrf_field() }}
                            <div class="form-group flex-grow-1 me-2">
                                <input type="text" class="form-control border-white text-white bg-transparent"
                                    id="staff_id" name="staff_id" placeholder="Sila masukkan No. Pekerja">
                            </div>
                            <button type="submit" class="btn btn-outline-light">Semak</button>
                        </form>

                        <!-- Alert Messages -->
                        @if (isset($exists))
                            <div class="mt-3">
                                @if ($exists)
                                    <div class="alert alert-success">Staff ID exists.</div>
                                @else
                                    <div class="alert alert-danger">Staff ID does not exist.</div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end wrapper-->
@endsection
