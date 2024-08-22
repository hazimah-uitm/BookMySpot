<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Staff;
use App\Models\Table;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $bookingList = Booking::orderBy('booking_no', 'asc')->paginate($perPage);

        return view('pages.booking.index', [
            'bookingList' => $bookingList,
            'perPage' => $perPage,
        ]);
    }

    public function create()
    {
        $staffs = Staff::where('attendance', 'Hadir')
            ->where('status', 'Pending')
            ->get();

        $tables = Table::all();
        return view('pages.booking.create', [
            'save_route' => route('booking.store'),
            'str_mode' => 'Tambah',
            'tables' => $tables,
            'staffs' => $staffs,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'table_id' => 'required|exists:tables,id',
        ]);

        $table = Table::findOrFail($request->input('table_id'));

        // Ensure there are available seats
        if ($table->available_seat <= 0) {
            return redirect()->back()->withErrors(['table_id' => 'No seats available for this table'])->withInput();
        }

        $booking = new Booking();
        $booking->booking_no = $this->generateBookingNumber();
        $booking->staff_id = $request->input('staff_id');
        $booking->table_id = $request->input('table_id');

        $booking->save();

        // Update the table's available seats
        $table->available_seat -= 1;
        $table->status = $table->available_seat > 0 ? 'Available' : 'Booked'; // Update status if no seats are available
        $table->save();

        // Update staff status to 'Booked'
        $staff = Staff::findOrFail($request->input('staff_id'));
        $staff->status = 'Booked';
        $staff->save();

        return redirect()->route('booking')->with('success', 'Tempahan berjaya disimpan');
    }

    public function show($id)
    {
        $booking = Booking::findOrFail($id);

        return view('pages.booking.view', [
            'booking' => $booking,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $currentStaffId = $booking->staff_id; 
    
        $staffs = Staff::where('attendance', 'Hadir')
            ->where('status', 'Pending')
            ->where('id', '!=', $currentStaffId) 
            ->get();
    
        $tables = Table::where('status', 'available')->get();
    
        return view('pages.booking.edit', [
            'save_route' => route('booking.update', $id),
            'str_mode' => 'Kemas Kini',
            'booking' => $booking,
            'tables' => $tables,
            'staffs' => $staffs,
            'currentStaffId' => $currentStaffId, 
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'table_id' => 'required|exists:tables,id',
        ]);

        $booking = Booking::findOrFail($id);

        // Retrieve old and new table information
        $oldTable = Table::findOrFail($booking->table_id);
        $newTable = Table::findOrFail($request->input('table_id'));

        // Update booking details
        $booking->staff_id = $request->input('staff_id');
        $booking->table_id = $request->input('table_id');
        $booking->save();

        // Update old table's available seats
        $oldTable->available_seat += 1; // Restore seat
        $oldTable->status = 'Available'; // Ensure status reflects available seats
        $oldTable->save();

        // Update new table's available seats
        if ($newTable->available_seat <= 0) {
            return redirect()->back()->withErrors(['table_id' => 'No seats available for this table'])->withInput();
        }
        $newTable->available_seat -= 1; // Deduct seat
        $newTable->status = $newTable->available_seat > 0 ? 'Available' : 'Booked'; // Update status if no seats are available
        $newTable->save();

        // Update staff status to 'Booked'
        $staff = Staff::findOrFail($request->input('staff_id'));
        $staff->status = 'Booked';
        $staff->save();

        return redirect()->route('booking')->with('success', 'Tempahan berjaya dikemaskini');
    }



    public function search(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10); // Default to 10 if not provided

        if ($search) {
            $bookingList = Booking::where('booking_no', 'LIKE', "%$search%")
                ->latest()
                ->paginate($perPage);
        } else {
            $bookingList = Booking::latest()->paginate($perPage);
        }

        return view('pages.booking.index', [
            'bookingList' => $bookingList,
            'perPage' => $perPage,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->delete();

        return redirect()->route('booking')->with('success', 'Tempahan berjaya dihapuskan');
    }

    public function trashList()
    {
        $trashList = Booking::onlyTrashed()->latest()->paginate(10);

        return view('pages.booking.trash', [
            'trashList' => $trashList,
        ]);
    }

    public function restore($id)
    {
        Booking::withTrashed()->where('id', $id)->restore();

        return redirect()->route('booking')->with('success', 'Tempahan berjaya dikembalikan');
    }

    public function forceDelete($id)
    {
        $booking = Booking::withTrashed()->findOrFail($id);

        $booking->forceDelete();

        return redirect()->route('booking.trash')->with('success', 'Tempahan berjaya dihapuskan sepenuhnya');
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
}
