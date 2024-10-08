<?php

namespace App\Http\Controllers;

use App\Exports\BookingExport;
use App\Models\Booking;
use App\Models\Staff;
use App\Models\Table;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $bookingList = Booking::orderBy('table_id', 'asc')->paginate($perPage);

        return view('pages.booking.index', [
            'bookingList' => $bookingList,
            'perPage' => $perPage,
        ]);
    }

    public function create()
    {
        $staffs = Staff::whereNull('deleted_at') // Exclude soft-deleted records
            ->where('attendance', 'Hadir')
            ->where('status', 'Belum Tempah')
            ->get();

        $tables = Table::whereNull('deleted_at') // Exclude soft-deleted records
            ->where('status', 'Tersedia')
            ->get();

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
        $booking = Booking::whereNull('deleted_at')->findOrFail($id);

        // Retrieve all staff with 'Hadir' attendance
        $staffs = Staff::whereNull('deleted_at')
            ->where('attendance', 'Hadir')
            ->where('status', 'Belum Tempah')
            ->get();

        // Include the current staff assigned to the booking in the list
        if ($booking->staff_id) {
            $currentStaff = Staff::where('id', $booking->staff_id)
                ->whereNull('deleted_at')
                ->where('attendance', 'Hadir')
                ->first();

            // Add the current staff to the list if they are not already included
            if ($currentStaff && !$staffs->contains($currentStaff)) {
                $staffs->prepend($currentStaff);
            }
        }

        // Retrieve tables that are available ('Tersedia') and not soft-deleted
        $tables = Table::whereNull('deleted_at')
            ->where('status', 'Tersedia')
            ->get();

        // Include the current staff assigned to the booking in the list
        if ($booking->table_id) {
            $currentTable = Table::where('id', $booking->table_id)
                ->whereNull('deleted_at')
                ->first();

            // Add the current Table to the list if they are not already included
            if ($currentTable && !$tables->contains($currentTable)) {
                $tables->prepend($currentTable);
            }
        }

        // Return the view with the necessary data
        return view('pages.booking.edit', [
            'save_route' => route('booking.update', $id),
            'str_mode' => 'Kemas Kini',
            'booking' => $booking,
            'tables' => $tables,
            'staffs' => $staffs,
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'table_id' => 'required|exists:tables,id',
        ], [
            'table_id.required' => 'Sila pilih meja untuk tempahan.',
            'table_id.exists' => 'Meja yang dipilih tidak wujud.',
        ]);

        $booking = Booking::findOrFail($id);

        // Retrieve old table information
        $oldTable = Table::findOrFail($booking->table_id);

        // If the table has changed
        if ($booking->table_id != $request->input('table_id')) {
            $newTable = Table::findOrFail($request->input('table_id'));

            // Check availability of the new table
            if ($newTable->available_seat <= 0) {
                return redirect()->back()->withErrors(['table_id' => 'Meja telah penuh'])->withInput();
            }

            // Update old table's available seats
            $oldTable->available_seat += 1; // Restore seat
            $oldTable->status = 'Tersedia'; // Ensure status reflects available seats
            $oldTable->save();

            // Update new table's available seats
            $newTable->available_seat -= 1; // Deduct seat
            $newTable->status = $newTable->available_seat > 0 ? 'Tersedia' : 'Penuh'; // Update status if no seats are available
            $newTable->save();
        }

        // Update booking details
        $previousStaffId = $booking->staff_id;
        $newStaffId = $request->input('staff_id');
        $booking->staff_id = $newStaffId;
        $booking->table_id = $request->input('table_id');

        // Generate QR Code and store it as Base64
        $staff = Staff::findOrFail($newStaffId); // Ensure staff is loaded
        $qrCode = QrCode::format('png')
            ->size(250)
            ->margin(0)
            ->generate($staff->no_pekerja);
        $qrCodeDataUri = 'data:image/png;base64,' . base64_encode($qrCode);
        $booking->qr_code = $qrCodeDataUri;

        // Save the updated booking with QR code
        $booking->save();

        // Update previous staff's status to 'Belum Tempah'
        if ($previousStaffId && $previousStaffId != $newStaffId) {
            $previousStaff = Staff::findOrFail($previousStaffId);
            $previousStaff->status = 'Belum Tempah';
            $previousStaff->save();
        }

        // Update new staff's status to 'Selesai Tempah'
        $staff->status = 'Selesai Tempah';
        $staff->save();

        return redirect()->route('booking')->with('success', 'Tempahan berjaya dikemaskini');
    }



    public function search(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10); // Default to 10 if not provided

        $bookingList = Booking::with(['staff', 'table']) // Assuming relationships with 'Staff' and 'Table' models
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('booking_no', 'LIKE', "%$search%")
                        ->orWhereHas('table', function ($q) use ($search) {
                            $q->where('table_no', 'LIKE', "%$search%");
                        })
                        ->orWhereHas('staff', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%$search%")
                                ->orWhere('no_pekerja', 'LIKE', "%$search%");
                        });
                }
            })
            ->latest()
            ->paginate($perPage);

        return view('pages.booking.index', [
            'bookingList' => $bookingList,
            'perPage' => $perPage,
            'search' => $search, // Include search value to keep it in the form
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $table = Table::findOrFail($booking->table_id);
        $table->available_seat += 1;
        $table->status = 'Tersedia';
        $table->save();

        $staff = Staff::findOrFail($booking->staff_id);
        $staff->status = 'Belum Tempah';
        $staff->save();

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

    public function export()
    {
        return Excel::download(new BookingExport, 'Tempahan-Meja-Malam-Gala.xlsx');
    }
}
