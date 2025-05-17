<?php

namespace App\Http\Controllers;

use App\Models\DokterModel;
use App\Models\RolesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
class DokterController extends Controller
{
    public function index()
    {
        $dokter = DokterModel::with('user')->withoutTrashed()->paginate(10);
        // dd($dokter);
        return Inertia::render('Dokter/Index', [
            'dokter' => $dokter,
        ]);
    }

    public function create()
    {
        $users = User::whereDoesntHave('dokter')
                ->whereHas('role', function ($query) {
                    $query->where('name', 'Dokter');
                })
                ->get();
        return Inertia::render('Dokter/Create', [
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'NIK'           => 'required|string|max:30|unique:dokter,NIK',
            'jenis_kelamin' => 'required|string',
            'no_hp'         => 'required|string|max:20',
            'alamat.jalan'     => 'nullable|string|max:255',
            'alamat.kelurahan' => 'nullable|string|max:255',
            'alamat.kecamatan' => 'nullable|string|max:255',
            'alamat.kota'      => 'nullable|string|max:255',
            'alamat.provinsi'  => 'nullable|string|max:255',
            'alamat.kode_pos'  => 'nullable|string|max:10',
            'spesialisasi'  => 'required|string|max:100',
            'jadwal'        => 'nullable|array',
            'jadwal.*.hari'      => 'required_with:jadwal|string',
            'jadwal.*.jam_mulai' => 'required_with:jadwal|string',
            'jadwal.*.jam_akhir' => 'required_with:jadwal|string',
            'aktif'         => 'required|boolean',
        ]);

        DokterModel::create([
            'user_id'       => $validated['user_id'],
            'NIK'           => $validated['NIK'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'no_hp'         => $validated['no_hp'],
            'alamat'        => [
                'jalan'     => $validated['alamat']['jalan'] ?? '',
                'kelurahan' => $validated['alamat']['kelurahan'] ?? '',
                'kecamatan' => $validated['alamat']['kecamatan'] ?? '',
                'kota'      => $validated['alamat']['kota'] ?? '',
                'provinsi'  => $validated['alamat']['provinsi'] ?? '',
                'kode_pos'  => $validated['alamat']['kode_pos'] ?? '',
            ],
            'spesialisasi'  => $validated['spesialisasi'],
            'jadwal'        => $validated['jadwal'] ?? [],
            'aktif'         => $validated['aktif'],
        ]);

        return redirect()->route('dokter')->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dokter = DokterModel::with('user')->findOrFail($id);
        $audits = $dokter->audits()->with('user')->latest()->get();

        $users = User::whereDoesntHave('dokter')
            ->orWhere('id', $dokter->user_id)
            ->get();

        return Inertia::render('Dokter/Edit', [
            'dokter' => $dokter,
            'audits'  => $audits,
            'users' => $users,
        ]);
    }

    public function update(Request $request, $id)
    {
        $dokter = DokterModel::findOrFail($id);

        $validated = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'NIK'           => 'required|string|max:30|unique:dokter,NIK,' . $dokter->id,
            'jenis_kelamin' => 'required|string',
            'no_hp'         => 'required|string|max:20',
            'alamat.jalan'     => 'nullable|string|max:255',
            'alamat.kelurahan' => 'nullable|string|max:255',
            'alamat.kecamatan' => 'nullable|string|max:255',
            'alamat.kota'      => 'nullable|string|max:255',
            'alamat.provinsi'  => 'nullable|string|max:255',
            'alamat.kode_pos'  => 'nullable|string|max:10',
            'spesialisasi'  => 'required|string|max:100',
            'jadwal'        => 'nullable|array',
            'jadwal.*.hari'      => 'required_with:jadwal|string',
            'jadwal.*.jam_mulai' => 'required_with:jadwal|string',
            'jadwal.*.jam_akhir' => 'required_with:jadwal|string',
            'aktif'         => 'required|boolean',
        ]);

        $dokter->update([
            'user_id'       => $validated['user_id'],
            'NIK'           => $validated['NIK'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'no_hp'         => $validated['no_hp'],
            'alamat'        => [
                'jalan'     => $validated['alamat']['jalan'] ?? '',
                'kelurahan' => $validated['alamat']['kelurahan'] ?? '',
                'kecamatan' => $validated['alamat']['kecamatan'] ?? '',
                'kota'      => $validated['alamat']['kota'] ?? '',
                'provinsi'  => $validated['alamat']['provinsi'] ?? '',
                'kode_pos'  => $validated['alamat']['kode_pos'] ?? '',
            ],
            'spesialisasi'  => $validated['spesialisasi'],
            'jadwal'        => $validated['jadwal'] ?? [],
            'aktif'         => $validated['aktif'],
        ]);

        return redirect()->route('dokter')->with('success', 'Data dokter berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $dokter = DokterModel::findOrFail($id);
        $dokter->delete();

        return redirect()->route('dokter')->with('success', 'Data dokter berhasil dihapus.');
    }
}
