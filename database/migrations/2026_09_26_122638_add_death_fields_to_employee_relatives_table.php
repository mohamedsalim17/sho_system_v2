<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
 Schema::table('employee_relatives', function($t){
  $t->date('death_date')->nullable()->after('birth_date');
  $t->string('death_place')->nullable()->after('death_date');
 });
}
public function down(): void {
 Schema::table('employee_relatives', function($t){
  $t->dropColumn(['death_date','death_place']);
 });
}

};
