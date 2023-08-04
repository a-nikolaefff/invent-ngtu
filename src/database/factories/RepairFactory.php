<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Repair;
use App\Models\RepairStatus;
use App\Models\RepairType;
use Carbon\Carbon;
use Database\Helpers\FileLoader;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Repair>
 */
class RepairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'short_description' => fake()->words(2, true),
            'full_description' => fake()->words(6, true),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'equipment_id' => Equipment::pluck('id')->random(),
            'repair_type_id' => RepairType::pluck('id')->random(),
            'repair_status_id' => RepairStatus::pluck('id')->random(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Repair $repair) {
            FileLoader::load(
                $repair,
                'app/examples/repairs/before',
                'before'
            );
            FileLoader::load(
                $repair,
                'app/examples/repairs/after',
                'after'
            );
        }
        );
    }
}
