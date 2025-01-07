<?php
namespace App\Controllers;

use App\Models\BookModel;
use CodeIgniter\RESTful\ResourceController;

class BooksController extends ResourceController
{
    protected $modelName = 'App\Models\BookModel';
    protected $format    = 'json';

    // List all books
    public function index()
    {
        $model = new BookModel();
        $data['books'] = $model->findAll();  // Fetching all books from the database
    
        return view('index', $data);  // Ensure this view path is correct
    }

    // Create a new book
    public function create()
    {    
        // Get form data
        $available = $this->request->getPost('availability_status');
        
        // Proceed with insertion
        $data = [
            'id'               => uniqid(), // Generate a unique ID (you can change this to use UUID if needed)
            'title'            => $this->request->getPost('title'),
            'author'           => $this->request->getPost('author'),
            'genre'            => $this->request->getPost('genre'),
            'isbn'             => $this->request->getPost('isbn'),
            'published_date'   => $this->request->getPost('published_date'),
            'availability_status'=> $available, // Use the enum value
        ];
    
        $model = new BookModel();
    
        if ($model->insert($data)) {
            return redirect()->to('/books')->with('success', 'Book added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add book');
        }
    }

    // Update a book's information (e.g., availability status)
    public function update($id = null)
    {
        $model = new BookModel();
        $book = $model->find($id);
    
        if (!$book) {
            return $this->failNotFound('Book not found');
        }
    
        // If the form is submitted via POST
        if ($this->request->getMethod() === 'post') {
            // Validation and data updates
            $data = [
                'title' => $this->request->getPost('title'),
                'author' => $this->request->getPost('author'),
                'genre' => $this->request->getPost('genre'),
                'isbn' => $this->request->getPost('isbn'),
                'published_date' => $this->request->getPost('published_date'),
                'availability_status' => $this->request->getPost('availability_status')
            ];
    
            // Update the book data
            if (!$model->update($id, $data)) {
                return $this->failValidationErrors($model->errors());
            }
    
            return redirect()->to('/books')->with('success', 'Book updated successfully!');
        }
    
        // If it's a GET request, show the update form with the current book data
        return view('update', ['book' => $book]);
    }
    
    
    public function delete($id = null)
    {
        $model = new BookModel();
        $book = $model->find($id);  // Find the book by UUID
    
        if (!$book) {
            return $this->failNotFound('Book not found');
        }
    
        // Attempt to delete the book
        if ($model->delete($id)) {
            return redirect()->to('/books')->with('success', 'Book deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete book');
        }
    }
    
    
    public function toggleAvailability($id = null)
    {
        $model = new BookModel();
        $book = $model->find($id);
    
        if (!$book) {
            return $this->failNotFound('Book not found');
        }
    
        // Toggle availability status
        $newStatus = $book['availability_status'] == 'Available' ? 'Borrowed' : 'Available';
        $book['availability_status'] = $newStatus;
    
        if (!$model->update($id, $book)) {
            return $this->fail('Failed to update book availability');
        }
    
        return redirect()->to('/books')->with('success', 'Book availability updated!');
    }

    public function show($id = null)
    {
        $model = new BookModel();
        $book = $model->find($id);

        if (!$book) {
            return $this->failNotFound('Book not found');
        }

        return view('show', ['book' => $book]);
    }

}
