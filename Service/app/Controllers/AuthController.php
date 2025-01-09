<?php
namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use Firebase\JWT\JWT;
use App\Models\AuthModel;

class AuthController extends Controller
{
    use ResponseTrait;

    // Show the login form
    public function index()
    {
        return view('login');  // Return the login view when accessing /
    }

    // AuthController.php - Login method
    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $authModel = new AuthModel();
        $user = $authModel->validateUser($username, $password);
        
        if ($user) {
            // Create JWT payload
            $iat = time();  // Issued at time
            $exp = $iat + getenv('JWT_EXPIRATION');  // Expiration time (use any future value)

            // Simulate token expiration by setting an expiration in the past
            // To expire immediately upon logout, set expiration to a value like:
            //$exp = time() - 3600;  // 1 hour ago (This will immediately expire the token)

            $payload = [
                'iat' => $iat,  // Issued at time
                'exp' => $exp,  // Expiration time
                'sub' => $user['id'],  // Subject: user ID
                'role' => $user['role'] // User role
            ];

            // Encode JWT with the secret key and algorithm
            $jwt = JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS256');
            
            // Store the token in session
            session()->set('auth_token', $jwt);

            // Redirect the user after successful login
            return redirect()->to('/books');
        } else {
            return $this->failUnauthorized('Invalid credentials');
        }
    }

    public function logout()
    {
        // Clear the session to remove the JWT token
        session()->remove('auth_token');

        // Optionally, you can also destroy the session entirely
        session()->destroy();

        // Redirect the user to the login page
        return redirect()->to('/login');
    }
    
}
