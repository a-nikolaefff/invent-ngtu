<?php

declare(strict_types=1);

namespace App\Services;

interface DataProcessor
{
    /**
     * Process the input data and return the processed data.
     *
     * @param  array  $inputData The input data to be processed.
     * @return array The processed data.
     */
    public function processData(array $inputData): array;
}
