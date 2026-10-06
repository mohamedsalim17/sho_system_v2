<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::table('employees', function (Blueprint $table) {
        if (!Schema::hasColumn('employees', 'death_place')) {
            $table->string('death_place')->nullable()->after('death_date')->comment('مكان الوفاة');
        }
        if (!Schema::hasColumn('employees', 'death_date')) {
            $table->date('death_date')->nullable()->comment('تاريخ الوفاة');
        }
    });
}

};
