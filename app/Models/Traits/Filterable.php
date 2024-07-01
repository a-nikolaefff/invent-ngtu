<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Filter data according to the passed filter
     *
     * @param Builder $builder
     * @param FilterInterface $filter
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, FilterInterface $filter)
    {
        $filter->apply($builder);
        return $builder;
    }
}
