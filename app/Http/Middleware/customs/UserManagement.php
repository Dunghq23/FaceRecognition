<?php

namespace App\Http\Middleware\customs;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserManagement
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $fullAccess = Auth::user()->roles->where('role_id', 1)->first();

        if(!$fullAccess) {
            return redirect()->back()->with('error', 'Bạn không có quyền truy cập!');
        }

        return $next($request);
    }
}
