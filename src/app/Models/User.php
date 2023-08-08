<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRoleEnum;
use App\Filters\UserFilter;
use App\Models\Interfaces\GetByParams;
use App\Models\Traits\Filterable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, GetByParams
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
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }

    /**
     * Get the department of the user.
     *
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
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

    public function scopeGetByParams(Builder $query, array $queryParams): void
    {
        $filter = app()->make(
            UserFilter::class,
            ['queryParams' => $queryParams]
        );

        $query->select('users.*')
            ->leftjoin(
                'departments',
                'users.department_id',
                '=',
                'departments.id'
            )
            ->with('role', 'department')
            ->filter($filter)
            ->sort($queryParams);
    }

    public function scopeSort(
        Builder $query,
        array $queryParams,
        string $defaultSortColumn = '',
        string $defaultSortDirection = 'asc'
    ): void {
        $sortColumn = $queryParams['sort'] ?? $defaultSortColumn;
        $sortDirection = $queryParams['direction'] ?? $defaultSortDirection;
        $query->when(
            !empty($sortColumn),
            function ($query) use ($sortColumn, $sortDirection) {
                if ($sortColumn === 'department_name') {
                    return $query->orderBy('departments.name', $sortDirection);
                }
                return $query->orderBy($sortColumn, $sortDirection);
            }
        );
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
