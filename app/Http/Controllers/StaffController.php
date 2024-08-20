<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $staffList = Staff::latest()->paginate($perPage);

        return view('pages.staff.index', [
            'staffList' => $staffList,
            'perPage' => $perPage,
        ]);
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
            'name' => 'required',
            'no_pekerja' => 'required|unique:staff,no_pekerja',
            'status' => 'required|in:Pending,Booked',
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

    public function edit(Request $request, $id)
    {
        return view('pages.staff.edit', [
            'save_route' => route('staff.update', $id),
            'str_mode' => 'Kemas Kini',
            'staff' => Staff::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'no_pekerja'   => 'required|unique:staff,no_pekerja,' . $id,
            'status' => 'required|in:Pending,Booked',
        ]);

        $staff = Staff::findOrFail($id);

        $staff->fill($request->all());
        $staff->save();


        return redirect()->route('staff')->with('success', 'Maklumat berjaya dikemaskini');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $staffList = Staff::where('name', 'LIKE', "%$search%")
                ->orWhere('no_pekerja', 'LIKE', "%$search%")
                ->latest()
                ->paginate(10);
        } else {
            $staffList = Staff::latest()->paginate(10);
        }

        return view('pages.staff.index', [
            'staffList' => $staffList,
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
