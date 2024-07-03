<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a user filter.
 */
class UserFilter extends AbstractFilter
{
    public const ROLE_ID = 'role_id';

    public const SEARCH = 'search';

    /**
     * {@inheritDoc}
     */
    protected function getCallbacks(): array
    {
        return [
            self::ROLE_ID => [$this, 'roleId'],
            self::SEARCH => [$this, 'search'],
        ];
    }

    /**
     * Apply the filter based on role ID.
     *
     * @param  Builder  $builder The Builder instance.
     * @param  string|int  $roleId The role ID.
     */
    public function roleId(Builder $builder, string|int $roleId): void
    {
        $builder->where('role_id', $roleId);
    }

    /**
     * Apply the filter based on search keyword.
     *
     * @param  Builder  $builder The Builder instance.
     * @param  string  $keyword The search keyword.
     */
    public function search(Builder $builder, string $keyword): void
    {
        $builder->where(function ($query) use ($keyword) {
            $query->where('users.name', 'ilike', "%$keyword%")
                ->orWhere('email', 'ilike', "%$keyword%")
                ->orWhere('departments.name', 'ilike', "%$keyword%")
                ->orWhere('departments.short_name', 'ilike', "%$keyword%");
        });
    }
}
