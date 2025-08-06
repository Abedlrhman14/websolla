<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use Faker\Factory as Faker;
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            Order::create([
                'customer_name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'address' => $faker->address,
                'cart' => json_encode([
                    $faker->randomDigitNotNull => [
                        'name' => $faker->word,
                        'price' => $faker->randomFloat(2, 10, 500),
                        'quantity' => $faker->numberBetween(1, 5),
                        'image' => null,
                    ],
                ]),
            ]);
        }
    }
}
