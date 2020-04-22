<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('Admin', function($user){
            return $user->role == 'admin';
                    });
    $this->registerPolicies();
     Gate::define('Chef', function($user){
     return $user->role === 'chef de projet';
    });
     $this->registerPolicies();
       Gate::define('User', function($user){
        if($user->role!=='admin ' || $user->role!=='chef de projet'){
            return true;
        }
          });
          $this->registerPolicies();
      
          Gate::define('Client', function($user){
            return $user->role === 'client';
         });
         $this->registerPolicies();
      
         Gate::define('AdminClient', function($user){
           return $user->role === 'admin' || $user->role === 'client';
        });
        $this->registerPolicies();
      
        Gate::define('UserClient', function($user){
       if($user->role!=='admin ' || $user->role!=='chef de projet'){
           return true;
       }
         });

        Passport::routes();
        //
    }
}
