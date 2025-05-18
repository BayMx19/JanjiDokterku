<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;


class AppointmentsModel extends Model implements AuditableContract
{
    use HasUuids, SoftDeletes, Auditable;

    protected $table = 'appointments';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'pasien_id',
        'dokter_id',
        'status',
        'catatan',
        'jadwal'
    ];

    protected $casts = [
        'status' => 'string',
        'jadwal' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function jadwalDokter()
    {
        return $this->belongsTo(JadwalDokterModel::class, 'jadwal_dokter_id');
    }

    public function dokter()
    {
        return $this->belongsTo(DokterModel::class, 'dokter_id');
    }

    public function pasien()
    {
        return $this->belongsTo(PasienModel::class, 'pasien_id');
    }
}