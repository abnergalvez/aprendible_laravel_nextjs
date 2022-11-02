<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Book;

class BooksApiTest extends TestCase
{
    use RefreshDatabase;

    

    function test_can_get_all_books()
    {
        $books = Book::factory(4)->create();
        $response = $this->getJson(route('books.index'));

        $response->assertJsonFragment([
            'title' => $books[0]->title
        ])->assertJsonFragment([
            'title' => $books[1]->title
        ]);
    }

    function test_can_get_one_book()
    {
        $book = Book::factory()->create();
        $response = $this->getJson(route('books.show',$book));
        $response->assertJsonFragment([
            'title' => $book->title
        ]);
    }

    function test_can_create_books()
    {
        $this->postJson(route('books.store'),[])
            ->assertJsonValidationErrorFor('title');

        $this->postJson(route('books.store'),[
            'title' => 'Mi nuevo libro'
        ])->assertJsonFragment([
            'title' => 'Mi nuevo libro'
        ]);

        $this->assertDatabaseHas('books', [
            'title' => 'Mi nuevo libro'
        ]);
    }

    function test_can_update_books() 
    {
        $book = Book::factory()->create();

        $this->patchJson(route('books.update', $book),[])
            ->assertJsonValidationErrorFor('title');

        $this->patchJson( route('books.update', $book), [
            'title' => 'Libro Editado'
        ])->assertJsonFragment([
            'title' => 'Libro Editado'
        ]);
    }

    function test_can_delete_books() 
    {
        $book = Book::factory()->create();
        $this->deleteJson(route('books.destroy', $book))->assertNoContent();
        $this->assertDatabaseCount('books', 0 );
    }

}
