<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Menu;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('asdfasdf'),
                'dietary_preference' => null,
                'phone_number' => null,
                'profile_picture' => 'profile_picture/default-profile.png',
                'role' => 'admin',
            ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('asdfasdf'),
                'dietary_preference' => 'Omnivore',
                'phone_number' => '012-3456789',
                'profile_picture' => 'profile_picture/default-profile.png',
                'role' => 'user',
                'email_verified_at' => now(),
                'remember_token' => null,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $menus = [
            [
                'name' => 'White Rice',
                'description' => 'Great source of carbohydrates, providing energy for daily activities.',
                'nutrient' => 'Carbohydrate',
                'price' => 1.00,
                'image' => 'menu/Yn1dphbuW1Sm5yKhnBGK5swzhgbYqvnzJwUfoHkI.jpg',
            ],
            [
                'name' => 'Grilled Chicken',
                'description' => 'Lean protein source, essential for muscle repair and growth.',
                'nutrient' => 'Protein',
                'price' => 3.00,
                'image' => 'menu/wvzYMk54DUtBR4j8AfneamfoDipLyYR5GbqMJ2gX.jpg',
            ],
            [
                'name' => 'Bok Choy',
                'description' => 'Fibre-rich vegetable, promoting digestive health and providing essential minerals.',
                'nutrient' => 'Dietary Fibre',
                'price' => 1.50,
                'image' => 'menu/btVMFdlrudac33kz3vD7Nwy7eRe7BVlilt9Yty3m.jpg',
            ],
            [
                'name' => 'Kiwi',
                'description' => 'High in Vitamin C, supporting immune function and skin health.',
                'nutrient' => 'Vitamin',
                'price' => 1.20,
                'image' => 'menu/32eBEygFkeVLFN45euUnr9m01PaqMH8u63txRlPD.jpg',
            ],
            [
                'name' => 'Banana',
                'description' => 'Rich in potassium, aiding in muscle function and heart health.',
                'nutrient' => 'Mineral',
                'price' => 1.00,
                'image' => 'menu/zooLn11829aXSg3LJs4QuL11mdEyEAexF0eeK5kA.jpg',
            ],
            [
                'name' => 'Olive Oil',
                'description' => 'Healthy fat source, rich in monounsaturated fats and antioxidants.',
                'nutrient' => 'Fat',
                'price' => 2.00,
                'image' => 'menu/R7MqRjhePLlyv3mEfJ5QH2AgOAmmsIAYiJNfdJB6.jpg',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
