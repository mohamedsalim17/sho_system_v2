<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Customer extends Model {
 protected $table = 'customers';
 protected $fillable = [
 'employee_no','national_id','name','phone','birth_date',
 'death_date','death_place','marital_status','job_title',
 'department','salary','hire_date','state','city','neighborhood','street'
 ];
 public $timestamps = true;
}
