<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Http\Composers\ViewComposer');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		$mainService = app(\App\Services\Main\MainService::class);
		
		View::share('settings', $mainService->settings());
		View::share('chatStructuralUnits', $mainService->structuralUnits());
		View::share('chatUsers', $mainService->users());
		
		view()->composer('adminlte::page', function ($view) use($mainService) {
			$view->with('dataNotifications', $mainService->dataNotifications() );    
		});  
    }
}
