<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // php artisan migrate:fresh --seed  runs all of these in order
    // (categories before books, because books need a category_id)
    public function run(): void
    {
        $this->call([
            StaffSeeder::class,
            CustomerSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
        ]);
    }
}
