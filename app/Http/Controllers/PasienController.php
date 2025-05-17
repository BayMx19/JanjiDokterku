<?php

namespace App\Http\Controllers;

use App\Models\PasienModel;
use App\Models\RolesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PasienController extends Controller
{
    public function index()
    {
        $pasien = PasienModel::with('user')->withoutTrashed()->paginate(10);

        return Inertia::render('Pasien/Index', [
            'pasien' => $pasien,
        ]);
    }

    public function create()
    {
        $role = RolesModel::where('name', 'User')->first();
        $registeredUserIds = PasienModel::pluck('user_id')->toArray();
        $users = User::where('role_id', $role->id)
                    ->whereNotIn('id', $registeredUserIds)
                    ->select('id', 'name')
                    ->get();

        return Inertia::render('Pasien/Create', [
            'users' => $users,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'NIK'           => 'required|string|max:16',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|string',
            'alamat'        => 'nullable|array',
            'alamat.jalan'  => 'nullable|string|max:255',
            'alamat.kelurahan'  => 'nullable|string|max:255',
            'alamat.kecamatan'  => 'nullable|string|max:255',
            'alamat.kota'       => 'nullable|string|max:255',
            'alamat.provinsi'   => 'nullable|string|max:255',
            'alamat.kode_pos'   => 'nullable|string|max:10',
            'user_id'       => 'required|exists:users,id',
        ]);
        // $alamat = $validated['alamat'] ?? null;
        // if (is_array($alamat)) {
        //     $alamat = json_encode($alamat);
        // }
        // elseif (is_string($alamat) && trim($alamat) === '') {
        // $alamat = null;
        // }
        PasienModel::create([
            'id'            => Str::uuid()->toString(),
            'NIK'           => $validated['NIK'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat'        => $validated['alamat'],
            'user_id'       => $validated['user_id'],
        ]);

        return redirect()->route('pasien')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pasien = PasienModel::with('user')->findOrFail($id);
        $audits = $pasien->audits()->with('user')->latest()->get();
        $users = User::select('id', 'name')->get();

        return Inertia::render('Pasien/Edit', [
            'pasien'  => $pasien,
            'audits'  => $audits,
            'users'   => $users,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
                'NIK'           => 'required|string|max:16',
                'tanggal_lahir' => 'required|date',
                'jenis_kelamin' => 'required|string',
                'alamat.jalan'     => 'nullable|string',
                'alamat.kelurahan' => 'nullable|string',
                'alamat.kecamatan' => 'nullable|string',
                'alamat.kota'      => 'nullable|string',
                'alamat.provinsi'  => 'nullable|string',
                'alamat.kode_pos'  => 'nullable|string',
                'user_id'       => 'required|exists:users,id',
            ]);

        $pasien = PasienModel::findOrFail($id);

        $pasien->update([
            'NIK'           => $validated['NIK'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat'        => [
                'jalan'     => $validated['alamat']['jalan'] ?? '',
                'kelurahan' => $validated['alamat']['kelurahan'] ?? '',
                'kecamatan' => $validated['alamat']['kecamatan'] ?? '',
                'kota'      => $validated['alamat']['kota'] ?? '',
                'provinsi'  => $validated['alamat']['provinsi'] ?? '',
                'kode_pos'  => $validated['alamat']['kode_pos'] ?? '',
            ],
            'user_id'       => $validated['user_id'],
        ]);

        return redirect()->route('pasien')->with('success', 'Data pasien berhasil diupdate.');    }

    public function destroy($id)
    {
        $pasien = PasienModel::findOrFail($id);
        $pasien->delete();

        return redirect()->route('pasien')->with('success', 'Pasien berhasil dihapus.');
    }
}
