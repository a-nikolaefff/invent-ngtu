<?php

declare(strict_types=1);

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Building;
use App\Models\BuildingType;
use App\Models\Department;
use App\Models\DepartmentType;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Repair;
use App\Models\RepairApplication;
use App\Models\RepairType;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use App\Policies\BuildingPolicy;
use App\Policies\BuildingTypePolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\DepartmentTypePolicy;
use App\Policies\EquipmentPolicy;
use App\Policies\EquipmentTypePolicy;
use App\Policies\RepairApplicationPolicy;
use App\Policies\RepairPolicy;
use App\Policies\RepairTypePolicy;
use App\Policies\RoomPolicy;
use App\Policies\RoomTypePolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies
        = [
            DepartmentType::class => DepartmentTypePolicy::class,
            BuildingType::class => BuildingTypePolicy::class,
            RoomType::class => RoomTypePolicy::class,
            EquipmentType::class => EquipmentTypePolicy::class,
            RepairType::class => RepairTypePolicy::class,
            User::class => UserPolicy::class,
            Department::class => DepartmentPolicy::class,
            Building::class => BuildingPolicy::class,
            Room::class => RoomPolicy::class,
            Equipment::class => EquipmentPolicy::class,
            Repair::class => RepairPolicy::class,
            RepairApplication::class => RepairApplicationPolicy::class,
        ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject(__('email.verification.subject'))
                ->greeting(__('email.greeting'))
                ->line(__('email.verification.description'))
                ->action(__('email.verification.action'), $url)
                ->salutation(__('email.salutation'));
        });
    }
}
