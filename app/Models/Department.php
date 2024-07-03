<?php

declare(strict_types=1);

namespace App\Models;

use App\Filters\DepartmentFilter;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use Filterable;

    /**
     * The name of the table in the database
     *
     * @var string
     */
    protected $table = 'departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable
        = [
            'name',
            'short_name',
            'department_type_id',
            'parent_department_id',
        ];

    /**
     * Get the department type
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(DepartmentType::class, 'department_type_id');
    }

    /**
     * Get the department parent department
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_department_id');
    }

    /**
     * Get the department child departments
     */
    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_department_id');
    }

    /**
     * Get department list by parameters
     *
     * @param  Builder  $query Database query builder
     * @param  array  $params Filter parameters
     */
    public function scopeGetByParams(Builder $query, array $params): void
    {
        $query->select('departments.*')
            ->leftjoin(
                'departments as parent_departments',
                'departments.parent_department_id',
                '=',
                'parent_departments.id'
            )
            ->leftjoin(
                'department_types',
                'departments.department_type_id',
                '=',
                'department_types.id'
            )
            ->with('parent', 'type')
            ->filter(new DepartmentFilter($params))
            ->sort($params);
    }

    /**
     * Apply sort
     *
     * @param  Builder  $query Database query builder
     * @param  array  $queryParams Sort parameters
     * @param  string  $defaultSortColumn Default sort column
     * @param  string  $defaultSortDirection Default sort direction
     */
    public function scopeSort(
        Builder $query,
        array $queryParams,
        string $defaultSortColumn = '',
        string $defaultSortDirection = 'asc'
    ): void {
        $sortColumn = $queryParams['sort'] ?? $defaultSortColumn;
        $sortDirection = $queryParams['direction'] ?? $defaultSortDirection;
        $query->when(
            ! empty($sortColumn),
            function ($query) use ($sortColumn, $sortDirection) {
                if ($sortColumn === 'department_type_name') {
                    return $query->orderBy('department_types.name', $sortDirection);
                }

                return $query->orderBy($sortColumn, $sortDirection);
            }
        );
    }

    /**
     * Search departments by name or short name
     *
     * @param  Builder  $query Database query builder
     * @param  string  $keyword Search keyword
     */
    public function scopeSearchByNameOrShortName(Builder $query, string $keyword): void
    {
        $query->where('name', 'ilike', "%$keyword%")
            ->orWhere('short_name', 'ilike', "%$keyword%");
    }

    /**
     * Get the department and all its descendant departments
     *
     * @return Collection The department and all its descendant departments
     */
    public function getSelfAndDescendants(): Collection
    {
        $descendantIds = $this->getDescendantIds($this->id);

        return Department::whereIn('id', $descendantIds)->get();
    }

    /**
     * Get ids of all the department its descendant departments
     *
     * @param  int  $departmentId Parent department id
     * @return array Ids of descendant departments
     */
    private function getDescendantIds(int $departmentId): array
    {
        $descendants = [$departmentId];

        $childDepartments = Department::where('parent_department_id', $departmentId)->pluck('id');

        foreach ($childDepartments as $childDepartmentId) {
            $descendants = array_merge($descendants, $this->getDescendantIds($childDepartmentId));
        }

        return $descendants;
    }
}
