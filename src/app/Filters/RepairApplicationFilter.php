<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a user filter.
 */
class RepairApplicationFilter extends AbstractFilter
{
    public const REPAIR_APPLICATION_STATUS = 'repair_application_status_id';
    public const SEARCH = 'search';

    protected function getCallbacks(): array
    {
        return [
            self::REPAIR_APPLICATION_STATUS => [
                $this,
                'repairApplicationStatus'
            ],
            self::SEARCH => [$this, 'search'],
        ];
    }

    /**
     * Apply the filter based on room type ID.
     *
     * @param Builder $builder The Builder instance.
     * @param mixed   $statusId The role ID.
     *
     * @return void
     */
    public function repairApplicationStatus(Builder $builder, $statusId)
    {
        $builder->where(
            'repair_applications.repair_application_status_id',
            $statusId
        );
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
            $query->where('repair_applications.id', 'like', "%$keyword%")
                ->orWhere('repair_applications.short_description', 'like', "%$keyword%")
                ->orWhere('equipment.number', 'like', "%$keyword%")
                ->orWhere('equipment.name', 'like', "%$keyword%");
        });
    }
}
