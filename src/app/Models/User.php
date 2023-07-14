<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRoleEnum;
use App\Models\Traits\Filterable;
use App\Models\Traits\Sortable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Filterable, Sortable;

    /**
     * The name of the table in the database
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'name',
            'email',
            'password',
            'role_id',
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get current role of the user.
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }

    /**
     * Check if the user has a specific role.
     *
     * @param UserRoleEnum $roleType
     *
     * @return bool
     */
    public function hasRole(UserRoleEnum $roleType): bool
    {
        $userRoleName = $this->role->name;
        return $userRoleName === $roleType->value;
    }

    /**
     * Check if the user has any of the specified roles.
     *
     * @param UserRoleEnum ...$roleTypes
     *
     * @return bool
     */
    public function hasAnyRole(UserRoleEnum ...$roleTypes): bool
    {
        $userRoleName = $this->role->name;
        foreach ($roleTypes as $roleType) {
            if ($userRoleName === $roleType->value) {
                return true;
            }
        }
        return false;
    }
}
