<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'nik',
        'email',
        'role',
        'status',
        'pin_hash',
        'pin_set',
    ];
}