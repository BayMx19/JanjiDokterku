<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JadwalDokterModel extends Model
{
    protected $table = 'jadwal_dokter';

    public $incrementing = false; // UUID bukan auto increment
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'dokter_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'is_available',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_available' => 'boolean',
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

    public function dokter()
    {
        return $this->belongsTo(DokterModel::class, 'dokter_id');
    }

    public function appointments()
    {
        return $this->hasMany(AppointmentsModel::class, 'jadwal_dokter_id');
    }
}
