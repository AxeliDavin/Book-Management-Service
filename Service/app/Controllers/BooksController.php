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
        return view('index', $data);  // Pass books data to the view
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

    // Update a book's information
    public function update($id = null)
    {
        $model = new BookModel();
        $book = $model->find($id);
    
        if (!$book) {
            return $this->failNotFound('Book not found');
        }
    
        // Log the request method
        log_message('debug', 'Request method: ' . $this->request->getMethod());
    
        if ($this->request->getMethod() === 'post' || $this->request->getMethod() === 'put') {
            log_message('debug', 'Received data: ' . print_r($this->request->getPost(), true));
    
            $data = [
                'title'    => $this->request->getPost('title'),
                'author'   => $this->request->getPost('author'),
                'genre'    => $this->request->getPost('genre'),
                'isbn'     => $this->request->getPost('isbn'),
                'published_date' => $this->request->getPost('published_date'),
                'availability_status' => $this->request->getPost('availability_status'),
            ];
    
            if (!$model->update($id, $data)) {
                log_message('error', 'Update failed: ' . print_r($model->errors(), true));
                return view('update', [
                    'book' => $book,
                    'errors' => $model->errors(),
                ]);
            }
    
            return redirect()->to('/books')->with('success', 'Book updated successfully!');
        }
    
        return view('update', ['book' => $book]);
    }
    
    public function delete($id = null)
    {
        $model = new BookModel();
    
        if (!$model->find($id)) {
            return $this->failNotFound('Book not found');
        }
    
        if ($model->delete($id)) {
            return redirect()->to('/books')->with('success', 'Book deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to delete book.');
        }
    }    
    
    public function show($id = null)
    {
        $model = new BookModel();
    
        if ($id === null) {
            // If no ID is provided, return all books
            $books = $model->findAll();
            return $this->respond($books);
        }
    
        // If ID is provided, return a specific book
        $book = $model->find($id);
    
        if (!$book) {
            return $this->failNotFound('Book not found');
        }
    
        return $this->respond($book);
    }

}
