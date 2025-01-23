<?php
namespace src\Repositories;

use Exception;
use src\Models\Event;
use src\Utils\Uuid;

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
        try {
            $result = $this->db->query("SELECT * FROM events");
        }
        
        catch (Exception $e) {
            echo $e->getMessage();
        }

        while ($row = $result->fetch_assoc()) {
            $events[] = new Event($row['id'], $row['name'], $row['description'], $row['capacity']);
        }

        return $events;
    }

    public function create(array $data): bool
    {
        try{
            $uuid = new Uuid();
            $stmt = $this->db->prepare("INSERT INTO events (name, description, capacity, uuid) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $data['name'], $data['description'], $data['capacity'], $uuid->generate());
            
            return $stmt->execute();            
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        
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
