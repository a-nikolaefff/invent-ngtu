<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * List of user roles used in the app. Values are names of roles in the database.
 */
enum RepairStatusEnum: string
{
    case Planned = 'планируемый';
    case InProgress = 'в процессе';
    case Completed = 'выполненный';
}
