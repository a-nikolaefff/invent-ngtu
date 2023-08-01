<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Building;
use App\Models\BuildingType;
use App\Models\Department;
use App\Models\DepartmentType;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use App\Policies\BuildingPolicy;
use App\Policies\BuildingTypePolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\DepartmentTypePolicy;
use App\Policies\EquipmentPolicy;
use App\Policies\EquipmentTypePolicy;
use App\Policies\RoomPolicy;
use App\Policies\RoomTypePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies
        = [
            User::class => UserPolicy::class,
            DepartmentType::class => DepartmentTypePolicy::class,
            BuildingType::class => BuildingTypePolicy::class,
            RoomType::class => RoomTypePolicy::class,
            EquipmentType::class => EquipmentTypePolicy::class,
            Department::class => DepartmentPolicy::class,
            Building::class => BuildingPolicy::class,
            Room::class => RoomPolicy::class,
            Equipment::class => EquipmentPolicy::class,
        ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
