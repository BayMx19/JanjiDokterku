<?php

namespace App\Http\Controllers;

use App\Models\AppointmentsModel;
use App\Models\DokterModel;
use App\Models\JadwalDokterModel;
use App\Models\PasienModel;
use App\Models\RekamMedisModel;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;
class AppointmentController extends Controller
{
   public function index()
{
    $appointments = AppointmentsModel::with(['pasien.user', 'dokter.user'])->get();
    // dd($appointments);
    $appointments->transform(function($item) {
        $item->jadwal = json_decode($item->jadwal);
        return $item;
    });

    return Inertia::render('Appointments/Index', [
        'appointments' => $appointments,
    ]);
}

    public function create()
    {
        $pasien = PasienModel::with('user')->get();
        $pasienList = $pasien->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->user ? $p->user->name : 'Nama tidak tersedia',
            ];
        });
        $dokters = DokterModel::with('user')->where('aktif', true)->get();

        return Inertia::render('Appointments/Create', [
            'pasien' => $pasienList,
            'dokters' => $dokters,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|uuid|exists:pasien,id',
            'dokter_id' => 'required|uuid|exists:dokter,id',
            'jadwal' => 'nullable|json',
            'status' => 'required|in:belum visit,sudah visit',
            'catatan' => 'nullable|string',
        ]);

        AppointmentsModel::create([
            'id' => Str::uuid(),
            'pasien_id' => $request->pasien_id,
            'dokter_id' => $request->dokter_id,
            'jadwal' => $request->jadwal,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('appointments')->with('success', 'Appointment berhasil ditambahkan');
    }
    public function edit($id)
    {
        $appointment = AppointmentsModel::with(['dokter.user', 'pasien.user'])->findOrFail($id);

        $audits = $appointment->audits()->with('user')->latest()->get();

        $dokters = DokterModel::with('user')->get();
        $pasiens = PasienModel::with('user')->get();
        $pasienList = $pasiens->map(function($p) {
            return [
                'id' => $p->id,
                'name' => $p->user->name ,
            ];
        });
        // dd($appointment);
        return Inertia::render('Appointments/Edit', [
            'appointment' => $appointment,
            'audits' => $audits,
            'dokters' => $dokters,
            'pasien' => $pasienList,
        ]);
    }



    public function update(Request $request, $id)
    {
        $appointment = AppointmentsModel::findOrFail($id);
        // dd($request);
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'dokter_id' => 'required|exists:dokter,id',
            'jadwal' => 'required|json',
            'status' => 'required',
            'catatan' => 'nullable|string',
        ]);

        $appointment->update([
            'pasien_id' => $validated['pasien_id'],
            'dokter_id' => $validated['dokter_id'],
            'jadwal' => $validated['jadwal'],
            'status' => $validated['status'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()->route('appointments')->with('success', 'Data janji temu berhasil diperbarui.');
     }
    public function detail($id)
        {
            $appointment = AppointmentsModel::with(['dokter.user', 'pasien.user'])->findOrFail($id);

            $audits = $appointment->audits()->with('user')->latest()->get();

            $dokters = DokterModel::with('user')->get();
            $pasiens = PasienModel::with('user')->get();
            $pasienList = $pasiens->map(function($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->user->name ,
                ];
            });
            // dd($appointment);
            return Inertia::render('Appointments/Detail', [
                'appointment' => $appointment,
                'audits' => $audits,
                'dokters' => $dokters,
                'pasien' => $pasienList,
            ]);
        }

        public function storeRekamMedis(Request $request, $appointmentId)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'diagnosa' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'resep' => 'nullable|string',
            'catatan' => 'nullable|string',
            'pencatat' => 'required|string|max:255',
            'appointment_id' => 'required|exists:appointments,id',
        ]);

        $appointment = AppointmentsModel::findOrFail($appointmentId);

        RekamMedisModel::create([
            'id' => Str::uuid(),
            'user_id' => $appointment->pasien->user_id,
            'tanggal' => $request->tanggal,
            'diagnosa' => $request->diagnosa,
            'tindakan' => $request->tindakan,
            'resep' => $request->resep,
            'catatan' => $request->catatan,
            'appointment_id' => $appointment->id,
            'pencatat' => $request->pencatat,
            'appointment_id' => $appointmentId,
        ]);

        return redirect()->route('appointments.detail', $appointmentId)
            ->with('success', 'Rekam medis berhasil ditambahkan');
    }
    public function destroy($id)
        {
            $appointment = AppointmentsModel::findOrFail($id);
            $appointment->delete();

            return redirect()->route('appointments')->with('success', 'Data appointment berhasil dihapus.');
        }
}