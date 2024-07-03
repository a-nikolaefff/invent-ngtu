<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRoleEnum;
use App\Filters\UserFilter;
use App\Models\Traits\Filterable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Filterable;

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
            'department_id',
            'post',
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
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }

    /**
     * Get the department of the user.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(UserRoleEnum $roleType): bool
    {
        $userRoleName = $this->role->name;

        return $userRoleName === $roleType->value;
    }

    /**
     * Check if the user has any of the specified roles.
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

    /**
     * Get user list by parameters
     *
     * @param  Builder  $query Database query builder
     * @param  array  $params Filter parameters
     *
     * @throws BindingResolutionException
     */
    public function scopeGetByParams(Builder $query, array $params): void
    {
        $query->select('users.*')
            ->leftjoin(
                'departments',
                'users.department_id',
                '=',
                'departments.id'
            )
            ->with('role', 'department')
            ->filter(new UserFilter($params))
            ->sort($params);
    }

    /**
     * Apply sort
     *
     * @param  Builder  $query Database query builder
     * @param  array  $params Sort parameters
     * @param  string  $defaultSortColumn Default sort column
     * @param  string  $defaultSortDirection Default sort direction
     */
    public function scopeSort(
        Builder $query,
        array $params,
        string $defaultSortColumn = '',
        string $defaultSortDirection = 'asc'
    ): void {
        $sortColumn = $params['sort'] ?? $defaultSortColumn;
        $sortDirection = $params['direction'] ?? $defaultSortDirection;
        $query->when(
            ! empty($sortColumn),
            function ($query) use ($sortColumn, $sortDirection) {
                if ($sortColumn === 'department_name') {
                    return $query->orderBy('departments.name', $sortDirection);
                }

                return $query->orderBy($sortColumn, $sortDirection);
            }
        );
    }

    /**
     * Send password reset notification
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
