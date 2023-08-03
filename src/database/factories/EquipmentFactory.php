<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roomId = Room::pluck('id');
        $equipmentId = EquipmentType::pluck('id');
        $isInOperation = fake()->boolean;
        $isDecommissioned = fake()->boolean;

        return [
            'name' => fake()->words(2, true),
            'number' => fake()->unique()->randomNumber(6, true),
            'description' => fake()->words(2, true),
            'acquisition_date' => Carbon::now(),
            'not_in_operation' => $isInOperation,
            'decommissioned' => $isDecommissioned,
            'decommissioning_date' => $isDecommissioned ? Carbon::now() : null,
            'decommissioning_reason' => $isDecommissioned ? fake()->words(
                2,
                true
            ) : null,
            'room_id' => $roomId->random(),
            'equipment_type_id' => $equipmentId->random(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Equipment $equipment) {
            $exampleFilesPath = storage_path('app/public/examples/equipment');
            $copiedFilesPath = storage_path('app/public/examples/temp');

            // Create the 'copied_examples' directory if it doesn't exist
            if (!File::exists($copiedFilesPath)) {
                File::makeDirectory($copiedFilesPath);
            }

            // Get all files from the examples directory
            $exampleFiles = File::allFiles($exampleFilesPath);

            // Add each file to the media collection for the model
            foreach ($exampleFiles as $file) {
                // Copy the file to the 'copied_examples' directory
                $copiedFilePath = $copiedFilesPath . '/' . $file->getFilename();
                File::copy($file->getRealPath(), $copiedFilePath);

                // Get random user
                $user = User::all()->random();

                // Add the copied file to the media collection for the model
                $equipment->addMedia($copiedFilePath)
                    ->withCustomProperties([
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'datetime' => Carbon::now()->format('d.m.Y H:i:s')
                    ])
                    ->toMediaCollection('images');
            }
        });
    }
}
