<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\DepartmentType;
use App\Models\User;

class DepartmentTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(UserRoleEnum::SuperAdmin, UserRoleEnum::Admin);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DepartmentType $departmentType): bool
    {
        return $user->hasAnyRole(UserRoleEnum::SuperAdmin, UserRoleEnum::Admin);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(UserRoleEnum::SuperAdmin, UserRoleEnum::Admin);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DepartmentType $departmentType): bool
    {
        return $user->hasAnyRole(UserRoleEnum::SuperAdmin, UserRoleEnum::Admin);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DepartmentType $departmentType): bool
    {
        return $user->hasAnyRole(UserRoleEnum::SuperAdmin, UserRoleEnum::Admin);
    }
}
