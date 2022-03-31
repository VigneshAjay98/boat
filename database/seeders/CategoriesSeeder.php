<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*1'Power',
         2'Sail'*/
         $categoriesName =[
            'Power' => ["Aft Cabin", "Airboat", "Aluminum Fish","Barge (Power)", "Bass", "Bay"],
            'Sail' => ["Sloop", "Barge (Sail)", "Center Cockpit", "Cruiser (Sail)"],
            'Personal Watercraft' => [ "Antique and Classic (Power)", "Beach Catamaran", "Commercial (Sail)"]
        ];

        $categoryInfo = [
            'Power' => [
                "Aft Cabin" => [
                                'description' => 'Aft Cabin boats are larger size vessels generally used for on-the-water activities such as overnight cruising and day cruising. These types of vessels can range in size, with the smallest current boat listed at 22 feet in length, to the longest vessel measuring in at 65 feet, and an average length of 39 feet.',
                                'other_information' =>'Some of the most popular manufacturers of aft cabin boats presently include: Carver, Sea Ray, Silverton, Chris-Craft and Hatteras.',
                                'activity' => 'Overnight Cruising'
                            ],
                "Airboat" => [
                                    'description' => 'Swamp (Air) Boat is widely used in the USA by tourism sector for taking the tourists to the creek and marshy land areas where conventional boats could not reach or denied access by nature.',
                                    'other_information' =>'Swamp (Air) Boat can be effectively employed in Wild Life sanctuaries, Crocodile dominated areas, Dolphin dominated areas, Creek areas (e.g. Kutch, Gujarat) etc. It is ideal for adventure savvy tourists who like to go to interior creeks and marshy lands.',
                                    'activity' => 'Freshwater Fishing'
                                ],
                "Aluminum Fish" => [
                                    'description' => 'Aluminum fishing boats come in three basic styles: jon boats, Mod-V (or Modified-Vee), and Deep-V. Jon Boats have a very flat bottom and a squared-off or blunt bow and are especially popular for use on rivers and smaller lakes because they can operate in shallow water and get on plane quickly.',
                                    'other_information' =>'Small aluminum fishing boats can be transported in the bed of a pick-up truck or even on the roof rack of an automobile, while the largest models are designed to head out on big water and are equipped with a long list of angling features.',
                                    'activity' => 'Saltwater Fishing'
                ],
                "Barge (Power)" => [
                                    'description' => 'A barge is a flat-bottomed boat, built mainly for river and canal transport of bulk goods. Originally barges were towed by draft horses on an adjacent towpath.',
                                    'other_information' =>'In Great Britain, during the Industrial Revolution, a substantial network of narrow barges was developed from 1750 onwards; but from 1825 competition from the railways eventually took over from canal traffic due to the higher speed, falling costs and route flexibility of rail transport.',
                                    'activity' => 'Transportation'
                                ],
                "Bass" => [
                                    'description' => 'A bass boat is a small boat that is designed and equipped primarily for bass fishing or fishing for other panfish, usually in freshwater such as lakes, rivers and streams.',
                                    'other_information' =>'Bass boats are typically either constructed of aluminum or fiberglass. The aluminum boats are lighter and typically smaller in size and less expensive than the fiberglass versions. ',
                                    'activity' => 'Freshwater Fishing'
                                ],
                "Bay" => [
                                'description' => 'As the name suggests, bay boats are for using in the bays and nearshore areas, and they may be too small for the open ocean, at least when the waves are up. These boats essentially fill the niche between small flats boats, which have a shallow draft for floating in shallow water, and larger boats that are made for open water. ',
                                'other_information' =>'Bay boats have the ability to fish in shallow water but the stability to handle deeper areas. They are also maneuverable, as they need to navigate tighter spaces. They usually have enough room on deck for about four anglers.',
                                'activity' => 'Saltwater Fishing'
                            ],
                        ],
            'Sail' => [
                "Sloop" => [
                                    'description' => 'A sloop is a sailboat usually with one mast and fore-and-aft rigged sails. It can also describe a square rigged sailing ship of two or more masts which is sometimes called a sloop of war.',
                                    'other_information' => 'The sloop design dates back to the early part of the 17th century. By the 20th century they became very popular. Their main advantages are their ease of handling and ability to sail upwind (into the wind).',
                                    'activity' => 'Sailing'
                                ],
                "Barge (Sail)" => [
                                    'description' => 'A barge is a flat-bottomed boat, built mainly for river and canal transport of bulk goods. Originally barges were towed by draft horses on an adjacent towpath.',
                                    'other_information' => 'In Great Britain, during the Industrial Revolution, a substantial network of narrow barges was developed from 1750 onwards; but from 1825 competition from the railways eventually took over from canal traffic due to the higher speed, falling costs and route flexibility of rail transport.',
                                    'activity' => 'Transportation'
                                ],
                "Center Cockpit" => [
                                        'description' => 'Center cockpit sailboats, which have an additional cabin and deck space aft of the cockpit, are quite popular with cruisers who often bring guests aboard. By shifting the cockpit forward and placing a stateroom aft (and often a head), sleeping areas are separated and privacy aboard is greatly enhanced',
                                        'other_information' => '1. Activities: Overnight Cruising and Day Sailing 2. Length Range: 25 - 70 ft. 3. Average price: $205,000 4. 2-3 cabins',
                                        'activity' => 'Sailing'
                                    ],
                "Cruiser (Sail)" =>  [
                                    'description' => 'Cruising sailboats are ones that are designed to be used over long distances. They are bigger, stronger, and far more stable. If you imagine a typical small sailboat such as a wayfarer you are looking at a pretty solid boat.',
                                    'other_information' => 'The bigger the boat the better, not only for stability but for comfort. If you are going to be essentially trapped on your boat for several days it is a good idea to have as much room to move about as possible.',
                                    'activity' => 'Day Cruising'
                                ],
                ],
            'Personal Watercraft' =>[
                "Antique and Classic (Power)" => [
                            'description' => 'Antique: A boat built between 1919 and 1942, inclusive. Classic: A boat built between 1943 and 1975, inclusive.',
                            'other_information' =>'Boats are classic in design and having wooden structure.',
                            'activity' => 'Personal Watercraft'
                        ],
                "Beach Catamaran" => [
                    'description' => 'Beachcat Saltwater Pontoon Boats manufactures top of the line Saltwater Pontoon Boats specifically engineered to withstand the harsh conditions of a saltwater environment. Our pontoon boats not only stand-up to the toughest saltwater conditions in the world but they provide the unparalleled comfort and luxury our customers expect from a Beachcat saltwater pontoon boat.',
                    'other_information' => 'Each and every Beachcat boat is built around the No Wood No Rot system. We use only 100% all composite materials and fiberglass to construct our top of the line boats. This allows for a greater longevity and overall durability of our saltwater pontoons.',
                    'activity' => 'Personal Watercraft'
                ],
                "Commercial (Sail)" =>  [
                    'description' => 'Commercial yachts are large, sailing vessels generally used for time-honored yachting activities such as a variety of commercial and recreational boating activities. These sailing vessels have a rich legacy as vessels that are sought-after due to their very deep draft and average beam, traits that make them exceptionally well-suited for a variety of commercial and recreational boating activities.',
                    'other_information' => 'Across our current listings, the average capacity for commercial sailing vessels is 36 people with a maximum capacity of 142 passengers, and the average length overall (LOA) is 73 feet. Listings range in size from 33 feet long to 172 feet long, with an average sail area of 2,034 square feet and a maximum sail area of 2,034 square feet. ',
                    'activity' => 'Personal Watercraft'
                ],
            ]

        ];
        foreach($categoriesName as $key=>$names){
            foreach($names as $name){
                $category = \App\Models\Category::firstOrCreate([
                    'boat_type' => $key,
                    'name' => $name
                ],
                [
                    'uuid' => (string) Str::uuid(),
                    'description' =>  $categoryInfo[$key][$name]['description'],
                    'other_info' => $categoryInfo[$key][$name]['other_information'],
                ]);
                if(!empty($category)){
                    $activity =  $categoryInfo[$key][$name]['activity'];
                    $option_id = \App\Models\Option::where('option_type', 'boat_activity')->where('name', $activity)->first()->id;
                    if(isset($option_id)){
                        \App\Models\ActivityCategory::firstOrCreate([
                            'category_id' => $category->id,
                            'option_id' => $option_id
                        ],
                        [
                               'uuid' => (string) Str::uuid(),
                        ]);
                    }
                }
            }
        }
    }
}
