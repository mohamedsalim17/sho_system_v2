<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeRelative extends Model
{
    protected $fillable = [
        'employee_id', 'name', 'relation', 'national_id', 'birth_date', 'phone', 
        'gender', 'is_dependent', 'bank_account_no', 'bank_account_name', 'bank_name'
    ];

    // علاقة متعدد لواحد: القريب تابع لموظف واحد
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
