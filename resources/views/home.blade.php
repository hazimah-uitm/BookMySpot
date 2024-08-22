@extends('layouts.master')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-12">
            <div class="card bg-light text-dark shadow-sm">
                <div class="card-body">
                    <!-- Layout Plan Accordion -->
                    <div class="mt-4">
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
                    </div>

                    <!-- Hall Layout -->
                    <div class="hall-layout position-relative text-center mt-4">
                        <!-- Stage -->
                        <div class="stage bg-dark text-white text-center mb-4">Pentas</div>
                        <!-- Tables -->
                        <div class="row justify-content-center mt-4">
                            @foreach ($tableList as $table)
                            <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center mb-4">
                                <div class="table-round p-3 
                                    @if ($table->available_seat > 0) bg-success
                                    @else bg-secondary text-light @endif"
                                    id="table-container-{{ $table->id }}">
                                    <div>
                                        <label class="text-dark">
                                            <strong>{{ $table->table_no }}</strong>
                                        </label>
                                    </div>
                                    <div class="table-info">
                                        <p>{{ $table->available_seat }} kerusi kosong</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <hr />

                    <!-- Booking Table -->
                    <div class="table-responsive mt-4">
                    <h4 class="mb-1 text-center text-uppercase">Senarai Tempahan</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No Meja</th>
                                    <th>Jumlah Kerusi</th>
                                    <th>Kerusi Kosong</th>
                                    <th>Tempahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tables as $table)
                                <tr>
                                    <td>{{ $table->table_no }}</td>
                                    <td>{{ $table->total_seat }}</td>
                                    <td>{{ $table->available_seat }}</td>
                                    <td>
                                        @forelse($table->booking as $book)
                                            <p>{{ $book->staff->name }}</p>
                                        @empty
                                            <p>Tiada tempahan.</p>
                                        @endforelse
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Pagination and Per-Page Controls -->
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <span class="me-2">Jumlah rekod per halaman:</span>
                                <form action="{{ request()->url() }}" method="GET" id="perPageForm" class="d-flex align-items-center">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <select name="perPage" id="perPage" class="form-select form-select-sm" onchange="document.getElementById('perPageForm').submit()">
                                        <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10</option>
                                        <option value="20" {{ request('perPage') == '20' ? 'selected' : '' }}>20</option>
                                        <option value="30" {{ request('perPage') == '30' ? 'selected' : '' }}>30</option>
                                    </select>
                                </form>
                            </div>

                            <div class="d-flex justify-content-end align-items-center">
                                <span class="mx-2 small text-muted">
                                    Menunjukkan {{ $tables->firstItem() }} hingga {{ $tables->lastItem() }} daripada {{ $tables->total() }} rekod
                                </span>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        {{ $tables->appends(['search' => request('search'), 'perPage' => request('perPage')])->links('pagination::bootstrap-4') }}
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
