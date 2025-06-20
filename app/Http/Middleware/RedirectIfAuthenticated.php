<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware для перенаправления авторизованных пользователей
 * 
 * Если пользователь авторизован и пытается зайти на страницу для гостей,
 * его перенаправляет на страницу админ-панели
 */
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$guards): mixed
    {
        // Если guards не указаны, используем null (default guard)
        $guards = empty($guards) ? [null] : $guards;

        // Для каждого указанного guard проверяем авторизацию
        foreach ($guards as $guard) {
            // Если пользователь авторизован
            if (Auth::guard($guard)->check()) {
                // Для отладки:
                // dd('Пользователь авторизован: ' . Auth::guard($guard)->user()->name);
                // dd('Редирект на ' . route('admin.dashboard'));
                
                // Вариант 1: просто редирект на дашборд админки
                return redirect(route('admin.dashboard'));
                
                // Вариант 2: редирект с флеш сообщением (можно использовать позже)
                // return redirect()->route('admin.dashboard')->with('info', 'Вы уже вошли в систему');
            }
        }

        // Если пользователь не авторизован, пропускаем запрос дальше по цепочке middleware
        return $next($request);
    }
} 