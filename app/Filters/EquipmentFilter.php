<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class representing a equipment filter.
 */
class EquipmentFilter extends AbstractFilter
{
    public const EQUIPMENT_TYPE = 'equipment_type_id';

    public const NOT_IN_OPERATION = 'not_in_operation';

    public const DECOMMISSIONED = 'decommissioned';

    public const SEARCH = 'search';

    /**
     * {@inheritDoc}
     */
    protected function getCallbacks(): array
    {
        return [
            self::EQUIPMENT_TYPE => [$this, 'equipmentTypeId'],
            self::NOT_IN_OPERATION => [$this, 'notInOperation'],
            self::DECOMMISSIONED => [$this, 'decommissioned'],
            self::SEARCH => [$this, 'search'],
        ];
    }

    /**
     * Apply the filter based on equipment type ID.
     *
     * @param  Builder  $builder The Builder instance.
     * @param  mixed  $equipmentTypeId The equipment type ID.
     */
    public function equipmentTypeId(Builder $builder, string $equipmentTypeId): void
    {
        $equipmentTypeId = $equipmentTypeId === 'none' ? null : $equipmentTypeId;
        $builder->where('equipment.equipment_type_id', $equipmentTypeId);
    }

    /**
     * Apply the filter based on not in operation status
     *
     * @param  Builder  $builder The Builder instance.
     * @param  string  $notInOperationKey Not in operation key
     */
    public function notInOperation(Builder $builder, string $notInOperationKey): void
    {
        $notInOperation = $notInOperationKey == 'true';
        $builder->where('equipment.not_in_operation', $notInOperation);
    }

    /**
     * Apply the filter based on decommissioned status
     *
     * @param  Builder  $builder The Builder instance.
     * @param  mixed  $decommissionedKey The decommissioned key.
     */
    public function decommissioned(Builder $builder, string $decommissionedKey): void
    {
        $decommissioned = $decommissionedKey == 'true';
        $builder->where('equipment.decommissioned', $decommissioned);
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
            $query->where('equipment.name', 'ilike', "%$keyword%")
                ->orWhere('equipment.number', 'ilike', "%$keyword%")
                ->orWhere('rooms.number', 'ilike', "%$keyword%")
                ->orWhere('departments.name', 'ilike', "%$keyword%")
                ->orWhere('departments.short_name', 'ilike', "%$keyword%");
        });
    }
}
