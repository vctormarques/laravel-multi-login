<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($role == 'admin' && auth()->user()->role_id != 1) {
            // abort(403);
            Auth::logout();
            return redirect()->route('login')
            ->withInput()
            ->with('erro','Página acessada somente por administrador');
        }

        if ($role == 'contratante' && auth()->user()->role_id != 2) {
            // abort(403);
            Auth::logout();
            return redirect()->route('login')
            ->withInput()
            ->with('erro','Página acessada somente por contratante');
        }

        if ($role == 'financeiro' && auth()->user()->role_id != 3) {
            // abort(403);
            Auth::logout();
            return redirect()->route('login')
            ->withInput()
            ->with('erro','Página acessada somente pelo financeiro');
        }

        return $next($request);
    }
}
