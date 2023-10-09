<?php

namespace Database\Seeders;

use App\Models\Constituency;
use Illuminate\Database\Seeder;

class ConstituencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $constituencies = [
            ['id'=>1, 'district_id' => 8, 'name' => 'Hachhek'],
            ['id'=>2, 'district_id' => 8, 'name' => 'Dampa'],
            ['id'=>3, 'district_id' => 8, 'name' => 'Mamit'],
            ['id'=>4, 'district_id' => 5, 'name' => 'Tuirial'],
            ['id'=>5, 'district_id' => 5, 'name' => 'Kolasib'],
            ['id'=>6, 'district_id' => 5, 'name' => 'Serlui'],
            ['id'=>7, 'district_id' => 1, 'name' => 'Tuivawl'],
            ['id'=>8, 'district_id' => 1, 'name' => 'Chalfilh'],
            ['id'=>9, 'district_id' => 1, 'name' => 'Tawi'],
            ['id'=>10, 'district_id' => 1, 'name' => 'Aizawl North 1'],
            ['id'=>11, 'district_id' => 1, 'name' => 'Aizawl North 2'],
            ['id'=>12, 'district_id' => 1, 'name' => 'Aizawl North 3'],
            ['id'=>13, 'district_id' => 1, 'name' => 'Aizawl East 1'],
            ['id'=>14, 'district_id' => 1, 'name' => 'Aizawl East 2'],
            ['id'=>15, 'district_id' => 1, 'name' => 'Aizawl West 1'],
            ['id'=>16, 'district_id' => 1, 'name' => 'Aizawl West 2'],
            ['id'=>17, 'district_id' => 1, 'name' => 'Aizawl West 3'],
            ['id'=>18, 'district_id' => 1, 'name' => 'Aizawl South 1'],
            ['id'=>19, 'district_id' => 1, 'name' => 'Aizawl South 2'],
            ['id'=>20, 'district_id' => 1, 'name' => 'Aizawl South 3'],
            ['id'=>21, 'district_id' => 2, 'name' => 'Lengteng'],
            ['id'=>22, 'district_id' => 2, 'name' => 'Tuichang'],
            ['id'=>23, 'district_id' => 2, 'name' => 'Champhai North'],
            ['id'=>24, 'district_id' => 2, 'name' => 'Champhai South'],
            ['id'=>25, 'district_id' => 2, 'name' => 'East Tuipui'],
            ['id'=>26, 'district_id' => 6, 'name' => 'Serchhip'],
            ['id'=>27, 'district_id' => 6, 'name' => 'Tuikum'],
            ['id'=>28, 'district_id' => 6, 'name' => 'Hrangturzo'],
            ['id'=>29, 'district_id' => 7, 'name' => 'South Tuipui'],
            ['id'=>30, 'district_id' => 7, 'name' => 'Lunglei North'],
            ['id'=>31, 'district_id' => 7, 'name' => 'Lunglei East'],
            ['id'=>32, 'district_id' => 7, 'name' => 'Lunglei West'],
            ['id'=>33, 'district_id' => 7, 'name' => 'Lunglei south'],
            ['id'=>34, 'district_id' => 7, 'name' => 'Thorang'],
            ['id'=>35, 'district_id' => 7, 'name' => 'West Tuipui'],
            ['id'=>36, 'district_id' => 6, 'name' => 'Tuichawng'],
            ['id'=>37, 'district_id' => 6, 'name' => 'Lawngtlai West'],
            ['id'=>38, 'district_id' => 6, 'name' => 'Lawngtlai East'],
            ['id'=>39, 'district_id' => 9, 'name' => 'Siaha'],
            ['id'=>40, 'district_id' => 9, 'name' => 'Palak'],
        ];

        Constituency::query()->upsert($constituencies, ['id']);
    }
}
