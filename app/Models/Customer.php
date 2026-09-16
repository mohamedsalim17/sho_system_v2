<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model // class لازم صغيرة c
{
    use HasFactory; // مهمة جدا

    protected $fillable = [
        'name', 
        'phone', 
        'address', 
        'email',
        'national_id', 
        'gender', 
        'birth_date', 
        'city',
        'state', 
        'education_level', 
        'job', 
        'date_of_death', 
        'place_of_death' // صلحتها: كانت pleace
    ];

    public function invoices() // خليها جمع عشان العلاقة hasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
