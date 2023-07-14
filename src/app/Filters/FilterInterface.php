<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface for filters.
 */
interface FilterInterface
{
    /**
     * Apply the filter to the Builder instance.
     *
     * @param Builder $builder The Builder instance.
     * @return void
     */
    public function apply(Builder $builder);
}
