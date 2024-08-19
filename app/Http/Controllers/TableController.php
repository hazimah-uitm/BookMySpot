<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $tableList = Table::latest()->paginate($perPage);

        return view('pages.table.index', [
            'tableList' => $tableList,
            'perPage' => $perPage,
        ]);
    }

    public function create()
    {
        return view('pages.table.create', [
            'save_route' => route('table.store'),
            'str_mode' => 'Tambah',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_no' => 'required|unique:tables,table_no',
            'total_seat' => 'required|integer',
            'available_seat' => 'required|integer',
            'status' => 'required|in:Available,Booked',
        ], [
            'table_no.required' => 'Sila isi No. Meja',
            'table_no.unique' => 'No. Meja telah wujud',
            'total_seat.required' => 'Sila isi Jumlah Tempat Duduk',
            'available_seat.required' => 'Sila isi Jumlah Tempat Duduk Kosong',
            'status.required' => 'Sila pilih Status Meja',
        ]);
    

        $table = new Table();

        // Normalize the table_no
        $table_no = strtoupper(str_replace(' ', '', $request->input('table_no')));

        // Check if table_no already exists
        if (Table::where('table_no',  $table_no)->exists()) {
            return redirect()->back()->withErrors(['table_no' => 'No. Meja telah wujud'])->withInput();
        }
        $table->table_no = $table_no;
        $table->total_seat = $request->input('total_seat');
        $table->available_seat = $request->input('available_seat');
        $table->status = $request->input('status');

        $table->save();

        return redirect()->route('table')->with('success', 'Maklumat berjaya disimpan');
    }


    public function show($id)
    {
        $table = Table::findOrFail($id);

        return view('pages.table.view', [
            'table' => $table,
        ]);
    }

    public function edit(Request $request, $id)
    {
        return view('pages.table.edit', [
            'save_route' => route('table.update', $id),
            'str_mode' => 'Kemas Kini',
            'table' => Table::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'table_no' => 'required|unique:tables,table_no,' . $id,
            'total_seat' => 'required|integer',
            'available_seat' => 'required|integer',
            'status' => 'required|in:Available,Booked',
        ], [
            'table_no.required' => 'Sila isi No. Meja',
            'table_no.unique' => 'No. Meja telah wujud',
            'total_seat.required' => 'Sila isi Jumlah Tempat Duduk',
            'available_seat.required' => 'Sila isi Jumlah Tempat Duduk Kosong',
            'status.required' => 'Sila pilih Status Meja',
        ]);
    
        $table = Table::findOrFail($id);

        // Normalize the table_no
        $table_no = strtoupper(str_replace(' ', '', $request->input('table_no')));

        // Check if table_no already exists, excluding the current record
        if (Table::where('table_no', $table_no)
            ->where('id', '!=', $id)
            ->exists()
        ) {
            return redirect()->back()
                ->withErrors(['table_no' => 'No. Meja telah wujud'])
                ->withInput();
        }

        $table->table_no = $table_no;
        $table->total_seat = $request->input('total_seat');
        $table->available_seat = $request->input('available_seat');
        $table->status = $request->input('status');
        $table->save();
    
        return redirect()->route('table')->with('success', 'Maklumat berjaya dikemaskini');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $tableList = Table::where('table_no', 'LIKE', "%$search%")
                ->orWhere('total_seat', 'LIKE', "%$search%")
                ->latest()
                ->paginate(10);
        } else {
            $tableList = Table::latest()->paginate(10);
        }

        return view('pages.table.index', [
            'tableList' => $tableList,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $table = Table::findOrFail($id);

        $table->delete();

        return redirect()->route('table')->with('success', 'Maklumat berjaya dihapuskan');
    }

    public function trashList()
    {
        $trashList = Table::onlyTrashed()->latest()->paginate(10);

        return view('pages.table.trash', [
            'trashList' => $trashList,
        ]);
    }

    public function restore($id)
    {
        Table::withTrashed()->where('id', $id)->restore();

        return redirect()->route('table')->with('success', 'Maklumat berjaya dikembalikan');
    }


    public function forceDelete($id)
    {
        $table = Table::withTrashed()->findOrFail($id);

        $table->forceDelete();

        return redirect()->route('table.trash')->with('success', 'Maklumat berjaya dihapuskan sepenuhnya');
    }
}
