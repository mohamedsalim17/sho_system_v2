<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
 Schema::create('users', function($table){
  $table->id();
  $table->string('name');
  $table->string('email')->unique();
  $table->enum('role',['admin','hr','viewer'])->default('hr');
  $table->string('password');
  $table->timestamps();
 });
}
};
