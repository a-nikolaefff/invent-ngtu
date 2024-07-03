<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a room filter.
 */
class RoomFilter extends AbstractFilter
{
    public const ROOM_TYPE_ID = 'room_type_id';

    public const BUILDING_ID = 'building_id';

    public const FLOOR = 'floor';

    public const SEARCH = 'search';

    /**
     * {@inheritDoc}
     */
    protected function getCallbacks(): array
    {
        return [
            self::ROOM_TYPE_ID => [$this, 'roomTypeId'],
            self::BUILDING_ID => [$this, 'buildingId'],
            self::FLOOR => [$this, 'floor'],
            self::SEARCH => [$this, 'search'],
        ];
    }

    /**
     * Apply the filter based on room type ID.
     *
     * @param  Builder  $builder    The Builder instance.
     * @param  string|int  $roomTypeId The room type ID.
     */
    public function roomTypeId(Builder $builder, string|int $roomTypeId): void
    {
        $roomTypeId = $roomTypeId === 'none' ? null : $roomTypeId;
        $builder->where('rooms.room_type_id', $roomTypeId);
    }

    /**
     * Apply the filter based on building ID.
     *
     * @param  Builder  $builder    The Builder instance.
     * @param  string|int  $buildingId The building ID.
     */
    public function buildingId(Builder $builder, string|int $buildingId): void
    {
        $buildingId = $buildingId === 'none' ? null : $buildingId;
        $builder->where('rooms.building_id', $buildingId);
    }

    /**
     * Apply the filter based on floor.
     *
     * @param  Builder  $builder The Builder instance.
     * @param  string|int  $floor   The floor number.
     */
    public function floor(Builder $builder, string|int $floor): void
    {
        $builder->where('rooms.floor', $floor);
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
            $query->where('rooms.name', 'ilike', "%$keyword%")
                ->orWhere('rooms.number', 'ilike', "%$keyword%")
                ->orWhere('departments.name', 'ilike', "%$keyword%")
                ->orWhere('departments.short_name', 'ilike', "%$keyword%");
        });
    }
}
