<?php

namespace App\Providers;

use App\Models\BarterRequest;
use App\Policies\BarterRequestPolicy;
use Illuminate\Support\ServiceProvider;

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
        $this->registerPolicies();

        \Gate::define('akses-keuangan', fn($user) => $user->role === 'keuangan');
        \Gate::define('akses-barter', fn($user) => $user->role === 'barter');
    }

    protected function registerPolicies(): void
    {
        \Gate::policy(BarterRequest::class, BarterRequestPolicy::class);
    }
}
