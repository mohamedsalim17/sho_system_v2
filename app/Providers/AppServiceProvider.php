<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Models\Company;
use App\Listeners\UpdateLoginInfo;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // 1. مشاركة بيانات الشركة في كل الصفحات
        try {
            View::share('companyInfo', Company::first());
        } catch (\Exception $e) {
            View::share('companyInfo', null);
        }

        // 2. تتبع دخول المستخدمين - نهائي
        Event::listen(Login::class, UpdateLoginInfo::class);
    }
}
