<?php

declare(strict_types=1);

namespace App\Services\Equipment;

use App\Services\DataProcessor;

class EquipmentService implements DataProcessor
{
    /**
     * @var array The processed data after applying the data processing logic.
     */
    private array $processedData;

    public function processData(array $inputData): array
    {
        $this->processedData = $inputData;
        $this->processedData['not_in_operation'] = $inputData['not_in_operation']
            ?? false;
        $this->processedData['decommissioned'] = $inputData['decommissioned'] ??
            false;
        $this->processedData['decommissioning_date']
            = $this->processedData['decommissioned']
            ? $inputData['decommissioning_date'] : null;
        $this->processedData['decommissioning_reason']
            = $this->processedData['decommissioned']
            ? $inputData['decommissioning_reason'] : null;

        return $this->processedData;
    }
}
