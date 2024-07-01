<?php

declare(strict_types=1);

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Abstract filter class.
 */
abstract class AbstractFilter implements FilterInterface
{
    /** @var array The query parameters array. */
    private array $queryParams = [];

    /**
     * AbstractFilter constructor.
     *
     * @param array $queryParams The query parameters array.
     */
    public function __construct(array $queryParams)
    {
        $this->queryParams = $queryParams;
    }

    /**
     * Get the filter callbacks array.
     *
     * @return array The filter callbacks array.
     */
    abstract protected function getCallbacks(): array;

    public function apply(Builder $builder)
    {
        foreach ($this->getCallbacks() as $name => $callback) {
            if (isset($this->queryParams[$name])) {
                call_user_func($callback, $builder, $this->queryParams[$name]);
            }
        }
    }
}
