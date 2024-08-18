<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Blade;
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
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });


        Gate::define("level1", function (User $user): bool {
            if ($user->user_type == 1) {
                return true;
            } else {
                return false;
            }
        });

        Gate::define("level2", function (User $user): bool {
            if ($user->user_type == 2 || $user->user_type == 1) {
                return true;
            } else {
                return false ;
            }
        });

        Gate::define("level3", function (User $user): bool {
            return true;
        });
    }
}
