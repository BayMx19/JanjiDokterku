<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AppointmentModel extends Model
{
    use HasUuids;
    protected $table = 'appointment';
    protected $keyType = 'string';
    public $incrementing = false;
}
