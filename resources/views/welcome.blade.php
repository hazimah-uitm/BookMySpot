@extends('layouts.app')

@section('content')
<!--wrapper-->
<div class="wrapper">
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form action="" method="POST" class="d-flex">
                        {{ csrf_field() }}
                        <div class="form-group flex-grow-1 me-2">
                            <input type="text" class="form-control border-white text-white bg-transparent" id="staff_id" name="staff_id" placeholder="No. Pekerja" required>
                        </div>
                        <button type="submit" class="btn btn-light">Semak</button>
                    </form>

                    @if(isset($exists))
                        <div class="mt-3">
                            @if($exists)
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
