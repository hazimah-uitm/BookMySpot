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
                            <!-- Error message container -->
                            <div id="formErrors" class="alert alert-danger mt-3" style="display: none;"></div>
                            <!-- Staff Details -->
                            <form id="bookingForm" action="{{ route('staff.booking.store') }}" method="POST">
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
                                                        <img src="{{ asset('public/assets/images/layout.jpg') }}" alt="Pelan Meja" class="img-fluid">
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
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Sahkan Tempahan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Anda telah memilih meja <strong><span id="selectedTableNo"></span></strong>. Adakah anda pasti untuk memilih No. Meja ini?</p>
                    <div class="alert alert-info mt-4">
                        <strong>Nota:</strong> Segala tempahan yang telah dihantar tidak boleh dikemaskini.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="confirmBooking" class="btn btn-primary">Hantar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript for handling table selection and confirmation -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('bookingForm');
        const errorsContainer = document.getElementById('formErrors');
        const bookingModal = new bootstrap.Modal(document.getElementById('bookingModal'));
        const selectedTableNo = document.getElementById('selectedTableNo');
        const confirmBookingButton = document.getElementById('confirmBooking');

        form.addEventListener('submit', function(event) {
            const selectedTable = document.querySelector('input[name="table_id"]:checked');

            if (!selectedTable) {
                event.preventDefault(); // Prevent form submission
                errorsContainer.textContent = 'Sila pilih meja untuk tempahan.';
                errorsContainer.style.display = 'block';

                // Scroll to the top of the page
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // Smooth scrolling effect
                });
            } else {
                errorsContainer.style.display = 'none'; // Hide errors if valid
                selectedTableNo.textContent = selectedTable.nextElementSibling.textContent; // Display selected table number
                bookingModal.show(); // Show confirmation modal
                event.preventDefault(); // Prevent form submission until confirmation
            }
        });

        confirmBookingButton.addEventListener('click', function() {
            form.submit(); // Submit the form
        });

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

                // Trigger the form submission process
                form.dispatchEvent(new Event('submit'));
            });
        });
    });
</script>
@endsection