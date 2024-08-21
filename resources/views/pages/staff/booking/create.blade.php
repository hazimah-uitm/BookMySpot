@extends('layouts.app')

@section('content')
    <!--wrapper-->
    <div class="wrapper-main">
        <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <h1 class="text-center text-white mb-4">Tempahan Meja</h1>
                        <div class="card bg-light text-dark">
                            <div class="card-body">
                                <form action="{{ route('staff.booking.store') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-group mb-3">
                                        <label for="table_id" class="form-label">Sila pilih No. Meja</label>
                                        <select name="table_id" id="table_id" class="form-control">
                                            @foreach($tables as $table)
                                                <option value="{{ $table->id }}">{{ $table->table_no }} ({{ $table->available_seat }} seats available)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="hidden" name="staff_id" value="{{ $staff->id }}">
                                    <button type="submit" class="btn btn-primary w-100">Book</button>
                                </form>

                                @if ($errors->any())
                                    <div class="alert alert-danger mt-3">
                                        {{ $errors->first('table_id') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end wrapper-->
@endsection
