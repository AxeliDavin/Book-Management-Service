<?php
namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table      = 'books';
    protected $primaryKey = 'id';

    protected $allowedFields = ['title', 'author', 'available'];

    // Automatically manage created_at and updated_at fields
    protected $useTimestamps = true;

    // Validation rules (optional)
    protected $validationRules = [
        'title'  => 'required|min_length[3]',
        'author' => 'required|min_length[3]',
        'available' => 'required|in_list[1,0]', // 1 = available, 0 = checked out
    ];
}
