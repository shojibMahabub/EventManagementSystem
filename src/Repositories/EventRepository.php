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

    public function getAll()
    {
        $events = [];
        try {
            $result = $this->db->query("SELECT * FROM events");
                    while ($row = $result->fetch_assoc()) {
            $events[] = new Event($row['uuid'], $row['name'], $row['description'], $row['capacity']);
        }

        return $events;
        }
        
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function create(array $data)
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

    public function findByUuid(string $uuid)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM events WHERE uuid = ?");
            $stmt->bind_param("i", $uuid);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($row = $result->fetch_assoc()) {
                return new Event($row['uuid'], $row['name'], $row['description'], $row['capacity']);
            }
    
            return null;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
?>
