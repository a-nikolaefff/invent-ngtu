<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a repair filter.
 */
class RepairFilter extends AbstractFilter
{
    public const REPAIR_TYPE = 'repair_type_id';

    public const REPAIR_STATUS = 'repair_status_id';

    public const SEARCH = 'search';

    /**
     * {@inheritDoc}
     */
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
     * @param  Builder  $builder      The Builder instance.
     * @param  string|int  $repairTypeId The repair type ID.
     */
    public function repairType(Builder $builder, string|int $repairTypeId): void
    {
        $repairTypeId = $repairTypeId === 'none' ? null : $repairTypeId;
        $builder->where('repairs.repair_type_id', $repairTypeId);
    }

    /**
     * Apply the filter based on repair status ID.
     *
     * @param  Builder  $builder        The Builder instance.
     * @param  string|int  $repairStatusId The repair status ID.
     */
    public function repairStatus(Builder $builder, string|int $repairStatusId): void
    {
        $builder->where('repairs.repair_status_id', $repairStatusId);
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
            $query->where('repairs.short_description', 'ilike', "%$keyword%")
                ->orWhere('equipment.number', 'ilike', "%$keyword%")
                ->orWhere('equipment.name', 'ilike', "%$keyword%");
        });
    }
}
