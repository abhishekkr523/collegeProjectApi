<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Imports\BooksImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    // Get all books (index)
    public function index(Request $request)
    {
        $query = Book::query(); // Start the query builder
    
        if ($request->has('search1')) {
            $query->where('title', 'LIKE', "%{$request->input('search1')}%");
        }
    
        if ($request->has('search2')) {
            $query->where('author', 'LIKE', "%{$request->input('search2')}%");
        }
    
        if ($request->has('search3')) {
            $query->where('isbn', 'LIKE', "%{$request->input('search3')}%");
        }
    
        $books = $query->get(); // Execute the query
    
        if ($books->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Book is not found',
            ], 200);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Books retrieved successfully',
            'data' => $books
        ]);
    }
    


    // Get a single book by ID
    public function show($id)
    {
        $book = Book::findOrFail($id); // Find book by ID
        return response()->json($book);
    }

    // Add a new book
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'required|digits:4',
            'isbn' => 'required|string|unique:books,isbn',
            'number_of_pages' => 'nullable|integer',
            'status' => 'required|in:available,borrowed,reserved',
        ]);

        // Create a new book record in the database
        $book = Book::create($request->all());

        // Return the created book as a JSON response
        return response()->json($book, 201);
    }

    // Update an existing book
    public function update(Request $request, $id)
    {
        // return $request;
        // Find the book by ID
        $book = Book::findOrFail($id);

        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'publication_year' => 'required|digits:4',
            'isbn' => 'required|string|unique:books,isbn,' . $id,
            'number_of_pages' => 'nullable|integer',
            'status' => 'required|in:available,borrowed,reserved',
        ]);

        // Update the book record
        $book->update($request->all());

        // Return the updated book as a JSON response
        return response()->json($book);
    }
//     public function update(Request $request, $id)
// {
//     // Find the book by ID
//     $book = Book::findOrFail($id);

//     // Validate the incoming request data
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'author' => 'required|string|max:255',
//         'publisher' => 'nullable|string|max:255',
//         'publication_year' => 'required|digits_between:3,4',
//         'isbn' => 'required|string|unique:books,isbn,' . $id,
//         'number_of_pages' => 'nullable|integer',
//         'status' => 'required|in:available,borrowed,reserved',
//     ]);

//     // Manually update the fields you want to update
//     $book->title = $request->input('title');
//     $book->author = $request->input('author');
//     $book->publisher = $request->input('publisher');
//     $book->publication_year = $request->input('publication_year');
//     $book->isbn = $request->input('isbn');
//     $book->number_of_pages = $request->input('number_of_pages');
//     $book->status = $request->input('status');

//     // Save the changes to the book
//     $book->save();

//     // Return the updated book as a JSON response
//     return response()->json($book);
// }


    // Delete a book
    public function destroy($id)
    {
        // Find the book by ID
        $book = Book::findOrFail($id);

        // Delete the book record
        $book->delete();

        // Return a success message
        return response()->json(['message' => 'Book deleted successfully']);
    }
 
    public function import(Request $request)
    {
        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle the file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            Excel::import(new BooksImport, $file);

            return response()->json(['message' => 'Books imported successfully'], 200);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }

    
}

