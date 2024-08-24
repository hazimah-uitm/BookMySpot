<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $type = $request->input('type');

        $query = Attendance::query();

        if ($type) {
            $query->where('type', $type);
        }

        $attendanceList =  $query->orderBy('check_in', 'asc')->paginate($perPage);


        return view('pages.attendance.index', [
            'attendanceList' => $attendanceList,
            'type' => $type,
            'perPage' => $perPage,
        ]);
    }

    public function create()
    {
        return view('pages.attendance.create', [
            'save_route' => route('attendance.store'),
            'str_mode' => 'Tambah',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_pekerja' => 'required|exists:staff,no_pekerja',
        ], [
            'no_pekerja.required' => 'Sila isi No. Pekerja',
            'no_pekerja.exists' => 'No. Pekerja tiada padanan dalam sistem',
        ]);

        $staff = Staff::where('no_pekerja', $request->input('no_pekerja'))->firstOrFail();

        $existingAttendance = Attendance::where('no_pekerja', $staff->no_pekerja)->first();

        if ($existingAttendance) {
            return redirect()->back()->withErrors(['no_pekerja' => 'Rekod kehadiran untuk No. Pekerja ini sudah wujud']);
        }

        $attendance = new Attendance();
        $attendance->no_pekerja = $staff->no_pekerja;
        $attendance->name = $staff->name;
        $attendance->check_in = now();
        $attendance->type = $staff->type;
        $attendance->save();

        return redirect()->back()->with('success', 'Kehadiran berjaya direkod!');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10);
        $type = $request->input('type');

        $query = Attendance::query();

        if ($search) {
            $query->where('no_pekerja', 'LIKE', "%$search%")
                ->orWhere('name', 'LIKE', "%$search%")
                ->orWhere('type', 'LIKE', "%$search%")
                ->latest()
                ->paginate($perPage);
        }

        if ($type) {
            $query->where('type', $type);
        }

        $attendanceList = $query->latest()->paginate($perPage);

        return view('pages.attendance.index', [
            'attendanceList' => $attendanceList,
            'perPage' => $perPage,
            'search' => $search,
            'type' => $type,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->delete();

        return redirect()->route('attendance')->with('success', 'Maklumat berjaya dihapuskan');
    }

    public function trashList()
    {
        $trashList = Attendance::onlyTrashed()->latest()->paginate(10);

        return view('pages.attendance.trash', [
            'trashList' => $trashList,
        ]);
    }

    public function restore($id)
    {
        Attendance::withTrashed()->where('id', $id)->restore();

        return redirect()->route('attendance')->with('success', 'Maklumat berjaya dikembalikan');
    }


    public function forceDelete($id)
    {
        $attendance = Attendance::withTrashed()->findOrFail($id);

        $attendance->forceDelete();

        return redirect()->route('attendance.trash')->with('success', 'Maklumat berjaya dihapuskan sepenuhnya');
    }


    public function export(Request $request)
    {
        $type = $request->input('type');
        
        $filename = 'Kehadiran-Malam-Gala-2024.xlsx';
    
        return Excel::download(new AttendanceExport($type), $filename);
    }
}
