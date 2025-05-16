<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class DokterModel extends Model
{
    use HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;
}
