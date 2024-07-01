<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a user filter.
 */
class BuildingFilter extends AbstractFilter
{
    public const BUILDING_TYPE_ID = 'building_type_id';
    public const SEARCH = 'search';

    protected function getCallbacks(): array
    {
        return [
            self::BUILDING_TYPE_ID => [$this, 'buildingTypeId'],
            self::SEARCH => [$this, 'search'],
        ];
    }

    /**
     * Apply the filter based on building type ID.
     *
     * @param Builder $builder        The Builder instance.
     * @param mixed   $buildingTypeId The role ID.
     *
     * @return void
     */
    public function buildingTypeId(Builder $builder, $buildingTypeId)
    {
        $buildingTypeId = $buildingTypeId === 'none' ? null : $buildingTypeId;
        $builder->where('buildings.building_type_id', $buildingTypeId);
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
        $builder->where('buildings.name', 'like', "%$keyword%");
    }
}
