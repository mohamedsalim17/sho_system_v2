<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // لو ما عندو role اصلاً اعتبرو cashier
        if (!$userRole) {
            $userRole = 'cashier';
        }

        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        abort(403, 'ليس لديك صلاحية - هذه الصفحة للأدمن فقط');
    }
}
