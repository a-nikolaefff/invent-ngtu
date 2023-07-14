<?php

declare(strict_types=1);

namespace App\Services\User;

use Illuminate\Support\Facades\Auth;

/**
 * This class provides functionality to process user data.
 */
class UserService
{
    /**
     * @var array The processed data after applying the data processing logic.
     */
    private array $processedData;

    /**
     * Process the input data and return the processed data.
     *
     * @param array $inputData The input data to be processed.
     *
     * @return array The processed data.
     */
    public function processData(array $inputData): array
    {
        $this->setDirectData($inputData);
        $this->setUpdatedByUser();

        return $this->processedData;
    }

    /**
     * Set the direct data without any processing.
     *
     * @param array $inputData The input data to be set as the processed data.
     *
     * @return void
     */
    private function setDirectData(array $inputData): void
    {
        $this->processedData = $inputData;
    }

    /**
     * Set the "updated_by_user_id" field in the processed data.
     *
     * @return void
     */
    private function setUpdatedByUser(): void
    {
        $this->processedData['updated_by_user_id'] = Auth::user()->id;
    }
}
