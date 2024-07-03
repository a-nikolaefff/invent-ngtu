<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a building filter.
 */
class BuildingFilter extends AbstractFilter
{
    public const BUILDING_TYPE_ID = 'building_type_id';

    public const SEARCH = 'search';

    /**
     * {@inheritDoc}
     */
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
     * @param  Builder  $builder        The Builder instance.
     * @param  string|int  $buildingTypeId The building type ID.
     */
    public function buildingTypeId(Builder $builder, string|int $buildingTypeId): void
    {
        $buildingTypeId = $buildingTypeId === 'none' ? null : (int) $buildingTypeId;
        $builder->where('buildings.building_type_id', $buildingTypeId);
    }

    /**
     * Apply the filter based on search keyword.
     *
     * @param  Builder  $builder The Builder instance.
     * @param  string  $keyword The search keyword.
     */
    public function search(Builder $builder, string $keyword): void
    {
        $builder->where('buildings.name', 'ilike', "%$keyword%");
    }
}
