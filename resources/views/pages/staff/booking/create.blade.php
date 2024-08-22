@extends('layouts.app')

@section('content')
<!--wrapper-->
<div class="wrapper-main">
    <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-9">
                    <h2 class="text-center text-uppercase mb-4">Tempahan Meja</h2>
                    <div class="card bg-light text-dark">
                        <div class="card-body">
                            <!-- Staff Details -->
                            <form action="{{ route('staff.booking.store') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="mt-3">
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
                                        <!-- Layout Plan Accordion -->
                                        <div class="accordion" id="layoutAccordion">
                                            <div class="accordion-item">
                                                <h4 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button text-uppercase" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLayout" aria-expanded="true" aria-controls="collapseLayout">
                                                        Paparan Pelan Meja Sebenar
                                                    </button>
                                                </h4>
                                                <div id="collapseLayout" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#layoutAccordion">
                                                    <div class="accordion-body">
                                                        <img src="{{ asset('assets/images/layout.jpg') }}" alt="Pelan Meja" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Hall Layout -->
                                        <div class="hall-layout position-relative text-center mt-4">
                                            <!-- Stage -->
                                            <div class="stage bg-dark text-white text-center mb-4">Pentas</div>
                                            <!-- Tables -->
                                            <div class="row justify-content-center mt-4">
                                                @foreach ($tables as $table)
                                                <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center mb-4">
                                                    <div class="table-round p-3 
                                                        @if ($table->available_seat > 0) bg-success
                                                        @else bg-secondary text-light @endif"
                                                        id="table-container-{{ $table->id }}">

                                                        @if ($table->available_seat > 0)
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <input type="radio" name="table_id"
                                                                id="table_{{ $table->id }}"
                                                                value="{{ $table->id }}" class="table-radio me-2">
                                                            <label for="table_{{ $table->id }}" class="text-dark">
                                                                <strong>{{ $table->table_no }}</strong>
                                                            </label>
                                                        </div>
                                                        @else
                                                        <div>
                                                            <label for="table_{{ $table->id }}" class="text-dark">
                                                                <strong>{{ $table->table_no }}</strong>
                                                            </label>
                                                        </div>
                                                        @endif

                                                        <div class="table-info">
                                                            <p>{{ $table->available_seat }} kerusi kosong</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 mt-4">Tempah</button>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('.table-radio');
        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                // Remove 'selected' class from all table containers
                document.querySelectorAll('.table-round').forEach(container => {
                    container.classList.remove('selected');
                });

                // Add 'selected' class to the container of the selected radio button
                const selectedTable = document.getElementById('table-container-' + this.value);
                if (selectedTable) {
                    selectedTable.classList.add('selected');
                }
            });
        });
    });
</script>
@endsection