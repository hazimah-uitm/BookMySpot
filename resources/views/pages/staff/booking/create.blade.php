@extends('layouts.app')

@section('content')
    <!--wrapper-->
    <div class="wrapper-main">
        <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <h1 class="text-center text-white mb-4">Tempahan Meja</h1>
                        <div class="card bg-light text-dark">
                            <div class="card-body">
                                <!-- Staff Details -->
                                <form action="{{ route('staff.booking.store') }}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="mt-4">
                                        <table class="table table-borderless">
                                            <tbody>
                                                <tr>
                                                    <th class="text-uppercase">Nama</th>
                                                    <td class="text-uppercase">{{ $staff->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="text-uppercase">No. Pekerja</th>
                                                    <td class="text-uppercase">{{ $staff->no_pekerja }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="staff_id" value="{{ $staff->id }}">
                                        <div class="mt-4">
                                            <!-- Hall Layout -->
                                            <div class="hall-layout position-relative">
                                                <button type="submit" class="btn btn-primary w-100 mb-3">Tempah</button>
                                                <!-- Stage -->
                                                <div class="stage bg-dark text-white text-center">Stage</div>
                                                <!-- Tables -->
                                                <div class="row justify-content-center mt-4">
                                                    @foreach ($tables as $table)
                                                        <div class="col-4 col-md-3 text-center mb-4">
                                                            <div
                                                                class="table-round p-3 
                                                            @if ($table->available_seat > 0) bg-info 
                                                            @else bg-secondary @endif text-white">
                                                                <div class="table-info">
                                                                    <p><strong>Meja {{ $table->table_no }}</strong></p>
                                                                    <p>{{ $table->available_seat }} kerusi tersedia</p>
                                                                    <ul class="list-unstyled">
                                                                        @foreach ($table->booking as $book)
                                                                            <li>{{ $book->staff->name }}</li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                                @if ($table->available_seat > 0)
                                                                    <div>
                                                                        <input type="radio" name="table_id"
                                                                            id="table_{{ $table->id }}"
                                                                            value="{{ $table->id }}">
                                                                        <label
                                                                            for="table_{{ $table->id }}">Pilih</label>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Door -->
                                                <div class="door bg-dark text-white text-center">Door</div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 mt-3">Tempah</button>
                                    </div>
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

@push('styles')
    <style>
        .hall-layout {
            position: relative;
            padding: 20px;
        }

        .stage,
        .door {
            width: 100%;
            padding: 10px 0;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .stage {
            border-radius: 10px;
        }

        .door {
            margin-top: 20px;
            border-radius: 10px;
        }

        .table-round {
            border-radius: 50%;
            height: 150px;
            width: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 2px solid white;
            cursor: pointer;
        }

        .table-round.bg-secondary {
            background-color: gray;
            cursor: not-allowed;
        }

        .table-round input {
            display: none;
        }

        .table-round input:checked+label {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
    </style>
@endpush
