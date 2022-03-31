<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $superAdmin = \App\Models\User::whereRole('super_admin')->first();
        if (empty($superAdmin)) {
            \App\Models\User::create([
                'uuid' => (string) Str::uuid(),
                'email' => 'admin@admin.com',
                'password' => '$2y$10$pa6SN2t9aIeH19N3WvPb0eNQC3i7Jcp7YyxYvcs/g/ZgZ/P7RImR2', // password
                'contact_number' => $faker->phoneNumber,
                'first_name' => 'admin',
                'last_name' => 'admin',
                'address' => $faker->streetAddress,
                'city' => $faker->city,
                'country' => $faker->country,
                'state' => $faker->state,
                'zip_code' => $faker->postcode,
                'role' => 'admin',
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        }
    }
}
