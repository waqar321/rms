<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\ecom_category;
use Faker\Factory as Faker;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Loop to generate and store 10 thousand records
        for ($i = 0; $i < 10000; $i++) {
            ecom_category::create([
                'name' => $faker->word,
                'image' => $faker->imageUrl(),
                'image_path' => $faker->imageUrl(),
                'parent_id' => null, // Adjust if necessary
                'is_active' => $faker->boolean(90), // 90% probability of being active
                'is_deleted' => $faker->boolean(5), // 5% probability of being deleted
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    }
