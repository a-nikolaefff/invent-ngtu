<?php

declare(strict_types=1);

namespace App\Services\RepairApplication;

use App\Enums\RepairApplicationStatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\RepairApplicationStatus;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\NewRepairApplicationNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * Represents a service for storing repair application data
 */
class StoreRepairApplicationService extends RepairApplicationService
{

    protected function setSpecificData()
    {
        $this->processedData['application_date'] = Carbon::now();
        $this->processedData['user_id'] = Auth::user()->id;
        $this->processedData['repair_application_status_id']
            = RepairApplicationStatus::where(
            'name',
            RepairApplicationStatusEnum::Pending->value
        )->value('id');
    }

    public function notify()
    {
        $specialistRoleId = UserRole::where(
            'name',
            UserRoleEnum::SupplyAndRepairSpecialist->value
        )
            ->value('id');
        $specialists = User::where('role_id', $specialistRoleId)->get();

        $notification = new NewRepairApplicationNotification($this->repairApplication);

        foreach ($specialists as $specialist) {
            $specialist->notify($notification);
        }
    }
}
