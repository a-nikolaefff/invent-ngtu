<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a user filter.
 */
class RoomFilter extends AbstractFilter
{
    public const ROOM_TYPE_ID = 'room_type_id';
    public const BUILDING_ID = 'building_id';
    public const FLOOR = 'floor';
    public const SEARCH = 'search';

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
     * @param Builder $builder    The Builder instance.
     * @param mixed   $roomTypeId The role ID.
     *
     * @return void
     */
    public function roomTypeId(Builder $builder, $roomTypeId)
    {
        $roomTypeId = $roomTypeId === 'none' ? null : $roomTypeId;
        $builder->where('rooms.room_type_id', $roomTypeId);
    }

    /**
     * Apply the filter based on building ID.
     *
     * @param Builder $builder    The Builder instance.
     * @param mixed   $buildingId The role ID.
     *
     * @return void
     */
    public function buildingId(Builder $builder, $buildingId)
    {
        $buildingId = $buildingId === 'none' ? null : $buildingId;
        $builder->where('rooms.building_id', $buildingId);
    }

    /**
     * Apply the filter based on floor.
     *
     * @param Builder $builder The Builder instance.
     * @param mixed   $floor   The role ID.
     *
     * @return void
     */
    public function floor(Builder $builder, $floor)
    {
        $builder->where('rooms.floor', $floor);
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
            $query->where('rooms.name', 'like', "%$keyword%")
                ->orWhere('rooms.number', 'like', "%$keyword%")
                ->orWhere('departments.name', 'like', "%$keyword%")
                ->orWhere('departments.short_name', 'like', "%$keyword%");
        });
    }
}
