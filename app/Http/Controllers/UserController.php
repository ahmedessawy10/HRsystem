<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{


    public function formChangePass()
    {

        return view('auth.change-password');
    }
    function changePassword(Request $request)
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

        return redirect()->route('dashboard');
    }
}
