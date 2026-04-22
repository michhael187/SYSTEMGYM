<?php

namespace App\Providers;

use App\Models\Membresia;
use App\Policies\MembresiaPolicy;
use App\Policies\InformePolicy;
use App\Models\Pago;
use App\Policies\PagoPolicy;
use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Pago::class, PagoPolicy::class);
        Gate::policy(Membresia::class, MembresiaPolicy::class);
        Gate::define('viewFinancialReport', [InformePolicy::class,'viewFinancial']);

    }
}
