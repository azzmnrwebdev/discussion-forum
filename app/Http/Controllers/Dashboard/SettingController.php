<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function account()
    {
        return view('dashboard.page.general.settings.account.index');
    }

    public function accountInformation()
    {
        $userLogin = Auth::user();
        return view('dashboard.page.general.settings.edit-account', compact('userLogin'));
    }

    public function updateAccount(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validatedData = $request->validate([
            'name'     => 'required|string|max:45',
            'username' => 'required|string|max:45|unique:users,username,' . $id,
            'email'    => 'required|string|email|max:50|unique:users,email,' . $id,
        ]);

        $user->update($validatedData);
        return redirect(route('account'))->with('success', 'Akun anda berhasil diperbarui');
    }

    public function privacy()
    {
        return view('dashboard.page.general.settings.privacy.index');
    }

    public function security()
    {
        return view('dashboard.page.general.settings.security.index');
    }


    public function changePassword()
    {
        return view('dashboard.page.general.settings.security.change-password');
    }

    public function updatePassword(Request $request)
    {
        $userLogin = Auth::user();
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'The current password field is required.',
            'new_password.required' => 'The new password field is required.',
            'new_password.min' => 'The new password must be at least 8 characters.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ]);

        if (!Hash::check($request->input('current_password'), $userLogin->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password does not match.'])->withInput();
        }

        $userLogin->update(['password' => Hash::make($request->input('new_password'))]);
        return redirect(route('security'))->with('success', 'Password anda berhasil diperbarui');
    }
}
