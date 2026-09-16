<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            
            // البيانات الاساسية
            $table->string('employee_no')->unique()->comment('الرقم الوظيفي');
            $table->string('national_id')->unique()->nullable()->comment('الرقم الوطني');
            $table->string('name')->comment('الاسم');
            $table->string('phone')->nullable()->comment('رقم الهاتف');
            
            // البيانات الشخصية الجديدة
            $table->date('birth_date')->nullable()->comment('تاريخ الميلاد');
            $table->date('death_date')->nullable()->comment('تاريخ الوفاة');
            $table->enum('marital_status', ['single', 'married'])->default('single')->comment('الحالة الاجتماعية');
            
            // بيانات الوظيفة
            $table->string('job_title')->nullable()->comment('الوظيفة');
            $table->string('department')->nullable()->comment('القسم');
            $table->decimal('salary', 10, 2)->nullable()->comment('الراتب');
            $table->date('hire_date')->nullable()->comment('تاريخ التعيين');
            
            // بيانات العنوان
            $table->string('state')->nullable()->comment('الولاية');
            $table->string('city')->nullable()->comment('المدينة');
            $table->string('neighborhood')->nullable()->comment('الحي');
            $table->string('street')->nullable()->comment('الشارع');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
