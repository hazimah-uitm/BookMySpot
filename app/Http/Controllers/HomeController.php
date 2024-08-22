<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Table;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 5);
        $search = $request->input('search');

        // Fetch paginated table data with search functionality
        $tables = Table::with('booking.staff')
            ->where(function ($query) use ($search) {
                if ($search) {
                    $query->where('table_no', 'LIKE', "%$search%")
                        ->orWhere('status', 'LIKE', "%$search%")
                        ->orWhereHas('booking.staff', function ($q) use ($search) {
                            $q->where('name', 'LIKE', "%$search%")
                                ->orWhere('no_pekerja', 'LIKE', "%$search%");
                        });
                }
            })
            ->orderBy('table_no', 'asc')
            ->paginate($perPage);

        // Fetch all tables for layout without pagination
        $tableList = Table::orderBy('table_no', 'asc')->where('type', 'Open')->get();

        return view('home', [
            'tables' => $tables,
            'tableList' => $tableList, // Used for the hall layout
            'search' => $search,
        ]);
    }
}
