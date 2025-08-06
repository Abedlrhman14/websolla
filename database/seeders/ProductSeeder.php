<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create();


        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'name'        => $faker->words(2, true),
                'description' => $faker->sentence(),
                'price'       => $faker->randomFloat(2, 50, 500),
                'image'       => 'products/sample.png',
            ]);
        }
    }
}
