<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use App\Listeners\UpdateLoginInfo;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            UpdateLoginInfo::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
