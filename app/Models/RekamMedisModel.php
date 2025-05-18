<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class RekamMedisModel extends Model implements AuditableContract
{
    use HasFactory, HasUuids, SoftDeletes, Auditable;

    protected $table = 'rekam_medis';

    protected $keyType = 'string'; // karena pakai UUID
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'tanggal',
        'diagnosa',
        'tindakan',
        'resep',
        'catatan',
        'pencatat',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
