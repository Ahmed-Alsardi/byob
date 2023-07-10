<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
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
        //
    }
}
