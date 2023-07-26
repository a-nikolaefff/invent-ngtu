<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a user filter.
 */
class DepartmentFilter extends AbstractFilter
{
    public const DEPARTMENT_TYPE_ID = 'department_type_id';
    public const SEARCH = 'search';

    protected function getCallbacks(): array
    {
        return [
            self::DEPARTMENT_TYPE_ID => [$this, 'departmentTypeId'],
            self::SEARCH => [$this, 'search'],
        ];
    }

    /**
     * Apply the filter based on role ID.
     *
     * @param Builder $builder          The Builder instance.
     * @param mixed   $departmentTypeId The role ID.
     *
     * @return void
     */
    public function departmentTypeId(Builder $builder, $departmentTypeId)
    {
        $departmentTypeId = $departmentTypeId === 'none' ? null : $departmentTypeId;
        $builder->where('departments.department_type_id', $departmentTypeId);
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
            $query->where('departments.name', 'like', "%$keyword%")
                ->orWhere('departments.short_name', 'like', "%$keyword%");
        });
    }
}
