<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a user filter.
 */
class RepairFilter extends AbstractFilter
{
    public const REPAIR_TYPE = 'repair_type_id';
    public const REPAIR_STATUS = 'repair_status_id';
    public const SEARCH = 'search';

    protected function getCallbacks(): array
    {
        return [
            self::REPAIR_TYPE => [$this, 'repairType'],
            self::REPAIR_STATUS => [$this, 'repairStatus'],
            self::SEARCH => [$this, 'search'],
        ];
    }

    /**
     * Apply the filter based on repair type ID.
     *
     * @param Builder $builder      The Builder instance.
     * @param mixed   $repairTypeId The role ID.
     *
     * @return void
     */
    public function repairType(Builder $builder, $repairTypeId)
    {
        $repairTypeId = $repairTypeId === 'none' ? null : $repairTypeId;
        $builder->where('repairs.repair_type_id', $repairTypeId);
    }

    /**
     * Apply the filter based on repair status ID.
     *
     * @param Builder $builder        The Builder instance.
     * @param mixed   $repairStatusId The role ID.
     *
     * @return void
     */
    public function repairStatus(Builder $builder, $repairStatusId)
    {
        $builder->where('repairs.repair_status_id', $repairStatusId);
    }

    /**
     * Apply the filter based on search keyword.
     *
     * @param Builder $builder The Builder instance.
     * @param string  $keyword The search keyword.
     *
     * @return void
     */
    public function search(Builder $builder, $keyword)
    {
        $builder->where(function ($query) use ($keyword) {
            $query->where('repairs.short_description', 'like', "%$keyword%")
                ->orWhere('equipment.number', 'like', "%$keyword%")
                ->orWhere('equipment.name', 'like', "%$keyword%");
        });
    }
}
