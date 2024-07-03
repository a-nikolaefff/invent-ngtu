<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Equipment;

/**
 * Equipment service
 */
class EquipmentService
{
    public function create(array $data): Equipment
    {
        return Equipment::create($this->processData($data));
    }

    public function update(Equipment $equipment, array $data): void
    {
        $equipment->fill($this->processData($data))->save();
    }

    private function processData(array $inputData): array
    {
        $processedData = $inputData;

        $processedData['not_in_operation'] = $inputData['not_in_operation'] ?? false;
        $processedData['decommissioned'] = $inputData['decommissioned'] ?? false;
        $processedData['decommissioning_date'] = $processedData['decommissioned']
            ? $inputData['decommissioning_date']
            : null;
        $processedData['decommissioning_reason'] = $processedData['decommissioned']
            ? $inputData['decommissioning_reason']
            : null;

        return $processedData;
    }
}
