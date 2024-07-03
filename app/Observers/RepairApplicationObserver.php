<?php

namespace App\Observers;

use App\Enums\UserRoleEnum;
use App\Models\RepairApplication;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\NewRepairApplicationNotification;
use App\Notifications\RepairApplicationStatusChangedNotification;

class RepairApplicationObserver
{
    /**
     * Handle the RepairApplication "created" event.
     */
    public function created(RepairApplication $repairApplication): void
    {
        $specialistRoleId = UserRole::where('name', UserRoleEnum::SupplyAndRepairSpecialist->value)->value('id');
        $specialists = User::where('role_id', $specialistRoleId)->get();

        $notification = new NewRepairApplicationNotification($repairApplication);

        foreach ($specialists as $specialist) {
            $specialist->notify($notification);
        }
    }

    /**
     * Handle the RepairApplication "updated" event.
     */
    public function updated(RepairApplication $repairApplication): void
    {
        $repairApplication->user->notify(new RepairApplicationStatusChangedNotification($repairApplication));
    }
}
