<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Device;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create.blade.php();

        // \App\Models\User::factory()->create.blade.php([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

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
            'password' => bcrypt('password123')
        ]);

        Device::factory(2)->create([
            'category_id' => 1
        ]);

        Device::factory(2)->create([
            'category_id' => 2
        ]);

        Device::factory(2)->create([
            'category_id' => 3
        ]);

        Photo::factory(2)->create([
            'device_id' => 1,
            'photo_path' => 'img/illustration-1.png'
        ]);

        Photo::factory(2)->create([
            'device_id' => 1,
            'photo_path' => 'img/illustration-4.png'
        ]);

        Photo::factory(2)->create([
            'device_id' => 2,
            'photo_path' => 'img/illustration-3.png'
        ]);
    }
}
