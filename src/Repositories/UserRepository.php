<?php
namespace src\Repositories;

use Exception;
use src\Models\User;

class UserRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new User($row['uuid'], $row['name'], $row['email'], $row['password'], $row['role']);
        }

        return null;
    }

    public function createUser(array $data)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO users (name, email, password, uuid, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $data['name'], $data['email'], $data['password'], $data['uuid'], $data['role']);
            return $stmt->execute();
        }
        catch (Exception $e) {
            die($e->getMessage());
        }
        
    }
}
?>
