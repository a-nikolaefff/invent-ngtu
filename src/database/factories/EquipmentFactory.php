<?php

namespace Database\Factories;

use App\Models\EquipmentType;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'number' => fake()->randomNumber(6, true),
            'description' => fake()->words(2, true),
            'acquisition_date' => Carbon::now(),
            'not_in_operation' => $isInOperation,
            'decommissioned' => $isDecommissioned,
            'decommissioning_date' => $isDecommissioned ? Carbon::now() : null,
            'decommissioning_reason' => $isDecommissioned ? fake()->words(2, true) : null,
            'room_id' => $roomId->random(),
            'equipment_type_id' => $equipmentId->random(),
        ];
    }
}
