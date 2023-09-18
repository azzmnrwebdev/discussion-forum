<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    protected function loginProcess(Request $request)
    {
        $request->validate([
            'email_or_username' => 'required|string|max:45',
            'password'          => 'required|string|min:8',
        ]);

        $loginType = filter_var($request->input('email_or_username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->input('email_or_username'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            return redirect(route('home'));
        } else {
            $user = User::where($loginType, $request->input('email_or_username'))->first();

            if ($user) {
                $errorMessage = $loginType === 'email' ? 'Your email or password is incorrect.' : 'Your username or password is incorrect.';
                return redirect()->back()->withErrors(['email_or_username' => $errorMessage])->withInput();
            } else {
                return redirect()->back()->withErrors(['email_or_username' => 'Sorry, account not found.'])->withInput();
            }
        }
    }

    protected function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
