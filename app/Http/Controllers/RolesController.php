<?php

namespace App\Http\Controllers;

use App\Models\RolesModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
class RolesController extends Controller
{
    public function index()
    {
        $roles = RolesModel::get();
        // dd($roles);
        return Inertia::render('Roles/Index', [
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        return Inertia::render('Roles/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);

        RolesModel::create([
            'id' => Str::uuid(),
            'name' => $request->name,
        ]);

        return redirect()->route('roles')->with('success', 'Role berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $role = RolesModel::findOrFail($id);
        $audits = $role->audits()->with('user')->latest()->get();
        return Inertia::render('Roles/Edit', [
            'role' => $role,
            'audits' => $audits,
        ]);
    }

    public function update(Request $request, $id)
    {
        $role = RolesModel::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $id,
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route('roles')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $role = RolesModel::findOrFail($id);
        $role->delete();

        return redirect()->back()->with('success', 'Role berhasil dihapus.');
    }
}
