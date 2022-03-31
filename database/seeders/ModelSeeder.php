<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $brandIds = \App\Models\Brand::select('id')
			->pluck('id')
			->toArray();
        $models = [
            ['Bertram 35 Flybridge', 'Bertram 28CC', 'Bertram 61 Convertible' , 'Bertram 50 Sport'],
            ['Bertram 35 Flybridge', 'Bertram 28CC', 'Bertram 61 Convertible' , 'Bertram 50 Sport'],
            ['VANTAGE', 'OUTRAGE', 'REALM', 'CONQUEST', 'SUPER SPORT', 'MONTAUK', 'DAUNTLESS'],
            ['SSX', '267 SSX', '267 SSX OB', '287 SSX', '307 SSX', '317 SSX', '347 SSX'],
            ['Fisherman 236', 'Freedom 215', "Grady-Whites flagship"],
            ['1875 PRO V', '1975 PRO V', '1600 ALASKAN', 'WC 16'],
            ['NXT20', 'NXT22', 'NXT24', 'XT20', 'XT21', 'XT22'],
            ['SunSport 230', 'SunSport 230 OB'],
            ['Mod V Boats', ' Deep V Boats'],
            ['19ft Boats', '21ft Boats', '25ft Boats'],
            ['Open Bridge', 'Motor Yachts']
        ];

        foreach($brandIds as $brandId) {
            $modelNames = $models[rand(1,10)];
            foreach($modelNames as $name){
                \App\Models\BrandModel::firstOrCreate([
                    'model_name' => $name,
                    'brand_id' => $brandId
                ],
                [
                    'uuid' => (string) Str::uuid(),
                ]);
            }
        }
    }
}
