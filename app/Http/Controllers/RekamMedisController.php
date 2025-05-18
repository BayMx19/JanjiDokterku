<?php

namespace App\Http\Controllers;

use App\Models\RekamMedisModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
class RekamMedisController extends Controller
{
    public function index()
    {
        $rekamMedis = RekamMedisModel::with('pasien')->with('user')->latest()->get();

        return Inertia::render('RM/Index', [
            'RM' => $rekamMedis,
        ]);
    }
    public function create()
    {
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'User');
        })->get();
        $pencatat = Auth::user()->name;

        return Inertia::render('RM/Create', [
            'users' => $users,
            'pencatat' => $pencatat,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'tanggal'   => 'required|date',
            'diagnosa'  => 'required|string',
            'tindakan'  => 'required|string',
            'resep'     => 'required|string',
            'catatan'   => 'nullable|string',
            'pencatat'     => 'required|string',
        ]);

        RekamMedisModel::create([
            'id'        => Str::uuid(),
            'user_id'   => $request->user_id,
            'tanggal'   => $request->tanggal,
            'diagnosa'  => $request->diagnosa,
            'tindakan'  => $request->tindakan,
            'resep'     => $request->resep,
            'catatan'   => $request->catatan,
            'pencatat'   => $request->pencatat,
        ]);

        return redirect()->route('rm')->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $rekam_medis = RekamMedisModel::findOrFail($id);
        // dd($rekam_medis);
        $users = User::whereHas('role', function ($query) {
            $query->where('name', 'User');
        })->get();

        $audits = $rekam_medis->audits()->with('user')->latest()->get();

        return Inertia::render('RM/Edit', [
            'rekam_medis' => $rekam_medis,
            'users' => $users,
            'audits' => $audits,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rekam_medis = RekamMedisModel::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep' => 'nullable|string',
            'catatan' => 'nullable|string',
            'pencatat' => 'required|string',
        ]);

        $rekam_medis->update($validated);

        return redirect()->route('rm')->with('success', 'Rekam medis berhasil diperbarui.');
    }
        public function destroy($id)
    {
        $rm = RekamMedisModel::findOrFail($id);

        if (Auth::user()->name == $rm->pencatat) {
            return back()->with('error', 'Anda tidak dapat menghapus data yang Anda catat sendiri.');
        }

        $rm->delete();
        return redirect()->back()->with('success', 'Data rekam medis berhasil dihapus.');
    }

}
