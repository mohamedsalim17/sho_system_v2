<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Customer extends Model {
    protected $fillable = ['name','phone','national_id','gender','birth_date','city','state','education_level','job','address'];
}
