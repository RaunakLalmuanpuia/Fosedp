<?php

namespace Database\Seeders;

use App\Models\Trade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $trades = [
            //Agriculture
            ['id'=>1,'department_id' => 1, 'name' => 'Vaimim (Maize)/Bekang (Soyabean) chin'],
            ['id'=>2,'department_id' => 1, 'name' => 'Fu (Sugarcane) chin'],
            ['id'=>3,'department_id' => 1, 'name' => 'Leilet (Wet Rice Culivation I & II)'],
            ['id'=>4,'department_id' => 1, 'name' => 'Oilseeds chin'],
            ['id'=>5,'department_id' => 1, 'name' => 'Dailuah, chana leh adangte'],
            //Horticulture
            ['id'=>6,'department_id' => 2, 'name' => 'Bamboo Plantation'],
            ['id'=>7,'department_id' => 2, 'name' => 'Thei chin theihte (Fruits Items)'],
            ['id'=>8,'department_id' => 2, 'name' => 'Thlai chin theihte (Vegetable items)'],
            ['id'=>9,'department_id' => 2, 'name' => 'Other Vegetables'],
            ['id'=>10,'department_id' => 2, 'name' => 'Pangpar huan siam (Floriculture)'],
            ['id'=>11,'department_id' => 2, 'name' => 'Medicinal Plants'],
            ['id'=>12,'department_id' => 2, 'name' => 'Thingpui chin (Tea Plantation)'],
            //Animal Husbandry
            ['id'=>13,'department_id' => 3, 'name' => 'Vawk Vulh (Piggery-Fattener unit & Piglet multiplication)'],
            ['id'=>14,'department_id' => 3, 'name' => 'Ar vulh (Poultry Farming)'],
            ['id'=>15,'department_id' => 3, 'name' => 'Bawng vulh (Cattle Farming)'],
            ['id'=>16,'department_id' => 3, 'name' => 'Kel vulh (Goat Farming)'],
            ['id'=>17,'department_id' => 3, 'name' => 'Sial vulh (Mithun Farming)'],

            //fisheries 4
            ['id'=>18,'department_id' => 4, 'name' => 'Sangha khawi'],

            //Sericulture 5
            ['id'=>19,'department_id' => 5, 'name' => 'Eri Culture'],
            ['id'=>20,'department_id' => 5, 'name' => 'Muga Culture'],
            ['id'=>21,'department_id' => 5, 'name' => 'Mulberry Culture'],

            //land resource 6
            ['id'=>22,'department_id' => 6, 'name' => 'Kuhva chin (Arecanut Plantation)'],
            ['id'=>23,'department_id' => 6, 'name' => 'Hmunphiah chin (Broom cultivation)'],
            ['id'=>24,'department_id' => 6, 'name' => 'Rubber chin (Rubber plantation)'],
            ['id'=>25,'department_id' => 6, 'name' => 'Coffee chin (Coffee Plantation)'],

            //Commerce & industries 7
            ['id'=>26,'department_id' => 7, 'name' => 'Mistiri (Carpentry work)'],
            ['id'=>27,'department_id' => 7, 'name' => 'Mau leh hnang a thil siam (Bamboo and cane work)'],
            ['id'=>28,'department_id' => 7, 'name' => 'Steel Fabrication'],
            ['id'=>29,'department_id' => 7, 'name' => 'Aluminium work'],
            ['id'=>30,'department_id' => 7, 'name' => 'Puantah (Handlom)'],
            ['id'=>31,'department_id' => 7, 'name' => 'Puanthui (Tailoring)'],
            ['id'=>32,'department_id' => 7, 'name' => 'Beauty & wellness therapy'],
            ['id'=>33,'department_id' => 7, 'name' => 'Lumeh (Hair cutting)'],
            ['id'=>34,'department_id' => 7, 'name' => 'Pangpar lem siam leh khawi (Artificial Flower arrangement)'],
            ['id'=>35,'department_id' => 7, 'name' => 'Thirden (Black smithy)'],
            ['id'=>36,'department_id' => 7, 'name' => 'Pheikhawk chhe siam (Shoe Repairing)'],
            ['id'=>37,'department_id' => 7, 'name' => 'Electronic Repairing'],
            ['id'=>38,'department_id' => 7, 'name' => '2-Wheeler Workshop'],
            ['id'=>39,'department_id' => 7, 'name' => 'Automobile Workshop'],
            ['id'=>40,'department_id' => 7, 'name' => 'Puncture/Tyre Workshop'],
            ['id'=>41,'department_id' => 7, 'name' => 'Computer, mobile leh internet hmanga eizawnna'],
            ['id'=>42,'department_id' => 7, 'name' => 'Khuai khawi (Bee keeping)'],
            ['id'=>43,'department_id' => 7, 'name' => 'Chaw leh ei tur sawngbawl (Food Processing)'],
            ['id'=>44,'department_id' => 7, 'name' => 'Chhang ur (Baking)'],
            ['id'=>45,'department_id' => 7, 'name' => 'Thingpui Dawr (Tea Stall)'],
            ['id'=>46,'department_id' => 7, 'name' => 'Eichawp Dawr (Grocery Store/Petty Shop)'],
            ['id'=>47,'department_id' => 7, 'name' => 'Kuthnathawk hman tur khawl leinan (Entirnan: Chhawhchhi/vaimim herna khawl)'],
            ['id'=>48,'department_id' => 7, 'name' => 'Other Micro Enterprises & Petty Trade'],

            //UD & PA 8
            ['id'=>49,'department_id' => 8, 'name' => 'Leitha siam (Home Composting)'],
            ['id'=>50,'department_id' => 8, 'name' => 'Hluihlawm thil atanga thil tangkai siamchhuah (Waste to Wealth'],
            ['id'=>51,'department_id' => 8, 'name' => 'Khawlai tihfai leh bawlhhlawh khawn khawm (Street sweeping and waste collection)'],
            ['id'=>52,'department_id' => 8, 'name' => 'Kawng sir dawr siam (Street vending)'],

            //TOURISM 9
            ['id'=>53,'department_id' => 9, 'name' => 'Tourism – Tourist guide / Tour operation'],


        ];

        Trade::query()->upsert($trades, ['id']);
    }
}
