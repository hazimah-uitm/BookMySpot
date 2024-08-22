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
        $perPage = $request->input('perPage', 10);
        $tables = Table::with('booking.staff')
            ->orderBy('table_no', 'asc') 
            ->paginate($perPage);  
        
        // for not paginate
        $tableList = Table::orderBy('table_no', 'asc')->get();

        return view('home', [
            'tables' => $tables,
            'tableList' => $tableList,
        ]);
    }
}
