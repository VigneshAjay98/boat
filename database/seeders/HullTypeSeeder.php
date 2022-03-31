<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HullTypeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$optionsTypes = ['hull_material'];
		$hull_material = ['Displacement', 'Planing', 'Flat Bottom', 'V-Bottom', 'Tri-Hull (Tunnel)', 'Pontoon', 'Semi-Displacement','Multi-Hull', 'Catamaran', 'Trimaran'];
		if (!empty($optionsTypes)) {
			 \App\Models\Option::where('option_type','hull_material')->delete();
			foreach($optionsTypes as $option){
                $optionNames = $$option;
                foreach($optionNames as $name){
                    \App\Models\Option::firstOrCreate([
                        'name' => $name,
                        'option_type' => $option
                    ],
                    [
                        'uuid' => (string) Str::uuid(),
                    ]);
                }

			}
		}

	}
}
