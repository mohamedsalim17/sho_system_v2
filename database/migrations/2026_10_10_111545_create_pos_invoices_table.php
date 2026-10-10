<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('pos_invoices', function (Blueprint $table) {
    $table->id();
    $table->foreignId('customer_id')->nullable()->constrained('customers');
    $table->decimal('total', 12, 2);
    $table->decimal('paid', 12, 2)->default(0);
    $table->string('payment_method')->default('cash'); // كاش / بنكك
    $table->foreignId('user_id')->nullable()->constrained('users');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_invoices');
    }
};
