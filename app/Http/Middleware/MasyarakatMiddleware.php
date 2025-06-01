<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MasyarakatMiddleware
{
    public function handle(Request $request, Closure $next)
{
    \Log::info('User role di middleware masyarakat: ' . (auth()->check() ? auth()->user()->role : 'guest'));

    if (auth()->check() && auth()->user()->role === 'masyarakat') {
        return $next($request);
    }

    return redirect('/')->with('error', 'Akses ditolak. Anda bukan masyarakat.');
}

}
