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
     * @param Builder $builder The Builder instance.
     * @param mixed $roleId The role ID.
     * @return void
     */
    public function roleId(Builder $builder, $roleId)
    {
        $builder->where('role_id', $roleId);
    }

    /**
     * Apply the filter based on search keyword.
     *
     * @param Builder $builder The Builder instance.
     * @param string $keyword The search keyword.
     * @return void
     */
    public function search(Builder $builder, $keyword)
    {
        $builder->where(function ($query) use ($keyword) {
            $query->where('name', 'like', "%$keyword%")
                ->orWhere('email', 'like', "%$keyword%");
        });
    }
}
