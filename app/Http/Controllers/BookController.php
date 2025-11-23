<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index()
    {
        // Load books with categories
        $books = Book::with('category')->get();
        $categories = Category::all();

        return view('dashboard', compact('books', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',  // ✅ added
            'description' => 'nullable|string',
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id'),
            ],
        ]);

        // ✅ Save title + author + description + category_id
        Book::create($request->only('title', 'author', 'description', 'category_id'));

        return redirect()->back()->with('success', 'Book added successfully!');
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255', // ✅ added
            'description' => 'nullable|string',
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id'),
            ],
        ]);

        // ✅ Update all fields
        $book->update($request->only('title', 'author', 'description', 'category_id'));

        return redirect()->back()->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->back()->with('success', 'Book deleted successfully!');
    }
}
