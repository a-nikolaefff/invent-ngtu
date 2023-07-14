<?php

namespace App\Policies;

use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Models\UserRole;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(UserRoleEnum::SuperAdmin, UserRoleEnum::Admin);
    }

    public function view(User $user): bool
    {
        return $user->hasAnyRole(UserRoleEnum::SuperAdmin, UserRoleEnum::Admin);
    }

    public function update(
        User $user,
        User $targetUser,
        int $newTargetUserRoleId = null
    ): bool {
        if ($user->hasRole(UserRoleEnum::SuperAdmin)) {
            if ($targetUser->hasRole(UserRoleEnum::SuperAdmin)) {
                return false;
            }
            if (isset($newTargetUserRoleId)) {
                $superAdminRoleId = UserRole::getRole(UserRoleEnum::SuperAdmin)
                    ->get()->first()->id;
                return $newTargetUserRoleId !== $superAdminRoleId;
            } else {
                return true;
            }
        }

        if ($user->hasRole(UserRoleEnum::Admin)) {
            if ($targetUser->hasAnyRole(
                UserRoleEnum::SuperAdmin,
                UserRoleEnum::Admin
            )
            ) {
                return false;
            }

            if (isset($newTargetUserRoleId)) {
                $AllAdminRoleId = [
                    UserRole::getRole(UserRoleEnum::SuperAdmin)
                        ->get()->first()->id,
                    UserRole::getRole(UserRoleEnum::Admin)
                        ->get()->first()->id,
                ];
                return !in_array(
                    $newTargetUserRoleId,
                    $AllAdminRoleId,
                    true
                );
            } else {
                return true;
            }
        }
        return false;
    }

    public function delete(User $user, User $targetUser): bool
    {
        if ($user->hasRole(UserRoleEnum::SuperAdmin)
            && !$targetUser->hasRole(UserRoleEnum::SuperAdmin)
        ) {
            return true;
        } else {
            if ($user->hasRole(UserRoleEnum::Admin)
                && !$targetUser->hasAnyRole(
                    UserRoleEnum::SuperAdmin,
                    UserRoleEnum::Admin
                )
            ) {
                return true;
            } else {
                return false;
            }
        }
    }
}
