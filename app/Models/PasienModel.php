<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Str;

class PasienModel extends Model implements AuditableContract
{
    use HasUuids, SoftDeletes, Auditable;
    protected $table = 'pasien';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'tanggal_lahir',
        'alamat',
        'user_id',
        'NIK',
        'jenis_kelamin',
        'ktp'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'alamat' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    //     public function appointments()
    // {
    //     return $this->hasMany(AppointmentsModel::class, 'pasien_id');
    // }

}
