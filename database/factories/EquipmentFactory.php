<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Room;
use Carbon\Carbon;
use Database\Helpers\FileLoader;
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
        $isDecommissioned = fake()->boolean;
        $equipmentType = EquipmentType::all()->random();

        $equipmentNameFirstLetterUpper = mb_strtoupper(mb_substr($equipmentType->name, 0, 1, 'UTF-8'), 'UTF-8');
        $equipmentName = $equipmentNameFirstLetterUpper.mb_substr($equipmentType->name, 1, null, 'UTF-8');

        return [
            'name' => $equipmentName.' '.fake()->words(2, true),
            'number' => fake()->unique()->randomNumber(6, true),
            'description' => fake()->words(2, true),
            'acquisition_date' => Carbon::now(),
            'not_in_operation' => fake()->boolean,
            'decommissioned' => $isDecommissioned,
            'decommissioning_date' => $isDecommissioned ? Carbon::now() : null,
            'decommissioning_reason' => $isDecommissioned ? fake()->words(
                2,
                true
            ) : null,
            'room_id' => Room::pluck('id')->random(),
            'equipment_type_id' => $equipmentType->id,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Equipment $equipment) {
            FileLoader::load(
                $equipment,
                'app/examples/equipment',
                'images'
            );
        }
        );
    }
}
