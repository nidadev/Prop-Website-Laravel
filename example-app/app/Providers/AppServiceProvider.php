<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton("subscription_helper",function(){
return new \App\Helpers\SubscriptionHelper();
        });
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrapFive();
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $request = app('request');
            $settings = $request->attributes->get('propelyze_site_settings');
            if ($settings === null) {
                $settings = \Illuminate\Support\Facades\Schema::hasTable('site_settings')
                    ? \Illuminate\Support\Facades\DB::table('site_settings')->pluck('value', 'key')->all() : [];
                $request->attributes->set('propelyze_site_settings', $settings);
            }
            $view->with('siteSettings', $settings);
        });
    }
}
