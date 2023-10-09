<?php

namespace Database\Seeders;

use App\Models\SubTrade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubtradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subTrades = [
            //thei chin theih te 7
            ['id'=>1,'trade_id' => 7, 'name' => 'Balhla (Banana)'],
            ['id'=>2,'trade_id' => 7, 'name' => 'Lakhuihthei (Pineapple)'],
            ['id'=>3,'trade_id' => 7, 'name' => 'Dragon fruit'],
            ['id'=>4,'trade_id' => 7, 'name' => 'Sapthei (Passion fruit)'],
            ['id'=>5,'trade_id' => 7, 'name' => 'Serthlum (Mandarin Orange)'],
            ['id'=>6,'trade_id' => 7, 'name' => 'Nimbu'],
            ['id'=>7,'trade_id' => 7, 'name' => 'Kiwi'],
            ['id'=>8,'trade_id' => 7, 'name' => 'Grape'],

            //thlai chin theih te 8
            ['id'=>9,'trade_id' => 8, 'name' => 'Tomato'],
            ['id'=>10,'trade_id' => 8, 'name' => 'Zikhlum (Cabbage)'],
            ['id'=>11,'trade_id' => 8, 'name' => 'Iskut (Chayote)'],
            //other vegetables 9
            ['id'=>12,'trade_id' => 9, 'name' => 'Panhnah (Betlevine)'],
            ['id'=>13,'trade_id' => 9, 'name' => 'Bawkbawn'],
            ['id'=>14,'trade_id' => 9, 'name' => 'Chinit'],
            ['id'=>15,'trade_id' => 9, 'name' => 'Thingthupui'],
            ['id'=>16,'trade_id' => 9, 'name' => 'Khanghu'],
            ['id'=>17,'trade_id' => 9, 'name' => 'Alu'],
            ['id'=>18,'trade_id' => 9, 'name' => 'Telhawng'],
            //Medical plant 10
            ['id'=>19,'trade_id' => 11, 'name' => 'Sunhlu'],
            ['id'=>20,'trade_id' => 11, 'name' => 'Aloe Vera leh adangte'],
            //Computer, mobile leh internet hmanga eizawnna 41
            ['id'=>21,'trade_id' => 41, 'name' => 'Web design and management'],
            ['id'=>22,'trade_id' => 41, 'name' => 'Software development (eg. Apps/Attendance monitoring)'],
            ['id'=>23,'trade_id' => 41, 'name' => 'Mobile application development'],
            ['id'=>24,'trade_id' => 41, 'name' => 'Mobile games development'],
            ['id'=>25,'trade_id' => 41, 'name' => 'Internet provider'],
            ['id'=>26,'trade_id' => 41, 'name' => 'Audio/Videography'],
            ['id'=>27,'trade_id' => 41, 'name' => 'Ads formulation'],
            ['id'=>28,'trade_id' => 41, 'name' => 'Desktop Publishing'],

        ];

        SubTrade::query()->upsert($subTrades, ['id']);
    }
}
