<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * List of repair application statuses used in the app. Values are names of statuses in the database.
 */
enum RepairApplicationStatusEnum: string
{
    case Pending = 'на рассмотрении';
    case Rejected = 'отклонена';
    case Approved = 'одобрена';
}
