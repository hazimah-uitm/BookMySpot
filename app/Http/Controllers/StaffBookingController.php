<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Staff;
use App\Models\Table;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StaffBookingController extends Controller
{
    public function showForm()
    {
        return view('welcome');
    }

    public function checkStaffId(Request $request)
    {
        $request->validate([
            'no_pekerja' => 'required',
        ], [
            'no_pekerja.required' => 'Mohon isi No. Pekerja.',
        ]);

        // Check if the staff exists and is not deleted
        $staff = Staff::whereNull('deleted_at')
            ->where('no_pekerja', $request->input('no_pekerja'))
            ->first();

        if (!$staff) {
            return redirect()->back()->withErrors(['no_pekerja' => 'Harap maaf. Anda tiada dalam senarai pengesahan RSVP.'])->withInput();
        }

        if ($staff->attendance === 'Hadir' && $staff->status === 'Belum Tempah') {
            // Fetch all non-deleted tables
            $tables = Table::whereNull('deleted_at')
                ->orderBy('table_no', 'asc')
                ->where('type', 'Terbuka')
                ->get();

            return view('pages.staff.booking.create', [
                'staff' => $staff,
                'tables' => $tables,
            ]);
        }

        if ($staff->attendance === 'Hadir' && $staff->status === 'Selesai Tempah') {
            // Fetch the booking for the staff and ensure it's not deleted
            $booking = Booking::whereNull('deleted_at')
                ->where('staff_id', $staff->id)
                ->first();

            if (!$booking) {
                return redirect()->back()->withErrors(['no_pekerja' => 'Tiada tempahan untuk No. Pekerja tersebut.'])->withInput();
            }

            // Fetch all non-deleted tables
            $tables = Table::whereNull('deleted_at')
                ->orderBy('table_no', 'asc')
                ->where('type', 'Terbuka')
                ->get();

            // Add a success message
            return view('pages.staff.booking.ticket', [
                'booking' => $booking,
                'tables' => $tables,
            ])->with('success', 'Tempahan anda telah berjaya disahkan.');
        }

        return redirect()->back()->withErrors(['no_pekerja' => 'Harap maaf. Status kehadiran RSVP anda adalah tidak hadir.'])->withInput();
    }


    public function printTicket($id)
    {
        // Fetch the booking from the database
        $booking = Booking::findOrFail($id);

        // Convert the logo image to Base64
        $logoBase64 = $this->imageToBase64(public_path('assets/images/logo-malam-gala.png'));

        // Generate QR code if it doesn't exist
        if (empty($booking->qr_code)) {
            $qrCode = QrCode::size(250)
                ->margin(0)
                ->generate($booking->staff->id);
            $booking->qr_code = $qrCode;
            $booking->save();
        }

        // Load the view and pass the booking data
        $view = view('pages.staff.booking.ticket_pdf', compact('booking', 'logoBase64'))->render();

        // Initialize Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper([0, 0, 650, 690]);
        $dompdf->render();

        // Force a download of the PDF
        return $dompdf->stream('Tiket-' . $booking->staff->no_pekerja . '.pdf', [
            'Attachment' => 1
        ]);
    }

    protected function imageToBase64($imagePath)
    {
        $imageData = file_get_contents($imagePath);
        $base64 = base64_encode($imageData);
        $mimeType = mime_content_type($imagePath);
        return 'data:' . $mimeType . ';base64,' . $base64;
    }

    protected function generateBookingNumber()
    {
        $latestBooking = Booking::withTrashed()
            ->orderBy('id', 'desc')
            ->first();

        $number = 1;

        if ($latestBooking) {
            $latestNumber = (int) str_replace('MG-', '', $latestBooking->booking_no);
            $number = $latestNumber + 1;
        }

        return 'MG-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'table_id' => 'required|exists:tables,id',
        ], [
            'table_id.required' => 'Sila pilih meja untuk tempahan.',
            'table_id.exists' => 'Meja yang dipilih tidak wujud.',
        ]);

        $table = Table::findOrFail($request->input('table_id'));

        if ($table->available_seat <= 0) {
            return redirect()->back()->withErrors(['table_id' => 'Tiada kekosongan bagi meja ini'])->withInput();
        }

        $existingBooking = Booking::where('staff_id', $request->input('staff_id'))->whereNull('deleted_at')->first();

        if ($existingBooking) {
            return redirect()->back()->withErrors(['staff_id' => 'Anda sudah mempunyai tempahan.'])->withInput();
        }

        // Generate booking number
        $bookingNumber = $this->generateBookingNumber();

        // Check for existing booking_no
        while (Booking::where('booking_no', $bookingNumber)->exists()) {
            $bookingNumber = $this->generateBookingNumber();
        }

        $booking = new Booking();
        $booking->booking_no = $bookingNumber;
        $booking->staff_id = $request->input('staff_id');
        $booking->table_id = $request->input('table_id');
        $booking->save();

        // Update table availability
        $table->available_seat -= 1;
        $table->status = $table->available_seat > 0 ? 'Tersedia' : 'Penuh';
        $table->save();

        // Update staff booking status
        $staff = Staff::findOrFail($request->input('staff_id'));
        $staff->status = 'Selesai Tempah';
        $staff->save();

        // Generate QR Code and store it as Base64
        $qrCode = QrCode::format('png')
            ->size(250)
            ->margin(0)
            ->generate($staff->no_pekerja);
        $qrCodeDataUri = 'data:image/png;base64,' . base64_encode($qrCode);
        $booking->qr_code = $qrCodeDataUri;
        $booking->save();

        return redirect()->route('staff.booking.view', ['id' => $booking->id])->with('success', 'Tempahan berjaya dihantar!');
    }


    public function show($id)
    {
        $booking = Booking::findOrFail($id);

        // Check if the QR code exists, and generate it if not
        if (empty($booking->qr_code)) {
            $qrCode = QrCode::size(250)
                ->margin(0)
                ->generate($booking->staff->id);
            $booking->qr_code = $qrCode;
            $booking->save();
        }

        $tables = Table::orderBy('table_no', 'asc')->where('type', 'Terbuka')->get();

        return view('pages.staff.booking.ticket', [
            'booking' => $booking,
            'tables' => $tables,
        ]);
    }
}
