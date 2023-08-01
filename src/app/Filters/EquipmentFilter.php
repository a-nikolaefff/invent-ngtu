<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a user filter.
 */
class EquipmentFilter extends AbstractFilter
{
    public const EQUIPMENT_TYPE = 'equipment_type_id';
    public const not_in_operation = 'not_in_operation';
    public const DECOMMISSIONED = 'decommissioned';
    public const SEARCH = 'search';

    protected function getCallbacks(): array
    {
        return [
            self::EQUIPMENT_TYPE => [$this, 'equipmentTypeId'],
            self::not_in_operation => [$this, 'inOperation'],
            self::DECOMMISSIONED => [$this, 'decommissioned'],
            self::SEARCH => [$this, 'search'],
        ];
    }

    /**
     * Apply the filter based on room type ID.
     *
     * @param Builder $builder         The Builder instance.
     * @param mixed   $inOperationKey The role ID.
     *
     * @return void
     */
    public function equipmentTypeId(Builder $builder, $equipmentTypeId)
    {

        $equipmentTypeId = $equipmentTypeId === 'none' ? null : $equipmentTypeId;
        $builder->where('equipment.equipment_type_id', $equipmentTypeId);
    }

    /**
     * Apply the filter based on room type ID.
     *
     * @param Builder $builder         The Builder instance.
     * @param mixed   $equipmentTypeId The role ID.
     *
     * @return void
     */
    public function inOperation(Builder $builder, $inOperationKey)
    {
        $inOperation = $inOperationKey == 'true';
        $builder->where('equipment.not_in_operation', $inOperation);
    }

    /**
     * Apply the filter based on room type ID.
     *
     * @param Builder $builder         The Builder instance.
     * @param mixed   $equipmentTypeId The role ID.
     *
     * @return void
     */
    public function decommissioned(Builder $builder, $decommissionedKey)
    {
        $decommissioned = $decommissionedKey == 'true';
        $builder->where('equipment.decommissioned', $decommissioned);
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
            $query->where('equipment.name', 'like', "%$keyword%")
                ->orWhere('equipment.number', 'like', "%$keyword%")
                ->orWhere('rooms.number', 'like', "%$keyword%")
                ->orWhere('departments.name', 'like', "%$keyword%")
                ->orWhere('departments.short_name', 'like', "%$keyword%");
        });
    }
}
