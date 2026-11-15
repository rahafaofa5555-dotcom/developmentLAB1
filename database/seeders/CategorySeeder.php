<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Novels',  'details' => 'Fiction and story books'],
            ['name' => 'Science', 'details' => 'Physics, chemistry and biology books'],
            ['name' => 'History', 'details' => 'Books about historical events'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}