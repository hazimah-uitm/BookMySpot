<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Staff;
use App\Models\Table;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
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
            'no_pekerja' => 'required|exists:staff,no_pekerja',
        ], [
            'no_pekerja.required' => 'Mohon isi No. Pekerja.',
            'no_pekerja.exists' => 'Harap maaf. Anda tiada dalam senarai pengesahan RSVP.',
        ]);

        $staff = Staff::where('no_pekerja', $request->input('no_pekerja'))->firstOrFail();

        if ($staff->attendance === 'Hadir' && $staff->status === 'Belum Tempah') {
            $tables = Table::orderBy('table_no', 'asc')->where('type', 'Terbuka')->get(); // Fetch all tables
            return view('pages.staff.booking.create', [
                'staff' => $staff,
                'tables' => $tables,
            ]);
        }

        if ($staff->attendance === 'Hadir' && $staff->status === 'Selesai Tempah') {
            $booking = Booking::where('staff_id', $staff->id)->first();
            if (!$booking) {
                return redirect()->back()->withErrors(['no_pekerja' => 'Tiada tempahan untuk No. Pekerja tersebut.'])->withInput();
            }

            $tables = Table::orderBy('table_no', 'asc')->where('type', 'Terbuka')->get();
            return view('pages.staff.booking.ticket', [
                'booking' => $booking,
                'tables' => $tables,
            ]);
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
    
        // Stream the PDF to the browser
        return $dompdf->stream('Tiket-' . $booking->no_pekerja . '.pdf', [
            'Attachment' => 0
        ]);
    }  

    protected function imageToBase64($imagePath)
    {
        $imageData = file_get_contents($imagePath);
        $base64 = base64_encode($imageData);
        $mimeType = mime_content_type($imagePath);
        return 'data:' . $mimeType . ';base64,' . $base64;
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

        $booking = new Booking();
        $booking->booking_no = $this->generateBookingNumber();
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


    protected function generateBookingNumber()
    {
        $latestBooking = Booking::orderBy('id', 'desc')->first();
        $number = 1;

        if ($latestBooking) {
            $latestNumber = (int) str_replace('MG-', '', $latestBooking->booking_no);
            $number = $latestNumber + 1;
        }

        return 'MG-' . str_pad($number, 4, '0', STR_PAD_LEFT);
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
