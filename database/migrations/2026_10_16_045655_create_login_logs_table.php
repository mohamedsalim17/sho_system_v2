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
       Schema::create('login_logs', function($t){
  $t->id(); $t->foreignId('user_id')->constrained(); $t->string('ip'); $t->timestamps();
  });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};
