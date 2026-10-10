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
    Schema::create('treasuries', function (Blueprint $table) {
    $table->id();
    $table->string('name'); // اسم الخزنة
    $table->decimal('balance', 12, 2)->default(0); // الرصيد
    $table->enum('type', ['in', 'out'])->default('in'); // وارد / منصرف
    $table->text('notes')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasuries');
    }
};
