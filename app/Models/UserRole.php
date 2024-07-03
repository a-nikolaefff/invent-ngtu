<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserRole extends Model
{
    /**
     * The name of the table in the database
     *
     * @var string
     */
    protected $table = 'user_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    /**
     * Get the users associated with the role.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }

    /**
     * Get a role by role type.
     */
    public function scopeGetRole(Builder $query, UserRoleEnum $roleType): void
    {
        $query->where('name', $roleType->value)->first();
    }

    /**
     * Get all roles except a specific role type.
     *
     * @param  Builder  $query Database query builder
     * @param  array<UserRoleEnum>|UserRoleEnum  $roleTypes Excluder roles or a role
     */
    public function scopeAllRolesExcept(
        Builder $query,
        array|UserRoleEnum $roleTypes
    ): void {
        if (is_array($roleTypes)) {
            $roleValues = array_map(function ($roleType) {
                return $roleType->value;
            }, $roleTypes);

            $query->whereNotIn('name', $roleValues);
        } else {
            $query->where('name', '!=', $roleTypes->value);
        }
    }
}
