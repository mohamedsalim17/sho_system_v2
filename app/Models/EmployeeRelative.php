<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeRelative extends Model
{
    protected $fillable = [
        'employee_id',
        'name',
        'relation',
        'national_id',
        'birth_date',
        'death_date',
        'death_place',
        'phone',
        'gender',
        'is_dependent',
        'bank_account_no',
        'bank_account_name',
        'bank_name',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'is_dependent' => 'boolean',
    ];
}
