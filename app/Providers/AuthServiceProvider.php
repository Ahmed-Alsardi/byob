<?php

namespace App\Providers;

use App\Policies\CheckoutPolicy;
use App\Policies\ChefPolicy;
use App\Policies\LocationPolicy;
use App\Policies\OrderPolicy;
use App\Repository\OrderRepository;
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
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->checkoutGate();
        $this->locationGate();
        $this->ChefGate();
        $this->ComplaintGate();
        $this->OrderGate();
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

    private function ComplaintGate()
    {
        Gate::define('view-list-complaint', [ComplaintPolicy::class, 'viewList']);
        Gate::define('view-complaint', [ComplaintPolicy::class, 'view']);
        Gate::define('create-complaint', [ComplaintPolicy::class, 'create']);
        Gate::define('store-complaint', [ComplaintPolicy::class, 'store']);
        Gate::define('update-complaint', [ComplaintPolicy::class, 'update']);
    }

    private function OrderGate()
    {
        Gate::define('view-list-order', [OrderPolicy::class, 'viewList']);
        Gate::define('view-order', [OrderPolicy::class, 'view']);
        Gate::define('order-complaint', [OrderPolicy::class, 'orderComplaint']);
        Gate::define('complete-order', [OrderPolicy::class, 'completeOrder']);
        Gate::define('create-complaint', [OrderPolicy::class, 'createComplaint']);
        Gate::define('store-complaint', [OrderPolicy::class, 'storeComplaint']);
    }
}
