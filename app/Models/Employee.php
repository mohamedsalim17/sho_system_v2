<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'employee_no',     'الرقم_الوظيفي',  
        'national_id',  // دا كان ناقص
        'name', 'الاسم_الكامل',
        'phone',
        'birth_date',           'تاريخ_الميلاد', // دا كان ناقص
        'death_date',         'تاريخ_الوفاة',, // دا كان ناقص
        'marital_status', 'الحالة_الاجتماعية',
        'job_title',            'الوظيفة',// عندك في الجدول job_title مش department بس
        'department',         'القسم',
        'salary',         'الراتب',
        'hire_date', 'تاريخ_التعيين',
        'state',         'العنوان'
        'city',         'المدينة'
        'neighborhood',        'الحي'
        'street',          'الشارع'
    ];

    public function relatives()
    {
        return $this->hasMany(EmployeeRelative::class);
    }
}
