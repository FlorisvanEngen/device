<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Device;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->create([
            'name' => 'Camera'
        ]);

        Category::factory()->create([
            'name' => 'Kast'
        ]);

        Category::factory()->create([
            'name' => 'PC'
        ]);

        User::factory()->create([
            'name' => 'Floris van Engen',
            'email' => 'floris.van.engen@connectionsystems.nl',
            'password' => 'password123'
        ]);

        Device::factory(33)->create([
            'category_id' => 1
        ]);

        Device::factory(33)->create([
            'category_id' => 2
        ]);

        Device::factory(34)->create([
            'category_id' => 3
        ]);

        Photo::factory(1)->create([
            'device_id' => 1,
            'name' => 'illustration-1.png',
            'photo_path' => 'img/illustration-1.png'
        ]);
        Photo::factory(1)->create([
            'device_id' => 1,
            'name' => 'illustration-2.png',
            'photo_path' => 'img/illustration-2.png'
        ]);

        Photo::factory(1)->create([
            'device_id' => 1,
            'name' => 'illustration-3.png',
            'photo_path' => 'img/illustration-3.png'
        ]);

        Photo::factory(1)->create([
            'device_id' => 2,
            'name' => 'illustration-4.png',
            'photo_path' => 'img/illustration-4.png'
        ]);

        Photo::factory(1)->create([
            'device_id' => 2,
            'name' => 'illustration-5.png',
            'photo_path' => 'img/illustration-5.png'
        ]);
    }
}
