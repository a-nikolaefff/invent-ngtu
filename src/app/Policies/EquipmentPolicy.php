<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EquipmentPolicy
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
            UserRoleEnum::Employee,
        );
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Equipment $equipment): bool
    {
        if ($user->hasAnyRole(
            UserRoleEnum::SuperAdmin,
            UserRoleEnum::Admin,
            UserRoleEnum::SupplyAndRepairSpecialist
        )
        ) {
            return true;
        } else {
            $userDepartment = $user->department;
            $equipmentDepartment = $equipment->room->department;
            $departments = $userDepartment->getSelfAndDescendants();
            if ($departments->contains('id', $equipmentDepartment->id)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(
            UserRoleEnum::SuperAdmin,
            UserRoleEnum::Admin,
            UserRoleEnum::SupplyAndRepairSpecialist
        );
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Equipment $equipment): bool
    {
        return $user->hasAnyRole(
            UserRoleEnum::SuperAdmin,
            UserRoleEnum::Admin,
            UserRoleEnum::SupplyAndRepairSpecialist
        );
    }

    /**
     * Determine whether the user can delete the model.
     */

    public function delete(User $user, Equipment $equipment): bool
    {
        return $user->hasAnyRole(
            UserRoleEnum::SuperAdmin,
            UserRoleEnum::Admin,
            UserRoleEnum::SupplyAndRepairSpecialist
        );
    }
}
