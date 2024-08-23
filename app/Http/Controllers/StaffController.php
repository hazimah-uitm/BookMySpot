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

        $staffList = Staff::orderBy('name', 'asc')->paginate($perPage);

        return view('pages.staff.index', [
            'staffList' => $staffList,
            'perPage' => $perPage,
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);

        try {
            Excel::import(new StaffImport, $request->file('file'));

            return redirect()->back()->with('success', 'Staff data imported successfully.');
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
            'no_pekerja' => 'required|unique:staff,no_pekerja',
            'attendance' => 'required|in:Hadir,Tidak Hadir',
            'category' => 'nullable|in:Staf Akademik,Staf Pentadbiran',
            'department' => 'nullable',
            'campus' => 'nullable',
            'club' => 'nullable|in:Ahli KEKiTA,Ahli PEWANI,Bukan Ahli  (Bayaran RM20 dikenakan)',
            'payment' => 'nullable',
            'type' => 'required|in:Staf,Bukan Staf',
            'status' => 'required|in:Belum Tempah,Selesai Tempah',
        ],[
            'name.required' => 'Sila isi Nama',
            'no_pekerja.unique' => 'No. Pekerja telah wujud',
            'attendance.required' => 'Sila sahkan kehadiran',
            'type.required' => 'Sila isi jenis pengguna',
            'status.required' => 'Sila pilih Status',
        ]);

        $staff = new Staff();

        $staff->fill($request->all());
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
            'no_pekerja' => ['required', Rule::unique('staff', 'no_pekerja')->ignore($id)],
            'attendance' => 'required|in:Hadir,Tidak Hadir',
            'category' => 'nullable|in:Staf Akademik,Staf Pentadbiran',
            'department' => 'nullable',
            'campus' => 'nullable',
            'club' => 'nullable|in:Ahli KEKiTA,Ahli PEWANI,Bukan Ahli  (Bayaran RM20 dikenakan)',
            'payment' => 'nullable',
            'type' => 'required|in:Staf,Bukan Staf',
            'status' => 'required|in:Belum Tempah,Selesai Tempah',
        ],[
            'name.required' => 'Sila isi Nama',
            'no_pekerja.unique' => 'No. Pekerja telah wujud',
            'attendance.required' => 'Sila sahkan kehadiran',
            'type.required' => 'Sila isi jenis pengguna',
            'status.required' => 'Sila pilih Status',
        ]);
    
        // Find the staff record by ID
        $staff = Staff::findOrFail($id);
    
        // Update the staff record with new data
        $staff->fill($request->all());
        $staff->save();
    
        return redirect()->route('staff')->with('success', 'Maklumat berjaya dikemas kini');
    }
    

    public function search(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10); // Default to 10 if not provided

        if ($search) {
            $staffList = Staff::where('name', 'LIKE', "%$search%")
                ->orWhere('no_pekerja', 'LIKE', "%$search%")
                ->orWhere('attendance', 'LIKE', "%$search%")
                ->orWhere('campus', 'LIKE', "%$search%")
                ->latest()
                ->paginate($perPage);
        } else {
            $staffList = Staff::latest()->paginate($perPage);
        }

        return view('pages.staff.index', [
            'staffList' => $staffList,
            'perPage' => $perPage, 
            'search' => $search, 
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
