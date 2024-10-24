<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\UserRoleEnum;
use App\Models\User;
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
        Gate::define('viewAdminPanel', function (User $user) {

            return $user->hasAnyRole(
                UserRoleEnum::SuperAdmin,
                UserRoleEnum::Admin,
                UserRoleEnum::SupplyAndRepairSpecialist
            );
        });
    }
}
