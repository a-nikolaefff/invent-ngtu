<?php

declare(strict_types=1);

namespace App\Models\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface GetByParams
{
    public function scopeGetByParams(Builder $query, array $params): void;
}
