<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new Class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // الحقول الزكرناها
            $table->string('national_id')->unique()->nullable()->after('phone'); 
            $table->enum('gender', ['ذكر', 'انثى'])->nullable()->after('national_id'); 
            $table->date('birth_date')->nullable()->after('gender'); 
            $table->string('city')->nullable()->after('birth_date'); 
            $table->string('state')->nullable()->after('city'); 
            $table->string('education_level')->nullable()->after('state'); 
            $table->string('job')->nullable()->after('education_level'); 
            
            // الحقلين الجداد
            $table->date('date_of_death')->nullable()->after('job')->comment('تاريخ الوفاة'); 
            $table->string('place_of_death')->nullable()->after('date_of_death')->comment('مكان الوفاة'); 
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'national_id', 'gender', 'birth_date', 'city', 'state', 
                'education_level', 'job', 'date_of_death', 'place_of_death'
            ]);
        });
    }
};
