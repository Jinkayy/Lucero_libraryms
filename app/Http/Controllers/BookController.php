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
        // 1. Fetch data for the main table/form
        $books = Book::with('category')->get();
        $categories = Category::all();

        // 2. Fetch data for the new dashboard cards
        $totalBooks = Book::count();
        $totalCategories = Category::count();
        $latestBook = Book::latest()->first(); // Gets the most recently created book

        return view('dashboard', compact('books', 'categories', 'totalBooks', 'totalCategories', 'latestBook'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id'),
            ],
        ]);

        Book::create($request->only('title', 'author', 'description', 'category_id'));

        return redirect()->back()->with('success', 'Book added successfully!');
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id'),
            ],
        ]);

        $book->update($request->only('title', 'author', 'description', 'category_id'));

        return redirect()->back()->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->back()->with('success', 'Book deleted successfully!');
    }
}