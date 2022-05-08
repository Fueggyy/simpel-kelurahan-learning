<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->register();
        
        Gate::define('1', function ($user) {
            if ($user->roles->id == '1') {
                return true;
            }
            return false;
        });
        
        Gate::define('2', function ($user) {
            if ($user->roles->id == '2') {
                return true;
            }
            return false;
        });
    }
}
