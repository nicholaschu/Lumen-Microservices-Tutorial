<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\BookService;
use App\Services\AuthorService;

class BookController extends Controller
{
    use ApiResponder;

    /**
     * The serivce to consume the book microservice
     * 
     * @var BookService
     */
    public $bookService;

    /**
     * The serivce to consume the author microservice
     * 
     * @var AuthorService
     */
    public $authorService;

    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    /**
     * Return the list of books
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse($this->bookService->obtainBooks());
    }

    /**
     * Create one new book
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorService->obtainAuthor($request->author_id);
        return $this->successResponse($this->bookService->createBook($request->all(), Response::HTTP_CREATED));
    }

    /**
     * Obtain and show one book
     * @return Illuminate\Http\Response
     */
    public function show($book)
    {
        return $this->successResponse($this->bookService->obtainBook($book));
    }

    /**
     * Update an existing book
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $book)
    {
        return $this->successResponse($this->bookService->editBook($request->all(), $book));
    }

    /**
     * Remove an existing book
     * @return Illuminate\Http\Response
     */
    public function destroy($book)
    {
        return $this->successResponse($this->bookService->deleteBook($book));
    }
}
