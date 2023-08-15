<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\UserRoleEnum;
use App\Models\RepairApplication;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\NewRepairApplicationNotification;

/**
 * Represents an action to notify specialists about a new repair application.
 */
class NotifySpecialistAboutNewRepairApplicationAction
{
    /**
     * Execute the action to notify specialists about a new repair application.
     *
     * @param RepairApplication $repairApplication The repair application to notify about.
     * @return void
     */
    public function execute(RepairApplication $repairApplication)
    {
        $specialistRoleId = UserRole::where(
            'name',
            UserRoleEnum::SupplyAndRepairSpecialist->value
        )
            ->value('id');
        $specialists = User::where('role_id', $specialistRoleId);

        $notification = new NewRepairApplicationNotification($repairApplication);

        foreach ($specialists as $specialist) {
            $specialist->notify($notification);
        }
    }
}
