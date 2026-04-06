<?php

namespace App\Http\Controllers;

use App\Contracts\BookServiceInterface;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class BookController extends Controller
{
    protected BookServiceInterface $bookService;
    public function __construct(BookServiceInterface $bookService)
    {
        $this->bookService = $bookService;
    }




    public function index(Request $request): View
    {

        $filters = $request->only(['search', 'category_id', 'author', 'publisher', 'published_from', 'published_to']);
        $perPage = $request->get('per_page', 10);
        $books = $this->bookService->getAllBooks($filters, (int) $perPage);
        $categories = $this->bookService->getAllCategories();



        return view('books.index', compact('books', 'categories', 'filters'));


    }



    public function create(): View
    {
        $categories = $this->bookService->getAllCategories();
        return view('books.create', compact('categories'));
    }





    public function store(BookCreateRequest $request): RedirectResponse
    {


        $validatedData = $request->validated();


        $book = $this->bookService->createBook($validatedData);

        
        return redirect()
            ->route('books.index')
            ->with('success', 'Book "' . $book->title . '" has been created successfully.');


    }



    public function show(int $id): View|RedirectResponse
    {
        $book = $this->bookService->getBookById($id);

        if (!$book) {
            return redirect()
                ->route('books.index')
                ->with('error', 'Book not found.');
        }

        return view('books.show', compact('book'));
    }




    public function edit(int $id): View|RedirectResponse
    {
        $book = $this->bookService->getBookById($id);
        


        if (!$book) {
            return redirect()
                ->route('books.index')
                ->with('error', 'Book not found.');
        }



        $categories = $this->bookService->getAllCategories();


    

        return view('books.edit', compact('book', 'categories'));
    }








    public function update(BookUpdateRequest $request, int $id): RedirectResponse
    {

        $validatedData = $request->validated();


        
        $book = $this->bookService->updateBook($id, $validatedData);



        if (!$book) {
            return redirect()
                ->route('books.index')
                ->with('error', 'Book not found.');
        }

        

        return redirect()
            ->route('books.index')
            ->with('success', 'Book "' . $book->title . '" has been updated successfully.');


    }




    public function destroy(int $id): RedirectResponse

    {
        $book = $this->bookService->getBookById($id);
        

        if (!$book) {
            return redirect()
                ->route('books.index')
                ->with('error', 'Book not found.');
        }


        $bookTitle = $book->title;

        
        $this->bookService->deleteBook($id);


        return redirect()
            ->route('books.index')
            ->with('success', 'Book "' . $bookTitle . '" has been deleted successfully.');
            
    }
}
