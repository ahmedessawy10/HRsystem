<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Jobs\UserJob;
use App\Mail\Register;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function __construct()
    {

        $this->middleware('permission:user view_only|user create_and_view', ['only' => ['index']]);
        $this->middleware('permission:user create_and_view', ['only' => ['create', 'store']]);
        $this->middleware('permission:user update', ['only' => ['update', 'edit']]);
        $this->middleware('permission:user delete', ['only' => ['destroy']]);
        $this->middleware('permission:profile edit', ['only' => ['editProfile', 'updateProfile']]);
    }
    public function index()
    {
        $users = User::all();
        return view('users.listUser', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return  view('users.createUser', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        // if(isset($request->roles)&& in_array('employee',$request->roles)){
        $data = $request->validate([
            "name" => ['required', 'string', 'max:255'],
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:users,email', 'min:3'],
            'status' => ['required', Rule::in(['active', 'inactive', 'pending'])],
            'roles' => ['required'],

        ]);
        $mail_fail = false;
        //   if(isset($request->roles)&& in_array('employee',$request->roles)){
        $data["password"] = Hash::make("123456");

        $user = User::create($data);
        $user->assignRole($request->roles);
        return redirect()->route('admin.user.index')->with('success', __('project.create successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name');
        return view("users.editUser", [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function update(Request $request, User $user)
    {

        // if(isset($request->roles)&& in_array('employee',$request->roles)){
        $request->validate([
            "name" => ['required', 'string', 'max:255', 'unique:users,name,' . $user->id . 'id'],
            'email' => 'email|unique:users,email,' . $user->id . 'id',
            'fullname' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive', 'pending'])],
            'roles' => ['required']
        ]);



        if ($user->id == 1 && auth()->user()->id != 1) {
            return redirect()->back()->with('error', __('project.something_went_wrong'));
        }

        $updateData = $request->only(['name', 'email', 'password', 'status']);


        if ($user->id == 1) {

            unset($updateData['status']);
        }
        if ($user->id != 1) {

            $user->syncRoles($request->roles);
        }


        return redirect()->route('admin.user.index')->with('success', __('project.edit successfully'));
    }

    public function destroy($userId)
    {
        if ($userId == 1 && auth()->user()->id != 1) {
            return redirect()->back()->with('error', __('project.something_went_wrong'));
        }
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', __('project.delete successfully'));
    }

    public function editProfile()
    {

        $user = auth()->user();
        return view('users.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:12|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[!@#$%^&*()_+{}\[\]:;"\'<>,.?~`-]/',
            'password_confirmation' => 'required_with:password|same:password|nullable|string|min:12|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[!@#$%^&*()_+{}\[\]:;"\'<>,.?~`-]/',
        ]);

        $updateData = $request->only(['name', 'email', 'password']);
        if (!$user->hasPermissionTo('profile name edit')) {
            unset($updateData['name']);
        }
        if (!$user->hasPermissionTo('profile email edit')) {
            unset($updateData['email']);
        }


        if (isset($updateData['password']) && $updateData['password'] != null) {

            $updateData['password'] = Hash::make($updateData['password']);
        } else {
            unset($updateData['password']);
        }


        $user->update($updateData);


        return redirect()->route('admin.dashboard')->with('success', 'profile update successfully');
    }



    public function  activeUser(Request $request)
    {


        $user = User::findorfail($request->user_id);

        if (!$user->hasRole('super-admin') || $user->id != 1) {

            $status = ($request->status) ? "active" : 'inactive';

            $user->update([
                "status" => $status,
            ]);

            return  response()->json(['success' => __('project.edit_user_status_successfully')]);
        }

        return  response()->json(['error' => __('project.edit_user_status_fail')]);
    }


    public function changePassword(Request $request)
    {

        $validate = $request->validate([
            'old_password' => 'required',
            "password" => 'string|min:12|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[!@#$%^&*()_+{}\[\]:;"\'<>,.?~`-]/|nullable',
            'password_confirmation' => 'required_with:password|same:password|min:6|nullable|string|min:12|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[!@#$%^&*()_+{}\[\]:;"\'<>,.?~`-]/',
        ]);

        if (auth()->user()) {

            if (Hash::check($request->old_password, auth()->user()->password)) {

                auth()->user()->update([
                    'password' => Hash::make($validate['password']),
                    'last_login' => now(),
                ]);
            } else {
                throw ValidationException::withMessages([
                    'old_password' => __('project.old-password-doesnt-match'),
                ]);
            }
        }

        return redirect()->route('admin.dashboard');
    }
}
