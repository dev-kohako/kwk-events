<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use App\Models\Event;
use App\Policies\EventPolicy;

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
     * Define any model to policy mappings.
     */
    protected $policies = [
        Event::class => EventPolicy::class,
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Compartilha dados globais com o Inertia
        Inertia::share([
            'flash' => fn () => [
                'success' => session('success'),
                'error' => session('error'),
                'info' => session('info'),
                'shouldDelayRedirect' => session('shouldDelayRedirect'),
            ],
        ]);

        // Define configurações do Vite
        Vite::prefetch(concurrency: 3);
    }
}
