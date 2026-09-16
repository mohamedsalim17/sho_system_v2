<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
   protected $fillable = ['customer_id','invoice_date','total_amount','notes'];

    public function customer()
    (
      return $this->belongs(customer::class);
    )

     public function items()
    (
     return $this->hasMany(InvoiceItems::class);
    )
}
