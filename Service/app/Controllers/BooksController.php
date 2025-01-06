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
        $available = $this->request->getPost('available') == '1';  // Convert to boolean (true/false)
        
        // Proceed with insertion
        $data = [
            'title'    => $this->request->getPost('title'),
            'author'   => $this->request->getPost('author'),
            'available'=> $available, // Use boolean value
        ];
    
        $model = new BookModel();
    
        if ($model->insert($data)) {
            return redirect()->to('/books')->with('success', 'Book added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add book');
        }
    }
    
    // Fetch details of a specific book
    public function show($id = null)
    {
        $model = new BookModel();
        $book = $model->find($id);

        if (!$book) {
            return $this->failNotFound('Book not found');
        }

        return view('show', ['book' => $book]);
    }

    // Update a book's information (e.g., availability status)
    public function update($id = null)
    {
        $model = new BookModel();
        $book = $model->find($id);
    
        if (!$book) {
            return $this->failNotFound('Book not found');
        }
    
        // If the form is submitted (POST method), handle the update
        if ($this->request->getMethod() === 'post') {
            $data = [
                'title'    => $this->request->getPost('title'),
                'author'   => $this->request->getPost('author'),
                'available'=> $this->request->getPost('available'),
            ];
    
            if (!$model->update($id, $data)) {
                return $this->failValidationErrors($model->errors());
            }
    
            return redirect()->to('/books')->with('success', 'Book updated successfully!');
        }
    
        // If the form hasn't been submitted, show the form with current values
        return view('update', ['book' => $book]);
    }
    

    // Checkout a book
    // Toggle availability of a book
    public function toggleAvailability($id = null)
    {
        $model = new BookModel();
        $book = $model->find($id);

        if (!$book) {
            return $this->failNotFound('Book not found');
        }

        // Toggle availability (1 <-> 0)
        $book['available'] = $book['available'] == 1 ? 0 : 1;

        if (!$model->update($id, $book)) {
            return $this->fail('Failed to update book availability');
        }

        return redirect()->to('/books')->with('success', 'Book availability updated!');
    }
    // Delete a specific book
    public function delete($id = null)
    {
        $model = new BookModel();
        $book = $model->find($id);

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
}
