<?php
namespace src\Services;

use src\Repositories\UserRepository;
use src\Utils\Uuid;

class AuthService
{
    private $userRepository;

    public function __construct($db)
    {
        $this->userRepository = new UserRepository($db);
    }

    public function login(string $email, string $password): array
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            return ['success' => false, 'message' => 'User not found.'];
        }

        if (!password_verify($password, $user->password)) {
            return ['success' => false, 'message' => 'Invalid credentials.'];
        }

        $_SESSION['user'] = $user;
        return ['success' => true, 'message' => 'Login successful.'];
    }

    public function register(array $data): array
    {
        if ($this->userRepository->findByEmail($data['email'])) {
            return ['success' => false, 'message' => 'Email already registered.'];
        }

        $uuid = new Uuid();
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        $result = $this->userRepository->createUser([
            'uuid' => $uuid->generate(),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $hashedPassword,
            'role' => $data['role']
        ]);

        if ($result) {
            return ['success' => true, 'message' => 'Registration successful.'];
        }

        return ['success' => false, 'message' => 'Registration failed.'];
    }
}

?>
