<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * List of user roles used in the app. Values are names of roles in the database.
 */
enum UserRoleEnum: string
{
    case SuperAdmin = 'главный администратор';
    case Admin = 'администратор';
    case Employee = 'сотрудник';
    case Stranger = 'неизвестный';
}
