<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\EquipmentType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipmentTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(
            UserRoleEnum::SuperAdmin,
            UserRoleEnum::Admin,
            UserRoleEnum::SupplyAndRepairSpecialist,
        );
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EquipmentType $equipmentType): bool
    {
        return $user->hasAnyRole(
            UserRoleEnum::SuperAdmin,
            UserRoleEnum::Admin,
            UserRoleEnum::SupplyAndRepairSpecialist,
        );
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(
            UserRoleEnum::SuperAdmin,
            UserRoleEnum::Admin,
            UserRoleEnum::SupplyAndRepairSpecialist,
        );
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EquipmentType $equipmentType): bool
    {
        return $user->hasAnyRole(
            UserRoleEnum::SuperAdmin,
            UserRoleEnum::Admin,
            UserRoleEnum::SupplyAndRepairSpecialist,
        );
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EquipmentType $equipmentType): bool
    {
        return $user->hasAnyRole(
            UserRoleEnum::SuperAdmin,
            UserRoleEnum::Admin,
            UserRoleEnum::SupplyAndRepairSpecialist,
        );
    }
}
