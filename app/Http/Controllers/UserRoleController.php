<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;

class UserRoleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:role view_only|role create_and_view', ['only' => ['index']]);
        // $this->middleware('permission:role create_and_view', ['only' => ['create', 'store', 'addPermissionToRole', 'givePermissionToRole']]);
        // $this->middleware('permission:role update', ['only' => ['update', 'edit']]);
        // $this->middleware('permission:role delete', ['only' => ['destroy']]);
    }



    public function index()
    {
        $roles = Role::orderBy('created_at', 'desc')->get();
        return view('user_role.listUserRole', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissionsAll = Permission::all();
        $permissions = [];
        foreach ($permissionsAll as $permission) {
            $name = $permission->name;
            $firstWord = strtok($name, ' ');
            $remainingString = trim(substr($name, strlen($firstWord)));
            if ($permission->clear_name) {
                $remainingString = $permission->clear_name;
            }

            if (!isset($permissions[$firstWord])) {
                $permissions[$firstWord] = [];
            }
            $permissions[$firstWord][] = [$name => $remainingString];
        }


        return view('user_role.createUserRole', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:roles', 'min:3'],
        ]);

        $role = Role::create(['name' => $request->name]);
        if (!empty($request->permissions)) {
            foreach ($request->permissions as $name) {

                $role->givePermissionTo($name);
            }
        }

        return redirect()->route('userRole.index')->with('success', __('project.create successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findorfail($id);
        $permissions = Permission::orderBy('name', 'asc')->get();
        $hasPermission = $role->permissions->pluck('name');

        $permissionsAll = Permission::all();
        $permissions = [];
        foreach ($permissionsAll as $permission) {
            $name = $permission->name;
            $firstWord = strtok($name, ' ');
            $remainingString = trim(substr($name, strlen($firstWord)));
            if ($permission->clear_name) {
                $remainingString = $permission->clear_name;
            }

            if (!isset($permissions[$firstWord])) {
                $permissions[$firstWord] = [];
            }
            $permissions[$firstWord][] = [$name => $remainingString];
        }

        return view('user_role.editUserRole', compact('role', 'permissions', 'hasPermission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::findorfail($id);
        $request->validate([
            'name' => ['required', 'min:3', 'unique:roles,name,' . $id . ',id'],
        ]);
        $role->name = $request->name;
        $role->save();



        if (!empty($request->permissions)) {

            $role->syncPermissions($request->permissions);
        }


        return redirect()->route('userRole.index')->with('success', __('project.edit successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findorfail($id);

        if ($role->id != 1) {
            $role->delete();
        } else {
            return redirect()->route('userRole.index')->with(['error', 'you cant delete super-admin']);
        }


        return redirect()->route('userRole.index')->with('success', __('project.delete successfully'));
    }
}
