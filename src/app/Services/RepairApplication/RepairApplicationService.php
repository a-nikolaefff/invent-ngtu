<?php

declare(strict_types=1);

namespace App\Services\RepairApplication;

use App\Models\RepairApplication;

abstract class RepairApplicationService
{
    /**
     * @var array The processed data after applying the data processing logic.
     */
    protected array $processedData;

    protected RepairApplication $repairApplication;

    /**
     * @param RepairApplication $repairApplication
     */
    public function setRepairApplication(RepairApplication $repairApplication
    ): void {
        $this->repairApplication = $repairApplication;
    }

    public function processData(array $inputData): array
    {
        $this->processedData = $inputData;
        $this->setSpecificData();
        return $this->processedData;
    }

    protected abstract function setSpecificData();

    public abstract function notify();
}
