<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\DokterModel;
use App\Models\Jadwal;
use App\Models\PasienModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use OwenIt\Auditing\Models\Audit;

class DashboardController extends Controller
{
    public function index()
    {
        // $user = Auth::user()->role->name;
        // dd($user);
        return Inertia::render('Dashboard', [
            'totalUsers' => User::count(),
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
