<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\DokterModel;
use App\Models\Jadwal;
use App\Models\PasienModel;
use Illuminate\Http\Request;
use Inertia\Inertia;
use OwenIt\Auditing\Models\Audit;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'totalPasien' => PasienModel::count(),
            'totalDokter' => DokterModel::count(),
            // 'totalJadwal' => Jadwal::count(),
            'audits' => Audit::with('user')
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($audit) {
                    return [
                        'id' => $audit->id,
                        'event' => $audit->event,
                        'created_at' => $audit->created_at,
                        'user' => $audit->user ? [
                            'name' => $audit->user->name,
                        ] : null,
                    ];
                }),
        ]);
    }
}
