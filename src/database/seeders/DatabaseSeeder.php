<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use App\Models\Repair;
use App\Models\RepairType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            DepartmentTypeSeeder::class,
            DepartmentSeeder::class,
            UserRoleSeeder::class,
            SuperAdminSeeder::class,
            BuildingTypeSeeder::class,
            BuildingSeeder::class,
            RoomTypeSeeder::class,
            EquipmentTypeSeeder::class,
            RepairTypeSeeder::class,
            RepairStatusSeeder::class,
        ];
        $appEnv = config('app.env');
        if($appEnv === 'development') {
            $seeders[] = UserSeeder::class;
            $seeders[] = RoomSeeder::class;
            $seeders[] = EquipmentSeeder::class;
            $seeders[] = RepairSeeder::class;
        }
        $this->call($seeders);
    }
}
