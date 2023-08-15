<?php

declare(strict_types=1);

namespace App\Services\RepairApplication;

use App\Enums\RepairApplicationStatusEnum;
use App\Models\RepairApplicationStatus;
use App\Notifications\RepairApplicationStatusChangedNotification;
use Carbon\Carbon;

/**
 * Represents a service for updating repair application data
 */
class UpdateRepairApplicationService extends RepairApplicationService
{

    protected function setSpecificData()
    {
        $approvedAndRejectedStatusIds = RepairApplicationStatus::whereIn(
            'name',
            [
                RepairApplicationStatusEnum::Approved->value,
                RepairApplicationStatusEnum::Rejected->value
            ]
        )->pluck('id');
        if ($approvedAndRejectedStatusIds->contains(
            $this->processedData['repair_application_status_id']
        )
        ) {
            $this->processedData['response_date'] = Carbon::now();
        } else {
            $this->processedData['response_date'] = null;
        }
    }

    public function notify()
    {
        $this->repairApplication->user->notify(
            new RepairApplicationStatusChangedNotification($this->repairApplication)
        );
    }
}
