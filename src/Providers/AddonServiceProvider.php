<?php

namespace Ant\StatementAnalyzer\Providers;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
{
    /**
     * Register any addon services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Bootstrap any addon services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'statement-analyzer');
        $this->publishes([
            __DIR__.'/../../resources/views' => base_path('resources/views/vendor/statement-analyzer'),
        ]);
        $this->publishes([
            __DIR__.'/../../public' => '../public/vendor/statement-analyzer',
        ], 'statement-analyzer');
    }
}