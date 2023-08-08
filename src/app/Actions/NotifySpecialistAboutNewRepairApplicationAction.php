<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\UserRoleEnum;
use App\Models\RepairApplication;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\NewRepairApplicationNotification;

class NotifySpecialistAboutNewRepairApplicationAction
{
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
