<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $currentRouteAction = Route::currentRouteAction();
            $controllerName = '';
    
            if (Str::contains($currentRouteAction, '@')) {
                [, $method] = explode('@', $currentRouteAction);
                $controllerName = '/ ' . preg_replace('/([a-z])([A-Z])/', '$1 $2', Str::studly(class_basename($method)));
            }

            // Share the controller name with all views
            $view->with('currentController', $controllerName);
        });
    }
}
