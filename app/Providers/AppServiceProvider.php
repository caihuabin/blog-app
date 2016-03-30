<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth, View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //view()->share('citys', \App\Models\City::allLevelUp());

        View::composer('*', function($view)
        {
            if(Auth::check()){
                $view->with('currentUser', Auth::user());
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
