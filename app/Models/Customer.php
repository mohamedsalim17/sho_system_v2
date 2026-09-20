<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'national_id',
        'gender',
        'birth_date',
        'city',
        'state',
        'education_level',
        'job',
        'date_of_death',
        'place_of_death',
        'address'
    ];
}
