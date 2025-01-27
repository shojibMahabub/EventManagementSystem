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
                $events[] = new Event(
                    $row['uuid'], 
                    $row['name'], 
                    $row['description'], 
                    $row['capacity'], 
                    $row['event_date_time'], 
                    $row['location'], 
                    $row['created_at'], 
                    $row['updated_at']
                );
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
            $uuid = $uuid->generate();
            $created_at = date('Y-m-d\TH:i');
            $updated_at = date('Y-m-d\TH:i');

            $stmt = $this->db->prepare("
                INSERT INTO events (name, description, capacity, uuid, created_at, updated_at, location, event_date_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->bind_param("ssisssss", 
                $data['name'], 
                $data['description'], 
                $data['capacity'],
                $uuid,
                $created_at,
                $updated_at,
                $data['location'],
                $data['datetime']
            );
            
            $result = $stmt->execute(); 

            if ($result) {
                return ['success' => true, 'message' => 'Event created successfully.'];
            } else {
                return ['success' => false, 'message' => 'Database error: ' . implode(' ', $stmt->errorInfo())];
            }        
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
        
    }

    public function update(array $data)
    {
        try {
            var_dump($data);
            $stmt = $this->db->prepare("UPDATE events SET name = ?, description = ?, capacity = ? WHERE uuid = ?");
            
            $stmt->bind_param("ssii", $data['name'], $data['description'], $data['capacity'], $data['uuid']);
            
            return $stmt->execute();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    

    public function findByUuid(string $uuid)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM events WHERE uuid = ?");
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($row = $result->fetch_assoc()) {
                return new Event(
                    $row['uuid'], 
                    $row['name'], 
                    $row['description'], 
                    $row['capacity'], 
                    $row['event_date_time'], 
                    $row['location'], 
                    $row['created_at'], 
                    $row['updated_at']
                );
            }
    
            return null;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function deleteByUuid(string $uuid)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM events WHERE uuid = ?");
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
}

