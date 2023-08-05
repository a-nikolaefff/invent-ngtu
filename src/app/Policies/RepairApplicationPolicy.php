<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\RepairApplication;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RepairApplicationPolicy
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
    public function view(User $user, RepairApplication $repairApplication): bool
    {
        if ($user->hasAnyRole(
            UserRoleEnum::SuperAdmin,
            UserRoleEnum::Admin,
            UserRoleEnum::SupplyAndRepairSpecialist
        )
        ) {
            return true;
        } else {
            if ($user->hasRole(UserRoleEnum::Employee)) {
                return $user->id === $repairApplication->user_id;
            } else {
                return false;
            }
        }
    }

    public function viewUserInformation(User $user): bool
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
            UserRoleEnum::Employee,
        );
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(
        User $user,
        RepairApplication $repairApplication
    ): bool {
        return $user->hasAnyRole(
            UserRoleEnum::SuperAdmin,
            UserRoleEnum::Admin,
            UserRoleEnum::SupplyAndRepairSpecialist,
        );
    }

    /**
     * Determine whether the user can update the model.
     */
    public function manageImages(
        User $user,
        RepairApplication $repairApplication
    ): bool {
        if ($user->hasAnyRole(UserRoleEnum::SuperAdmin, UserRoleEnum::Admin)
        ) {
            return true;
        } else {
            if ($user->hasRole(UserRoleEnum::Employee)) {
                return $user->id === $repairApplication->user_id;
            } else {
                return false;
            }
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(
        User $user,
        RepairApplication $repairApplication
    ): bool {
        if ($user->hasAnyRole(UserRoleEnum::SuperAdmin, UserRoleEnum::Admin)) {
            return true;
        } else {
            if ($user->hasRole(UserRoleEnum::Employee)) {
                return $user->id === $repairApplication->user_id;
            } else {
                return false;
            }
        }
    }
}
