<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            ['id'=>1,'name' => 'Agriculture'],
            ['id'=>2,'name' => 'Horticulture'],
            ['id'=>3,'name' => 'Animal Husbandry & Veterinary'],
            ['id'=>4,'name' => 'Fisheries'],
            ['id'=>5,'name' => 'Sericulture'],
            ['id'=>6,'name' => 'Land Resources, Soil & Water conservation'],
            ['id'=>7,'name' => 'Commerce & Industries'],
            ['id'=>8,'name' => 'UD & PA'],
            ['id'=>9,'name' => 'Tourism'],
        ];

        Department::query()->upsert($departments, ['id']);
    }
}
