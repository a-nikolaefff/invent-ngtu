<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a repair application filter.
 */
class RepairApplicationFilter extends AbstractFilter
{
    public const REPAIR_APPLICATION_STATUS = 'repair_application_status_id';

    public const SEARCH = 'search';

    /**
     * {@inheritDoc}
     */
    protected function getCallbacks(): array
    {
        return [
            self::REPAIR_APPLICATION_STATUS => [$this, 'repairApplicationStatus'],
            self::SEARCH => [$this, 'search'],
        ];
    }

    /**
     * Apply the filter based on repair application status ID.
     *
     * @param  Builder  $builder The Builder instance.
     * @param  string|int  $statusId The status ID.
     */
    public function repairApplicationStatus(Builder $builder, string|int $statusId): void
    {
        $builder->where('repair_applications.repair_application_status_id', $statusId);
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
            $query->where('repair_applications.id', 'ilike', "%$keyword%")
                ->orWhere('repair_applications.short_description', 'ilike', "%$keyword%")
                ->orWhere('equipment.number', 'ilike', "%$keyword%")
                ->orWhere('equipment.name', 'ilike', "%$keyword%");
        });
    }
}
