<?php

namespace Database\Seeders;

use App\Models\Crop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CropsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $crops = [
            [
                'genre' => 'قمح',
                'target' => 'exportation',
                'type' => 'sell',
                'quantity' => '100 طن',
                'Price' => 2000.50,
                'phone' => '0123456789',
                'img' => 'images/wheat.jpg',
                'city_id' => 1,
                'user_id' => rand(1,10),
            ],
            [
                'genre' => 'أرز',
                'target' => 'local',
                'type' => 'purchase',
                'quantity' => '50 طن',
                'Price' => 1500.75,
                'phone' => '0987654321',
                'img' => null,
                'city_id' => 2,
                'user_id' => rand(1,10),
            ],
            [
                'genre' => 'ذرة',
                'target' => 'exportation',
                'type' => 'sell',
                'quantity' => '120 طن',
                'Price' => 1700.00,
                'phone' => '0155555555',
                'img' => 'images/corn.jpg',
                'video' => null,
                'city_id' => 1,
                'user_id' => rand(1,10),
            ],
            [
                'genre' => 'شعير',
                'target' => 'local',
                'type' => 'purchase',
                'quantity' => '30 طن',
                'Price' => 900.25,
                'phone' => '0177777777',
                'img' => null,
                'city_id' => 3,
                'user_id' => rand(1,10),
            ],
            [
                'genre' => 'شوفان',
                'target' => 'exportation',
                'type' => 'purchase',
                'quantity' => '80 طن',
                'Price' => 2200.00,
                'phone' => '0166666666',
                'img' => null,
                'city_id' => 4,
                'user_id' => rand(1,10),
            ],
            [
                'genre' => 'فول الصويا',
                'target' => 'local',
                'type' => 'sell',
                'quantity' => '60 طن',
                'Price' => 1800.75,
                'phone' => '0199999999',
                'img' => 'images/soybeans.jpg',
                'video' => null,
                'city_id' => 2,
                'user_id' => rand(1,10),
            ],
            [
                'genre' => 'ذرة بيضاء',
                'target' => 'exportation',
                'type' => 'purchase',
                'quantity' => '40 طن',
                'Price' => 1300.50,
                'phone' => '0188888888',
                'img' => null,
                'city_id' => 5,
                'user_id' => rand(1,10),
            ],
            [
                'genre' => 'دخن',
                'target' => 'local',
                'type' => 'purchase',
                'quantity' => '25 طن',
                'Price' => 700.00,
                'phone' => '0133333333',
                'img' => null,
                'video' => null,
                'city_id' => 6,
                'user_id' => rand(1,10),
            ],
            [
                'genre' => 'قطن',
                'target' => 'exportation',
                'type' => 'sell',
                'quantity' => '150 طن',
                'Price' => 3500.00,
                'phone' => '0144444444',
                'img' => 'images/cotton.jpg',
                'video' => null,
                'city_id' => 4,
                'user_id' => rand(1,10),
            ],
            [
                'genre' => 'فرولة',
                'target' => 'local',
                'type' => 'sell',
                'quantity' => '90 طن',
                'Price' => 1600.25,
                'phone' => '0111111111',
                'img' => 'images/peanuts.jpg',
                'city_id' => 3,
                'user_id' => rand(1,10),
            ],
        ];


        foreach ($crops as $crop) {
            Crop::create($crop);
        }
    }
}
