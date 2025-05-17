<?php

namespace App\Http\Controllers;

use App\Models\RolesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->withoutTrashed()->paginate(10);
        return Inertia::render('Users/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return Inertia::render('Users/Create', [
            'roles' => RolesModel::select('id', 'name')->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id'  => 'required|exists:roles,id'
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id'  => $validated['role_id']
        ]);

        return redirect()->route('users')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return Inertia::render('Users/Edit', [
            'user' => $user,
            'roles' => RolesModel::select('id', 'name')->get(),
        ]);
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($validated);

        return redirect()->route('users')->with('success', 'User berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->id == $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus diri sendiri.');
        }
        $user->delete();
 return redirect()->back()->with('success', 'User berhasil dihapus.');    }


}
