<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Настройка перенаправления на страницу входа при попытке доступа
        // к защищенным маршрутам без аутентификации
        $this->app->bind(
            \Illuminate\Foundation\Exceptions\Handler::class,
            function (Application $app) {
                return tap($app->make(\Illuminate\Foundation\Exceptions\Handler::class), function ($handler) {
                    $handler->renderable(function (AuthenticationException $exception) {
                        if (request()->expectsJson()) {
                            return response()->json(['message' => 'Требуется аутентификация.'], 401);
                        }

                        return redirect()->guest(route('login'));
                    });
                });
            }
        );
    }
}
