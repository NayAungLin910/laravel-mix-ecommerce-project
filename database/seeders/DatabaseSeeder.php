<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // user
        User::create([
            'name' => 'userone',
            'email' => 'userone@gmail.com',
            'password' => Hash::make('password'),
            'image' => "/images/user.png",
            'phone' => "09793578992",
            'address' => "No.14, Nannattaw St, 15 yard, Helden, Yangon, Yangon Region"
        ]);

        // admin
        Admin::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        // category
        $category = ['T-Shirt', 'Hat', 'Electronic', 'Mobile', 'EarPhone', 'Food'];
        foreach ($category as $c) {
            Category::create([
                'slug' => uniqid() . Str::slug($c),
                'name' => $c,
                'mm_name' => "မြန်မာ",
                'image' => '/images/category.webp',
            ]);
        }

        // brand
        $brand = ['Samsung', 'Huwaie', 'Apple', 'Fresh'];
        foreach ($brand as $b) {
            Brand::create([
                'slug' => uniqid() . Str::slug($b),
                'name' => $b,
            ]);
        }

        // color
        $color = ['red', 'green', 'blue', 'black', 'brown'];
        foreach ($color as $c) {
            Color::create([
                'slug' => uniqid() . Str::slug($c),
                'name' => $c,
            ]);
        }

        // supplier
        Supplier::create([
            'name' => 'Mg Mg',
            'slug' => uniqid() . Str::slug('Mg Mg'),
            'image' => 'supplier.png',
        ]);

        Supplier::create([
            'name' => 'Kyaw Kyaw',
            'slug' => uniqid() . Str::slug('Kyaw Kyaw'),
            'image' => 'supplier.png',
        ]);
    }
}
