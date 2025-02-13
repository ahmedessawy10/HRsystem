<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:permission view_only|permission create_and_view', ['only' => ['index']]);
        // $this->middleware('permission:permission create_and_view', ['only' => ['create','store']]);
        // $this->middleware('permission:permission update', ['only' => ['update','edit']]);
        // $this->middleware('permission:permission delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $permissions = Permission::orderBy('created_at', 'desc')->get();;
        return view('user_permission.listPermission', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user_permission.createPermission');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:permissions', 'min:3'],
        ]);



        $permission = Permission::create($request->all());

        return redirect()->route('permission.index')->with('success', __('project.create successfully'))->with('success', __('project.create successfully'));
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
        $permission = Permission::findorfail($id);
        return view('user_permission.editPermission', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::findorfail($id);
        $request->validate([
            'name' => ['required', 'unique:permissions,name,' . $id . 'id', 'min:3'],
        ]);

        $permission->update($request->all());


        return redirect()->route('permission.index')->with('success', __('project.edit successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findorfail($id);

        if ($permission == null) {
            return response()->json([
                'status' => false,
            ]);
        }
        $permission->delete();


        return redirect()->route('permission.index')->with('success', __('project.delete successfully'));
    }
}
