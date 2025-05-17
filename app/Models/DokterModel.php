<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Str;

class DokterModel extends Model implements AuditableContract
{
    use HasUuids, SoftDeletes, Auditable;
    protected $table = 'dokter';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'user_id',
        'NIK',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'spesialisasi',
        'jadwal',
        'aktif',
    ];

    protected $casts = [
        'alamat' => 'array',
        'aktif' => 'boolean',
         'jadwal' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
