<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\RepairApplicationStatusEnum;
use App\Models\RepairApplication;
use App\Models\RepairApplicationStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * An abstract class representing a service for processing repair application data .
 */
class RepairApplicationService
{
    public function create(array $data): RepairApplication
    {
        $data['application_date'] = Carbon::now();
        $data['user_id'] = Auth::user()->id;
        $data['repair_application_status_id'] = RepairApplicationStatus::where(
            'name',
            RepairApplicationStatusEnum::Pending->value
        )->value('id');

        return RepairApplication::create($data);
    }

    public function update(array $data, RepairApplication $repairApplication): void
    {
        $approvedAndRejectedStatusIds = RepairApplicationStatus::whereIn(
            'name',
            [
                RepairApplicationStatusEnum::Approved->value,
                RepairApplicationStatusEnum::Rejected->value,
            ]
        )->pluck('id');

        $data['response_date'] = $approvedAndRejectedStatusIds->contains($data['repair_application_status_id'])
            ? Carbon::now()
            : null;

        $repairApplication->fill($data)->save();
    }
}
