<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class RolesModel extends Model
{
    use HasUuids;
    protected $table = 'roles';
    protected $keyType = 'string';
    public $incrementing = false;

}
