<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
    
        // Get the JWT token from the session
        $jwt = $session->get('auth_token');
    
        if (!$jwt) {
            // If no token is found, redirect to login page
            return redirect()->to('/login');
        }
    
        try {
            // Decode the token to verify its validity
            $key = getenv('JWT_SECRET_KEY'); // Secret key from .env file
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    
            // Token is valid, proceed with the request
            return;
        } catch (\Exception $e) {
            // If the token is invalid or expired, redirect to login
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing needed after the request
    }
}
