<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Product extends Model {
    protected $fillable = ['name','barcode','category','unit','purchase_price','price','quantity','description'];
}
