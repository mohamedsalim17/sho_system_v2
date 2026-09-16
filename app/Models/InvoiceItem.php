<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = ['invoice_id','produc_id','quantity','price','subtotal'];

     public function invoice()
     {
        return $this->belongs(Invoice::class);
     }
     
     public function product()
     {
        return $this->belongsTo(product::class); 
     }

}
