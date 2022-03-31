<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OptionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
        $optionsTypes = ['boat_type'];
		// $optionsTypes = ['boat_type', 'hull_material', 'boat_activity'];
		$boat_type = ['Power', 'Sail', 'Personal Watercraft'];
		// $hull_material = ['Displacement', 'Planing', 'Flat Bottom', 'V-Bottom', 'Tri-Hull (Tunnel)', 'Pontoon', 'Semi-Displacement','Multi-Hull', 'Catamaran', 'Trimaran'];
		// $boat_activity = ['Boat Offshore', 'Day Cruising', 'Freshwater Fishing', 'Overnight Cruising', 'Personal Watercraft', 'Sailing', 'Saltwater Fishing', 'Water Sports', 'Transportation'];
		if (!empty($optionsTypes)) {
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
