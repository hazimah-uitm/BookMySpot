<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\Position;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use SoftDeletes;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);

        $userList = User::latest()->paginate($perPage);

        return view('pages.user.index', [
            'userList' => $userList,
            'perPage' => $perPage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campusList = Campus::where('publish_status', 1)->get();
        $positionList = Position::where('publish_status', 1)->get();
        $roles = Role::where('publish_status', 1)->get();

        return view('pages.user.create', [
            'save_route' => route('user.store'),
            'str_mode' => 'Tambah',
            'campusList' => $campusList,
            'positionList' => $positionList,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'staff_id' => 'required|unique:users,staff_id',
            'email'    => 'required|email|unique:users,email',
            'position_id' => 'required',
            'roles'    => 'required|array|exists:roles,name',
            'campus_id' => 'required|exists:campuses,id',
            'office_phone_no' => 'nullable|string',
            'publish_status' => 'required|in:1,0',
        ]);

        $user = new User();
        $user->fill($request->except('roles'));
        $user->password = null; // Password will be set later via email link
        $user->email_verified_at = null; // Email verification pending
        $user->save();

        // Assign roles to the user
        $user->assignRole($request->input('roles'));

        // Send password reset link
        $token = app('auth.password.broker')->createToken($user);
        // $user->notify(new ResetPasswordNotification($token, true));

        return redirect()->route('user')
            ->with('success', 'Maklumat berjaya disimpan');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('pages.user.view', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::where('publish_status', 1)->get();
        $campusList = Campus::where('publish_status', 1)->get();
        $positionList = Position::where('publish_status', 1)->get();

        return view('pages.user.edit', [
            'save_route' => route('user.update', $id),
            'str_mode' => 'Kemas Kini',
            'roles' => $roles,
            'user' => $user,
            'campusList' => $campusList,
            'positionList' => $positionList,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required',
            'staff_id'   => 'required|unique:users,staff_id,' . $id,
            'email'      => 'required|email|unique:users,email,' . $id,
            'position_id' => 'required|exists:positions,id',
            'roles'      => 'required|array|exists:roles,name',
            'campus_id'  => 'required|exists:campuses,id',
            'office_phone_number' => 'nullable|string',
            'publish_status' => 'required|in:1,0',
        ]);
    
        $user = User::findOrFail($id);
        $user->fill($request->except('roles', 'password'));
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
    
        $user->save();
    
        $user->syncRoles($request->input('roles'));
    
        return redirect()->route('user')
            ->with('success', 'Maklumat berjaya dikemaskini');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user')->with('success', 'Maklumat berjaya dihapuskan');
    }

    public function trashList()
    {
        $trashList = User::onlyTrashed()->latest()->paginate(10);

        return view('pages.user.trash', [
            'trashList' => $trashList,
        ]);
    }

    public function restore($id)
    {
        $user = User::withTrashed()->where('id', $id)->restore();

        return redirect()->route('user')->with('success', 'Maklumat berjaya dikembalikan');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('user.trash')->with('success', 'Maklumat berjaya dihapuskan sepenuhnya');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        if ($search) {
            $userList = User::where('name', 'LIKE', "%$search%")
                ->orWhere('position_id', 'LIKE', "%$search%")
                ->latest()
                ->paginate(10);
        } else {
            $userList = User::latest()->paginate(10);
        }

        return view('pages.user.index', [
            'userList' => $userList,
        ]);
    }
}
