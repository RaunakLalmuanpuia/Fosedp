<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ConstituencySeeder::class,
            DepartmentSeeder::class,
            DistrictSeeder::class,
            TradeSeeder::class,
            SubtradeSeeder::class,

            PermissionSeeder::class,
            UserSeeder::class,
            RoleSeeder::class

        ]);
    }
}
