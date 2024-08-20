@extends('layouts.master')
@section('content')
<div class="container-fluid mb-3">
    <div class="row">
        <div class="col">
            <div class="text-center">
                <!-- Banner Container -->
                <div
                    class="d-flex align-items-center justify-content-center flex-column flex-md-row mb-4 position-relative">
                    <div class="banner-overlay position-absolute top-0 start-0 w-100 h-100"></div>
                    <img src="{{ asset('assets/images/banner.png') }}" class="banner-main img-fluid shadow-lg rounded"
                        alt="banner" style="z-index: 1;">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection