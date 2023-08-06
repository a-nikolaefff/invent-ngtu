<?php

namespace App\Models;

use App\Filters\DepartmentFilter;
use App\Models\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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
            'parent_department_id'
        ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(DepartmentType::class, 'department_type_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_department_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_department_id');
    }

    public static function getDepartments(array $queryParams)
    {
        $filter = app()->make(
            DepartmentFilter::class,
            ['queryParams' => $queryParams]
        );

        return static::select('departments.*')
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
            ->filter($filter)
            ->sort($queryParams)
            ->paginate(5)
            ->withQueryString();
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
                if ($sortColumn === 'department_type_name') {
                    return $query->orderBy('department_types.name', $sortDirection);
                }
                return $query->orderBy($sortColumn, $sortDirection);
            }
        );
    }

    public function getSelfAndDescendants()
    {
        $departmentId = $this->id;

        $descendants = $this->getDescendantsRecursive($departmentId);

        return Department::whereIn('id', $descendants)->get();
    }

    private function getDescendantsRecursive($departmentId)
    {
        $descendants = [$departmentId];

        $childDepartments = Department::where('parent_department_id', $departmentId)->pluck('id');

        foreach ($childDepartments as $childDepartmentId) {
            $descendants = array_merge($descendants, $this->getDescendantsRecursive($childDepartmentId));
        }

        return $descendants;
    }
}
