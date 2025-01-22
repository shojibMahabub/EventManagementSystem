<?php
namespace src\Repositories;

use src\Models\Event;

class EventRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $events = [];
        $result = $this->db->query("SELECT * FROM events");

        while ($row = $result->fetch_assoc()) {
            $events[] = new Event($row['id'], $row['name'], $row['description'], $row['capacity']);
        }

        return $events;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO events (name, description, capacity) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $data['name'], $data['description'], $data['capacity']);
        return $stmt->execute();
    }

    public function findById(int $id): ?Event
    {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            return new Event($row['id'], $row['name'], $row['description'], $row['capacity']);
        }

        return null;
    }
}
?>
