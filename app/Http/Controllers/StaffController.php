<?php

namespace App\Http\Controllers;

use App\Imports\StaffImport;
use App\Models\Staff;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $type = $request->input('type');
        $attendance = $request->input('attendance');
        $status = $request->input('status');

        $query = Staff::query();

        if ($type) {
            $query->where('type', $type);
        }

        if ($attendance) {
            $query->where('attendance', $attendance);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $staffList = $query->orderBy('name', 'asc')->paginate($perPage);

        return view('pages.staff.index', [
            'staffList' => $staffList,
            'perPage' => $perPage,
            'type' => $type,
            'attendance' => $attendance,
            'status' => $status,
        ]);
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new StaffImport, $request->file('file'));

            return redirect()->back()->with('success', 'Data telah berjaya di import');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing data: ' . $e->getMessage());
        }
    }


    public function create()
    {
        return view('pages.staff.create', [
            'save_route' => route('staff.store'),
            'str_mode' => 'Tambah',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'nullable',
            'name' => 'required',
            'no_pekerja' => 'required',
            'attendance' => 'required|in:Hadir,Tidak Hadir',
            'category' => 'nullable|in:Staf Akademik,Staf Pentadbiran',
            'department' => 'nullable',
            'campus' => 'nullable',
            'club' => 'nullable|in:Ahli KEKiTA,Ahli PEWANI,Bukan Ahli  (Bayaran RM20 dikenakan)',
            'payment' => 'nullable',
            'type' => 'required|in:Staf,Bukan Staf',
            'status' => 'required|in:Belum Tempah,Selesai Tempah',
        ], [
            'name.required' => 'Sila isi Nama',
            'no_pekerja.required' => 'Sila isi No. Pekerja',
            'attendance.required' => 'Sila sahkan kehadiran',
            'type.required' => 'Sila isi jenis pengguna',
            'status.required' => 'Sila pilih Status',
        ]);

        $existingStaff = Staff::where('no_pekerja', strtoupper($request->input('no_pekerja')))
            ->whereNull('deleted_at') 
            ->first();

        if ($existingStaff) {
            return redirect()->back()->withErrors(['no_pekerja' => 'No. Pekerja telah wujud'])->withInput();
        }

        $staff = new Staff();

        $staff->fill($request->except(['name', 'no_pekerja']));
        $staff->name = strtoupper($request->input('name'));
        $staff->no_pekerja = strtoupper($request->input('no_pekerja'));
        $staff->save();

        return redirect()->route('staff')->with('success', 'Maklumat berjaya disimpan');
    }

    public function show($id)
    {
        $staff = Staff::findOrFail($id);

        return view('pages.staff.view', [
            'staff' => $staff,
        ]);
    }

    public function edit($id)
    {
        $staff = Staff::findOrFail($id);

        return view('pages.staff.edit', [
            'staff' => $staff,
            'save_route' => route('staff.update', $id),
            'str_mode' => 'Kemaskini',
        ]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'nullable',
            'name' => 'required',
            'no_pekerja' => 'required',
            'attendance' => 'required|in:Hadir,Tidak Hadir',
            'category' => 'nullable|in:Staf Akademik,Staf Pentadbiran',
            'department' => 'nullable',
            'campus' => 'nullable',
            'club' => 'nullable|in:Ahli KEKiTA,Ahli PEWANI,Bukan Ahli  (Bayaran RM20 dikenakan)',
            'payment' => 'nullable',
            'type' => 'required|in:Staf,Bukan Staf',
            'status' => 'required|in:Belum Tempah,Selesai Tempah',
        ], [
            'name.required' => 'Sila isi Nama',
            'no_pekerja.required' => 'Sila isi No. Pekerja',
            'attendance.required' => 'Sila sahkan kehadiran',
            'type.required' => 'Sila isi jenis pengguna',
            'status.required' => 'Sila pilih Status',
        ]);

        // Check if a staff with the same no_pekerja exists (excluding the current record)
        $existingStaff = Staff::whereNull('deleted_at') 
            ->where('no_pekerja', strtoupper($request->input('no_pekerja')))
            ->where('id', '<>', $id)
            ->first();

        if ($existingStaff) {
            // If the staff exists, handle the logic accordingly
            return redirect()->back()->with('error', 'No. Pekerja telah wujud');
        }

        // Find the staff record by ID
        $staff = Staff::findOrFail($id);

        $staff->fill($request->except(['name', 'no_pekerja']));
        $staff->name = strtoupper($request->input('name'));
        $staff->no_pekerja = strtoupper($request->input('no_pekerja'));
        $staff->save();

        return redirect()->route('staff')->with('success', 'Maklumat berjaya dikemas kini');
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $type = $request->input('type');
        $attendance = $request->input('attendance');
        $status = $request->input('status');

        $query = Staff::query();

        if ($search) {
            $query->where('name', 'LIKE', "%$search%")
                ->orWhere('no_pekerja', 'LIKE', "%$search%")
                ->orWhere('attendance', 'LIKE', "%$search%")
                ->orWhere('status', 'LIKE', "%$search%")
                ->orWhere('type', 'LIKE', "%$search%")
                ->orWhere('campus', 'LIKE', "%$search%");
        }

        if ($type) {
            $query->where('type', $type);
        }

        if ($attendance) {
            $query->where('attendance', $attendance);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $staffList = $query->latest()->paginate($perPage);

        return view('pages.staff.index', [
            'staffList' => $staffList,
            'perPage' => $perPage,
            'search' => $search,
            'type' => $type,
            'attendance' => $attendance,
            'status' => $status,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $staff->delete();

        return redirect()->route('staff')->with('success', 'Maklumat berjaya dihapuskan');
    }

    public function trashList()
    {
        $trashList = Staff::onlyTrashed()->latest()->paginate(10);

        return view('pages.staff.trash', [
            'trashList' => $trashList,
        ]);
    }

    public function restore($id)
    {
        Staff::withTrashed()->where('id', $id)->restore();

        return redirect()->route('staff')->with('success', 'Maklumat berjaya dikembalikan');
    }


    public function forceDelete($id)
    {
        $staff = Staff::withTrashed()->findOrFail($id);

        $staff->forceDelete();

        return redirect()->route('staff.trash')->with('success', 'Maklumat berjaya dihapuskan sepenuhnya');
    }
}
