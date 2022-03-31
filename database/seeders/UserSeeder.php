<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		$faker = Faker\Factory::create();
		// $admin = \App\Models\User::where('role', 'admin')->first();
		// if (empty($admin)) {
		// 	for ($i = 1; $i < 50; $i++) {
        //         \App\Models\User::firstOrCreate([
        //             'email' => 'admin'.$i.'@admin.com'
        //         ],[
        //             'uuid' => (string) Str::uuid(),
        //             'password' => '$2y$10$pa6SN2t9aIeH19N3WvPb0eNQC3i7Jcp7YyxYvcs/g/ZgZ/P7RImR2', // password
        //             'contact_number' => $faker->phoneNumber,
        //             'first_name' => $faker->firstName,
        //             'last_name' => $faker->lastName,
        //             'address' => $faker->streetAddress,
        //             'city' => $faker->city,
        //             'country' => $faker->country,
        //             'state' => $faker->state,
        //             'zip_code' => $faker->postcode,
        //             'email_verified_at' => now(),
        //             'role' => 'admin',
        //             'is_request_price' => array_rand([0,1]),
        //             'remember_token' => Str::random(10),
        //         ]);
		// 	}
		// }

        for ($i = 1; $i < 10; $i++) {
            \App\Models\User::firstOrCreate([
                'email' => 'user'.$i.'@admin.com'
            ],[
                'uuid' => (string) Str::uuid(),
                'password' => '$2y$10$pa6SN2t9aIeH19N3WvPb0eNQC3i7Jcp7YyxYvcs/g/ZgZ/P7RImR2', // password
                'contact_number' => $faker->phoneNumber,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'country' => $faker->country,
                'state' => $faker->state,
                'zip_code' => $faker->postcode,
                'email_verified_at' => now(),
                'role' => 'user',
                'is_request_price' => array_rand([0,1]),
                'remember_token' => Str::random(10),
            ]);
        }

	}
}
