<?php

namespace src\Controllers;

use src\Services\AuthService;

class AuthController
{
    private $authService;

    public function __construct($db)
    {
        $this->authService = new AuthService($db);
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'role' => $_POST['role'] ?? ''
            ];

            $result = $this->authService->register($data);

            if ($result['success']) {
                header('Location: /login');
                exit;
            } else {
                echo $result['message'];
            }
        } else {
            include __DIR__ . '/../../views/auth/register.php';
        }
    }

    public function apiLogin()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';
        $result = $this->authService->login($email, $password);

        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $result = $this->authService->login($email, $password);

            if ($result['success']) {
                header('Location: /events');
                exit;
            } else {
                echo $result['message'];
            }
        } else {
            include __DIR__ . '/../../views/auth/login.php';
        }
    }
}