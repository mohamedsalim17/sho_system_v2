<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_relatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade')->comment('رقم الموظف');
            
            // البيانات الاساسية للقريب
            $table->string('name')->comment('اسم القريب');
            $table->string('relation')->comment('صلة القرابة'); // ابن, بنت, زوجة, اب, ام
            $table->string('national_id')->nullable()->comment('الرقم الوطني');
            $table->date('birth_date')->nullable()->comment('تاريخ الميلاد');
            $table->string('phone')->nullable()->comment('رقم الهاتف');
            $table->enum('gender', ['male', 'female'])->nullable()->comment('النوع');
            $table->boolean('is_dependent')->default(false)->comment('معال؟ نعم/لا');
            
            // بيانات البنك للدعم - الجديدة
            $table->string('bank_account_no')->nullable()->comment('رقم حساب البنك');
            $table->string('bank_account_name')->nullable()->comment('اسم صاحب الحساب');
            $table->string('bank_name')->nullable()->comment('اسم البنك');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_relatives');
    }
};
