<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('login_logs')) {
            Schema::create('login_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->timestamp('login_at')->nullable();
                $table->string('ip_address')->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamps();
            });
            return;
        }

        Schema::table('login_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('login_logs', 'login_at')) {
                $table->timestamp('login_at')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('login_logs', 'ip_address')) {
                $table->string('ip_address')->nullable()->after('login_at');
            }
            if (!Schema::hasColumn('login_logs', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }
        });
    }

    public function down(): void {}
};
