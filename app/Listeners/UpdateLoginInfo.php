<?php
namespace App\Listeners;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\DB;

class UpdateLoginInfo
{
    public function handle(Login $event): void
    {
        $user = $event->user;
        $user->forceFill([
            'last_login_at' => now(),
            'login_count' => ($user->login_count ?? 0) + 1,
        ])->saveQuietly();

        DB::table('login_logs')->insert([
            'user_id' => $user->id,
            'login_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
