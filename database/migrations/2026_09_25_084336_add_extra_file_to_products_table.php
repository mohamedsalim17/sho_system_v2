<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('products', function (Blueprint $table) {
        $table->string('category')->nullable()->after('name');
        $table->decimal('buy_price', 10, 2)->nullable()->after('price');
        $table->string('unit')->default('قطعة')->after('quantity');
        $table->string('barcode')->nullable()->unique()->after('unit');
        $table->string('supplier')->nullable()->after('barcode');
        $table->date('expiry_date')->nullable()->after('supplier');
    });
}

};
