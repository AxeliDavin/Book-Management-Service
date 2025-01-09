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
                return $this->respond([
                    'status' => 'success',
                    'message' => 'Redirecting to books page...',
                    'redirect' => getenv('APP_URL') . '/books'
                ]);
            } catch (Exception $e) {
                // If the token is invalid or expired, clear session and redirect to login
                session()->remove('auth_token');
                return $this->respond([
                    'status' => 'error',
                    'message' => 'Session expired or invalid token, please login again.',
                    'redirect' => getenv('APP_URL') . '/login'
                ]);
            }
        }

        // If no token found, send a message indicating the user should login
        return $this->respond([
            'status' => 'info',
            'message' => 'No active session found, please login.',
            'redirect' => getenv('APP_URL') . '/login'
        ]);
    }

    // Handle login form submission
    public function login()
    {
        // Check if user is already logged in (avoid submitting form if logged in)
        if (session()->has('auth_token')) {
            return $this->respond([
                'status' => 'success',
                'message' => 'Already logged in, redirecting to books page.',
                'redirect' => getenv('APP_URL') . '/books'
            ]);
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
            return $this->respond([
                'status' => 'success',
                'message' => 'Login successful!',
                'redirect' => getenv('APP_URL') . '/books'
            ]);
        } else {
            // If login fails, send a failure message and redirection info
            return $this->respond([
                'status' => 'error',
                'message' => 'Invalid credentials, please try again.',
                'redirect' => getenv('APP_URL') . '/login'
            ]);
        }
    }

    // Handle logout and remove session
    public function logout()
    {
        // Remove the JWT token from session
        session()->remove('auth_token');
        session()->destroy();
    
        // Send a response to indicate successful logout and redirection
        return $this->respond([
            'status' => 'success',
            'message' => 'Logged out successfully.',
            'redirect' => getenv('APP_URL') . '/login'
        ]);
    }
}
