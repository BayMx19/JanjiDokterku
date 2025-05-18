<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Auditable;
use Illuminate\Support\Str;

class RolesModel extends Model implements AuditableContract
{
    use HasUuids, HasFactory, SoftDeletes, Auditable;
    protected $table = 'roles';
    protected $keyType = 'string';
    public $incrementing = false;
     protected $fillable = [
        'id',
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}