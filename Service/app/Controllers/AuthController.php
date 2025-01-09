<?php
namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use Firebase\JWT\JWT;
use App\Models\AuthModel;

class AuthController extends Controller
{
    use ResponseTrait;

    // Show login form
    public function index()
    {
        // Check if the user is already logged in (check for JWT token in session)
        if (session()->has('auth_token')) {
            // Validate the token
            try {
                $jwt = session()->get('auth_token');
                $decoded = JWT::decode($jwt, getenv('JWT_SECRET_KEY'), ['HS256']);
                // If token is valid, redirect to the books page
                return redirect()->to(getenv('APP_URL') . '/books');
            } catch (Exception $e) {
                // If the token is invalid or expired, clear session and redirect to login
                session()->remove('auth_token');
                return redirect()->to(getenv('APP_URL') . '/login');
            }
        }
    
        // If no token found, show the login page
        return view('login'); // or return a response for your login form
    }

    // Handle login form submission
    public function login()
    {
        // Check if user is already logged in (avoid submitting form if logged in)
        if (session()->has('auth_token')) {
            return redirect()->to(getenv('APP_URL') . '/books');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        
        $authModel = new AuthModel();
        $user = $authModel->validateUser($username, $password);
        
        if ($user) {
            // Create JWT payload and session token
            $iat = time();
            $exp = $iat + getenv('JWT_EXPIRATION');
            $payload = [
                'iat' => $iat,
                'exp' => $exp,
                'sub' => $user['id'],
                'role' => $user['role']
            ];
            
            $jwt = JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS256');
            session()->set('auth_token', $jwt);
    
            // Redirect to the books page after successful login
            return redirect()->to(getenv('APP_URL') . '/books');
        } else {
            // If login fails, redirect back to login with an error message (no view rendering)
            return redirect()->to(getenv('APP_URL') . '/login')->with('error', 'Invalid credentials');
        }
    }

    // Handle logout and remove session
    public function logout()
    {
        // Remove the JWT token from session
        session()->remove('auth_token');
        session()->destroy();
    
        // Redirect to the login page after logging out
        return redirect()->to(getenv('APP_URL') . '/login');
    }
}
