<?php

namespace App\Providers;

use App\Services\Tickets\Processors\ObramatTicketProcessor;
use App\Services\Tickets\TicketProcessorRegistry;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        $this->app->singleton(TicketProcessorRegistry::class, function ($app) {
            return new TicketProcessorRegistry([
                $app->make(ObramatTicketProcessor::class),
            ]);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
