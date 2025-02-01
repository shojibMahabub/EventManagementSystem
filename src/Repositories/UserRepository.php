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
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    public function findByUuid(array|string $uuid)
    {
        if (is_array($uuid)) {
            $placeholders = implode(',', array_fill(0, count($uuid), '?'));
            $query = "SELECT * FROM users WHERE uuid IN ($placeholders)";
            $stmt = $this->db->prepare($query);
    
            if (!$stmt) {
                throw new Exception("SQL Error: " . $this->db->error);
            }
    
            $types = str_repeat('s', count($uuid)); 
            $stmt->bind_param($types, ...$uuid);
        } else {
            $query = "SELECT * FROM users WHERE uuid = ?";
            $stmt = $this->db->prepare($query);
    
            if (!$stmt) {
                throw new Exception("SQL Error: " . $this->db->error);
            }
    
            $stmt->bind_param("s", $uuid);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = new User($row['uuid'], $row['name'], $row['email'], $row['password'], $row['role']);
        }
    
        return count($users) === 1 ? $users[0] : $users;
    }
    
    
}
