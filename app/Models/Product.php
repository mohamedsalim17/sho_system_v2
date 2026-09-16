<?php

namespace App\Models;
use  App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'quantity']; // <-- صلحت القوس هنا

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
