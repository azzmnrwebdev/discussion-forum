<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');
        $query  = User::withCount('posts');

        if (!empty($search)) {
            $query->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('username', 'LIKE', '%' . $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%');
        }

        $users = $query->orderByRaw("FIELD(role, 'admin', 'user') ASC")->orderBy('id', 'DESC')->get();
        return view('dashboard.page.admin.user.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('dashboard.page.admin.user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:45',
            'username' => 'required|string|max:45|unique:users,username',
            'email'    => 'required|string|email|max:50|unique:users,email',
            'role'     => 'required',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $adminCount = User::where('role', 'admin')->count();
        if ($request->input('role') === 'admin' && $adminCount >= 2) {
            return redirect()->back()->withErrors(['role' => 'Maximum number of admin users reached.']);
        }

        User::create([
            'name'      => $request->input('name'),
            'username'  => strtolower(str_replace(' ', '', $request->input('username'))),
            'email'     => strtolower(str_replace(' ', '', $request->input('email'))),
            'role'      => $request->input('role'),
            'password'  => Hash::make($request->input('password'))
        ]);

        return redirect(route('users.index'))->with('success', 'Data pengguna berhasil disimpan');
    }

    public function edit($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        return view('dashboard.page.admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name'          => 'required|string|max:45',
            'username'      => 'required|string|max:45|unique:users,username,' . $user->id,
            'email'         => 'required|string|email|max:50|unique:users,email,' . $user->id,
            'old_password'  => 'nullable|required_with:new_password|string',
            'new_password'  => 'nullable|required_with:old_password|string|min:8'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->filled('old_password') && $request->filled('new_password')) {
            if (!Hash::check($data['old_password'], $user->password)) {
                return redirect()->back()->withErrors(['old_password' => "The old password doesn't match."]);
            }

            $user->password = Hash::make($data['new_password']);
        }

        $user->update($data);
        return redirect(route('users.index'))->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'admin') {
            $user->delete();
            return redirect()->back()->with('success', 'Data pengguna berhasil dihapus');
        }

        return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun admin sendiri');
    }
}
