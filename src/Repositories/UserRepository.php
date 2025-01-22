<?php
namespace src\Repositories;

use src\Models\User;

class UserRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new User($row['id'], $row['name'], $row['email'], $row['password']);
        }

        return null;
    }

    public function createUser(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $data['name'], $data['email'], $data['password']);
        return $stmt->execute();
    }
}
?>
