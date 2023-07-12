<?php

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
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id');
    }

    /**
     * Get a role by role type.
     *
     * @param Builder      $query
     * @param UserRoleEnum $roleType
     *
     * @return void
     */
    public function scopeGetRole(Builder $query, UserRoleEnum $roleType): void
    {
        $query->where('name', $roleType->value)->first();
    }

    /**
     * Get all roles except a specific role type.
     *
     * @param Builder      $query
     * @param UserRoleEnum $roleType
     *
     * @return void
     */
    public function scopeAllRolesExcept(
        Builder $query,
        UserRoleEnum $roleType
    ): void {
        $query->where('name', '!=', $roleType->value);
    }
}
