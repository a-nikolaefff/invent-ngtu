<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * User service
 */
class UserService
{
    public function update(User $user, array $data): void
    {
        $data['updated_by_user_id'] = Auth::user()->id;
        $user->fill($data)->save();
    }
}
