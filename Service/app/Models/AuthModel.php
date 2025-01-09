<?php
namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'password', 'role'];

    // Validate user credentials
    public function validateUser($username, $password)
    {
        // Fetch the user by username
        $user = $this->where('username', $username)->first();
        
        // Check if user exists and password matches
        if ($user && $user['password'] === $password) {
            return $user;
        }

        return null;
    }
}
