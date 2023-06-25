<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $users = [
            [
                'name' => 'Minar',
                'email' => 'm@gmail.com',
                'password' => bcrypt('12345678'),
                'user_type' => 'admin',
                'db_name' => 'db_1',
            ],
            [
                'name' => 'Sandy',
                'email' => 's@gmail.com',
                'password' => bcrypt('12345678'),
                'user_type' => 'seller',
                'db_name' => 'db_2',
            ]
           
        ];

        foreach ($users as $user) {
            User::create($user);
        }

         $products = [
            [
                'name' => 'Napa',
            ],
            [
                'name' => 'Napa 1',
            ],
            [
                'name' => 'Napa 2',
            ],
            [
                'name' => 'Napa 3',
            ],
           
        ];

        foreach ($products as $pro) {
            Product::create($pro);
        }
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
