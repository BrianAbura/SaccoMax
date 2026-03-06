<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_roles = UserRoles::where('roles_id', '!=', 2)->get();
        $assign_roles = Roles::where('id', '!=', 2)->get();
        $users = User::where('status', 1)->get();
        return view('staff.roles-management.index', compact('all_roles', 'assign_roles', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Query key role assignement
        // Roles 3 and 5 cannot be assigned to multiple users
        $check_role = UserRoles::where('roles_id', $request->role_id)->first();
        if ($check_role && ($check_role->roles_id == 3 || $check_role->roles_id == 5)) {
            $role = Roles::where('id', $check_role->roles_id)->first();
            return redirect()->back()->with('error', $role->name . ' role already assigned.');
        }

        $user_role = new UserRoles();
        $user_role->user_id = $request->user_id;
        $user_role->roles_id = $request->role_id;
        $user_role->save();

        return redirect()->back()->with('success', 'Role assigned successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Roles $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Roles $roles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Roles $roles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $roles = UserRoles::find($id);
        $roles->delete();
        return redirect()->back()->with('success', 'Role unassigned successfully.');
    }
}
