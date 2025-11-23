<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Show all categories
    public function index()
    {
        // Fetch all categories
        $categories = Category::all();

        // Return the view
        return view('categories', compact('categories'));
    }

    // Store a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', // Added unique validation for 'name'
            'description' => 'nullable|string|max:500', // Added max limit for safety
        ]);

        Category::create($request->only('name', 'description'));

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    /**
     * Update the specified category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            // Ensure the name is unique, but ignore the current category's ID
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:500',
        ]);

        // Update the category instance with validated data
        $category->update($validatedData);

        // Redirect to the index page with a success message
        return redirect()->route('categories.index')
                         ->with('success', 'Category "' . $category->name . '" updated successfully!');
    }

    // Delete a category
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}