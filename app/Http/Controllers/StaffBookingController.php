<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Staff;
use App\Models\Table;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
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
    
        // Check if the staff's attendance is 'Hadir' and status is 'Pending'
        if ($staff->attendance === 'Hadir' && $staff->status === 'Pending') {
            $tables = Table::get();
            return view('pages.staff.booking.create', [
                'staff' => $staff,
                'tables' => $tables,
            ]);
        }
        
        // Check if the staff's attendance is 'Hadir' and status is 'Booked'
        if ($staff->attendance === 'Hadir' && $staff->status === 'Booked') {
            $booking = Booking::where('staff_id', $staff->id)->first();
            if (!$booking) {
                return redirect()->back()->withErrors(['no_pekerja' => 'Tiada tempahan untuk No. Pekerja tersebut.'])->withInput();
            }
    
            return view('pages.staff.booking.ticket', [
                'booking' => $booking,
            ]);
        }
    
        // Handle all other cases where the staff cannot book or print
        return redirect()->back()->withErrors(['no_pekerja' => 'Harap maaf. Status kehadiran RSVP anda adalah tidak hadir.'])->withInput();
    }    
    
    
    public function printTicket($id)
    {
        // Fetch the booking from the database
        $booking = Booking::findOrFail($id);

        // Initialize Dompdf
        $dompdf = new Dompdf();

        // Load the view and pass the booking data
        $view = view('pages.staff.booking.ticket_pdf', compact('booking'))->render();

        // Load HTML content into Dompdf
        $dompdf->loadHtml($view);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the PDF
        $dompdf->render();

        // Stream the PDF to the browser
        return $dompdf->stream('Tiket-' . $booking->booking_no . '.pdf', [
            'Attachment' => 0 // 0 to view in browser, 1 to download
        ]);
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
            return redirect()->back()->withErrors(['table_id' => 'No seats available for this table'])->withInput();
        }
    
        $booking = new Booking();
        $booking->booking_no = $this->generateBookingNumber();
        $booking->staff_id = $request->input('staff_id');
        $booking->table_id = $request->input('table_id');
    
        $booking->save();
    
        $table->available_seat -= 1;
        $table->status = $table->available_seat > 0 ? 'Available' : 'Booked';
        $table->save();
    
        $staff = Staff::findOrFail($request->input('staff_id'));
        $staff->status = 'Booked';
        $staff->save();
    
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
        return view('pages.staff.booking.ticket', [
            'booking' => $booking,
        ]);
    }
}
