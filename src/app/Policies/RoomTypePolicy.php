<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RoomTypePolicy
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
    public function view(User $user, RoomType $roomType): bool
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
    public function update(User $user, RoomType $roomType): bool
    {
        return $user->hasAnyRole(UserRoleEnum::SuperAdmin, UserRoleEnum::Admin);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RoomType $roomType): bool
    {
        return $user->hasAnyRole(UserRoleEnum::SuperAdmin, UserRoleEnum::Admin);
    }
}
