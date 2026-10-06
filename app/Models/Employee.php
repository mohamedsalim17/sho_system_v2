<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $fillable = [
        'employee_no',
        'national_id',
        'name',
        'phone',
        'birth_date',
        'death_date',
        'death_place',
        'marital_status',
        'job_title',
        'department',
        'salary',
        'hire_date',
        'state',
        'city',
        'neighborhood',
        'street',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'hire_date' => 'date',
    ];
}
