<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
     protected $table ='companies';
    protected $fillable = ['name','phone','email','website','address','logo','tax_number'];
}

