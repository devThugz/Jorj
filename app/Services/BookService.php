<?php

namespace App\Services;

use App\Contracts\BookServiceInterface;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class BookService implements BookServiceInterface
{
    
    private const DEFAULT_PER_PAGE = 10;

    private const MAX_PER_PAGE = 100;


    public function getAllBooks(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $perPage = $this->sanitizePerPage($perPage);
        
        $query = Book::with('category');
        
        $query = $this->applyFilters($query, $filters);

        $query->orderBy('created_at', 'desc');

        return $query->paginate($perPage);
    }

    public function getBookById(int $id): ?Book
    {
        try {
            return Book::with('category')->findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning("Book not found with ID: {$id}");
            return null;
        }
    }

    public function createBook(array $data): Book
    {
        return DB::transaction(function () use ($data) {
            $book = Book::create($data);
            
            Log::info("Book created successfully: {$book->id}");
            
            return $book;
        });
    }

    public function updateBook(int $id, array $data): ?Book
    {
        $book = $this->getBookById($id);
        
        if (!$book) {
            return null;
        }

        return DB::transaction(function () use ($book, $data) {
            $book->update($data);
            
            Log::info("Book updated successfully: {$book->id}");
            
            return $book->fresh('category');
        });
    }

    public function deleteBook(int $id): bool
    {
        $book = $this->getBookById($id);
        
        if (!$book) {
            return false;
        }

        return DB::transaction(function () use ($book) {
            $book->delete();
            
            Log::info("Book deleted successfully: {$book->id}");
            
            return true;
        });
    }

    public function searchBooks(string $query): LengthAwarePaginator
    {
        return Book::with('category')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('author', 'like', "%{$query}%")
                  ->orWhere('isbn', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(self::DEFAULT_PER_PAGE);
    }


    public function getAllCategories()
    {
        return Category::orderBy('name')->get();
    }


    private function sanitizePerPage(int $perPage): int
    {
        if ($perPage < 1) {
            return self::DEFAULT_PER_PAGE;
        }
        
        if ($perPage > self::MAX_PER_PAGE) {
            return self::MAX_PER_PAGE;
        }
        
        return $perPage;
    }


    private function applyFilters($query, array $filters): \Illuminate\Database\Eloquent\Builder
    {
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['author'])) {
            $query->where('author', 'like', "%{$filters['author']}%");
        }

        if (!empty($filters['publisher'])) {
            $query->where('publisher', 'like', "%{$filters['publisher']}%");
        }

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', "%{$filters['search']}%")
                  ->orWhere('author', 'like', "%{$filters['search']}%")
                  ->orWhere('isbn', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['published_from'])) {
            $query->where('published_date', '>=', $filters['published_from']);
        }

        if (!empty($filters['published_to'])) {
            $query->where('published_date', '<=', $filters['published_to']);
        }

        return $query;
    }
}
