<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        return Book::all();
    }


    public function store(Request $request)
    {
        $request->validate([ 
            'title' => ['required']
        ]);

        $book = Book::create($request->all());
        return $book;
    }


    public function show(Book $book)
    {
        return $book;
    }


    public function update(Request $request, Book $book)
    {

        $request->validate([ 
            'title' => ['required']
        ]);

        $book->update($request->all());
        
        return $book;
    }


    public function destroy(Book $book)
    {
        $book->delete();
        
        return response()->nocontent();
    }
}
