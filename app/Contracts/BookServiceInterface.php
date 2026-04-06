<?php

namespace App\Contracts;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;


interface BookServiceInterface
{

    public function getAllBooks(array $filters = [], int $perPage = 10);


    public function getBookById(int $id): ?Book;

    public function createBook(array $data): Book;


    public function updateBook(int $id, array $data): ?Book;


    public function deleteBook(int $id): bool;


    public function searchBooks(string $query);

    public function getAllCategories();
}
