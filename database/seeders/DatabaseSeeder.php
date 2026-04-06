<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            ['name' => 'Fiction', 'description' => 'Literary works of fiction'],
            ['name' => 'Non-Fiction', 'description' => 'Non-fiction books'],
            ['name' => 'Science', 'description' => 'Scientific literature'],
            ['name' => 'Technology', 'description' => 'Technology and computing'],
            ['name' => 'History', 'description' => 'Historical books'],
            ['name' => 'Biography', 'description' => 'Biographical works'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample books
        $books = [
            [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'isbn' => '978-0743273565',
                'publisher' => 'Scribner',
                'published_date' => '1925-04-10',
                'description' => 'A novel set in the Jazz Age.',
                'category_id' => 1,
            ],
            [
                'title' => 'To Kill a Mockingbird',
                'author' => 'Harper Lee',
                'isbn' => '978-0061120084',
                'publisher' => 'Harper Perennial',
                'published_date' => '1960-07-11',
                'description' => 'A novel about racial injustice.',
                'category_id' => 1,
            ],
            [
                'title' => '1984',
                'author' => 'George Orwell',
                'isbn' => '978-0451524935',
                'publisher' => 'Signet Classic',
                'published_date' => '1949-06-08',
                'description' => 'A dystopian novel.',
                'category_id' => 1,
            ],
            [
                'title' => 'A Brief History of Time',
                'author' => 'Stephen Hawking',
                'isbn' => '978-0553380163',
                'publisher' => 'Bantam',
                'published_date' => '1988-04-01',
                'description' => 'A landmark in science writing.',
                'category_id' => 3,
            ],
            [
                'title' => 'The Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '978-0132350884',
                'publisher' => 'Prentice Hall',
                'published_date' => '2008-08-01',
                'description' => 'A handbook of agile software craftsmanship.',
                'category_id' => 4,
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}
