<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\BurgerCustomization;
use App\Models\Complaint;
use App\Policies\BurgerCustomizationPolicy;
use App\Policies\ComplaintPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Complaint::class => ComplaintPolicy::class,
        BurgerCustomization::class => BurgerCustomizationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->checkoutGate();
        $this->locationGate();
    }

    public function checkoutGate(): void
    {
        Gate::define('create-checkout', 'App\Policies\CheckoutPolicy@create');
        Gate::define('store-checkout', 'App\Policies\CheckoutPolicy@store');
        Gate::define('success-checkout', 'App\Policies\CheckoutPolicy@success');
        Gate::define('cancel-checkout', 'App\Policies\CheckoutPolicy@cancel');
    }

    public function locationGate() {
        Gate::define('create-location', 'App\Policies\LocationPolicy@create');
        Gate::define('store-location', 'App\Policies\LocationPolicy@store');
    }
}
