<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    protected $table = 'customers';
    protected $fillable = [
        'name','phone','national_id','gender','birth_date',
        'city','state','education_level','job',
        'date_of_death','place_of_death','address'
    ];
    public $timestamps = true;

    public function invoices(){
        return $this->hasMany(Invoice::class, 'customer_id');
    }
}
