<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a department filter.
 */
class DepartmentFilter extends AbstractFilter
{
    public const DEPARTMENT_TYPE_ID = 'department_type_id';

    public const SEARCH = 'search';

    /**
     * {@inheritDoc}
     */
    protected function getCallbacks(): array
    {
        return [
            self::DEPARTMENT_TYPE_ID => [$this, 'departmentType'],
            self::SEARCH => [$this, 'search'],
        ];
    }

    /**
     * Apply the filter based on department type ID.
     *
     * @param  Builder  $builder The Builder instance.
     * @param  string|int  $departmentTypeId The department type ID.
     */
    public function departmentType(Builder $builder, string|int $departmentTypeId): void
    {
        $departmentTypeId = $departmentTypeId === 'none' ? null : $departmentTypeId;
        $builder->where('departments.department_type_id', $departmentTypeId);
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
            $query->where('departments.name', 'ilike', "%$keyword%")
                ->orWhere('departments.short_name', 'ilike', "%$keyword%");
        });
    }
}
