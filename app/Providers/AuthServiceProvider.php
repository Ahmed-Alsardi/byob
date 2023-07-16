<?php

namespace App\Providers;

use App\Policies\CheckoutPolicy;
use App\Policies\ChefPolicy;
use App\Policies\LocationPolicy;
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
        $this->ChefGate();
    }

    public function checkoutGate(): void
    {
        Gate::define('create-checkout', [CheckoutPolicy::class, 'create']);
        Gate::define('store-checkout', [CheckoutPolicy::class, 'store']);
        Gate::define('success-checkout', [CheckoutPolicy::class, 'success']);
        Gate::define('cancel-checkout', [CheckoutPolicy::class, 'cancel']);
    }

    public function locationGate() {
        Gate::define('create-location', [LocationPolicy::class, 'create']);
        Gate::define('store-location', [LocationPolicy::class, 'store']);
    }

    public function ChefGate() {
        Gate::define("view-list-chef", [ChefPolicy::class, 'viewList']);
        Gate::define('view-chef', [ChefPolicy::class, 'view']);
        Gate::define('create-chef', [ChefPolicy::class, 'create']);
        Gate::define('store-chef', [ChefPolicy::class, 'store']);
        Gate::define('update-chef', [ChefPolicy::class, 'update']);
        Gate::define('delete-chef', [ChefPolicy::class, 'delete']);
        Gate::define('update-available', [ChefPolicy::class, 'updateAvailable']);
    }
}
