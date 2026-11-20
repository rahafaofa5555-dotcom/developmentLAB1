<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::first();

        $books = [
    ['name' => 'The Silent Forest', 'ISBN' => '978-0000000001', 'author' => 'John Smith',
     'publisher' => 'Jarir', 'publish_date' => '2020-05-01', 'category_id' => $category->id],
    ['name' => 'Physics Basics', 'ISBN' => '978-0000000002', 'author' => 'Sara Ahmed',
     'publisher' => 'Obeikan', 'publish_date' => '2021-09-15', 'category_id' => $category->id],
    ];



        foreach ($books as $book) {
            Book::updateOrCreate(['ISBN' => $book['ISBN']], $book);
        }
    }
}
