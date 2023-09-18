<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    protected function registrationProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|min:5|max:45',
            'username'  => 'required|string|min:5|max:45|unique:users,username',
            'email'     => 'required|string|email|max:45|unique:users,email',
            'password'  => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'name'      => $request->input('name'),
            'username'  => $request->input('username'),
            'email'     => $request->input('email'),
            'password'  => Hash::make($request->input('password')),
        ]);

        return redirect(route('login'))->with('success', 'Registration was successful.');
    }
}
