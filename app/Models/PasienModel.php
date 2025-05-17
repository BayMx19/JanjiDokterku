<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PasienModel extends Model
{
    use HasUuids;
    protected $table = 'pasien';

    protected $keyType = 'string';
    public $incrementing = false;
}
