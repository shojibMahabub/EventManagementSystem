<?php

namespace src\Repositories;

use Exception;
use src\Models\Event;
use src\Models\EventUser;
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
                    $row['updated_at'],
                    $row['spot_left'],
                );
            }

            return $events;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function create(array $data)
    {
        try {
            $uuid = new Uuid();
            $uuid = $uuid->generate();
            $created_at = date('Y-m-d\TH:i');
            $updated_at = date('Y-m-d\TH:i');

            $stmt = $this->db->prepare("
                INSERT INTO events (name, description, capacity, uuid, created_at, updated_at, location, event_date_time, spot_left) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $stmt->bind_param("ssisssssi",
                $data['name'],
                $data['description'],
                $data['capacity'],
                $uuid,
                $created_at,
                $updated_at,
                $data['location'],
                $data['datetime'],
                $data['capacity']
            );

            $result = $stmt->execute();

            if ($result) {
                return ['success' => true, 'message' => 'Event created successfully.'];
            } else {
                return ['success' => false, 'message' => 'Database error: ' . implode(' ', $stmt->errorInfo())];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

    }

    public function update(array $data)
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE events 
                    SET name = ?, 
                    description = ?, 
                    capacity = ?,
                    location = ?,
                    event_date_time = ? 
                WHERE uuid = ?
            ");
            $stmt->bind_param("ssisss",
                $data['name'],
                $data['description'],
                $data['capacity'],
                $data['location'],
                $data['datetime'],
                $data['uuid'],
            );

            $res = $stmt->execute();

            if (!$res) {
                echo "Error: " . $stmt->error;
            }

            return $res;

        } catch (Exception $e) {
            die($e->getMessage());
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
                    $row['updated_at'],
                    $row['spot_left']

                );
            }

            return null;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function deleteByUuid(string $uuid)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM events WHERE uuid = ?");
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getSingleEventWithUsers($eventUuid) {
        try {
            $result = $this->db->query("
                SELECT 
                    e.*, 
                    eu.uuid AS event_user_uuid, 
                    eu.user_uuid, 
                    eu.event_status 
                FROM events e 
                LEFT JOIN event_users eu ON e.uuid = eu.event_uuid 
                WHERE e.uuid = '$eventUuid';
            ");
        
            if (!$result) {
                die("Query failed: " . $this->db->error);
            }
    
            $event = null;
            $eventUsers = [];
    
            while ($row = $result->fetch_assoc()) {
                if (!$event) {
                    $event = new Event(
                        $row['uuid'],
                        $row['name'],
                        $row['description'],
                        $row['capacity'],
                        $row['event_date_time'],
                        $row['location'],
                        $row['created_at'],
                        $row['updated_at'],
                        $row['spot_left']
                    );
                }
    
                $eventUser = new EventUser(
                    $row['event_user_uuid'],
                    $row['user_uuid'],
                    $row['uuid'],
                    $row['event_status']
                );
    
                $eventUsers[] = $eventUser;
            }
    
            foreach ($eventUsers as $eventUser) {
                $event->addEventUser($eventUser);
            }
    
            return $event;
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function getAllEventsWithUsers($page = 1, $limit = 10, $search = '', $filter = [])
    {
        $offset = ($page - 1) * $limit;

        $query = "
            SELECT 
                e.*, 
                eu.uuid AS event_user_uuid, 
                eu.user_uuid, 
                eu.event_status 
            FROM events e 
            LEFT JOIN event_users eu ON e.uuid = eu.event_uuid
        ";
    
        $conditions = [];
        $params = [];
    
        if (!empty($search)) {
            $conditions[] = "(e.name LIKE ? OR e.description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
    
        if (!empty($filter['location'])) {
            $conditions[] = "e.location = ?";
            $params[] = $filter['location'];
        }
    
        if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
            $conditions[] = "e.event_date_time BETWEEN ? AND ?";
            $params[] = $filter['start_date'];
            $params[] = $filter['end_date'];
        }

        if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
            $conditions[] = "e.event_date_time BETWEEN ? AND ?";
            $params[] = $filter['start_date'];
            $params[] = $filter['end_date'];
        }

        if (!empty($filter['capacity'])) {
            $conditions[] = "e.capacity >= ?";
            $params[] = $filter['capacity'];
        }

        if (!empty($filter['spot_left'])) {
            $conditions[] = "e.spot_left >= ?";
            $params[] = $filter['spot_left'];
        }
    
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    
        $query .= " LIMIT $limit OFFSET $offset;";
        // die ($query);
        try {
            $stmt = $this->db->prepare($query);
            if ($stmt === false) {
                die("Prepare failed: " . $this->db->error);
            }
    
            if (!empty($params)) {
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);
            }
    
            $stmt->execute();
            $result = $stmt->get_result();
    
            $events = [];
    
            while ($row = $result->fetch_assoc()) {
                $event = new Event(
                    $row['uuid'],
                    $row['name'],
                    $row['description'],
                    $row['capacity'],
                    $row['event_date_time'],
                    $row['location'],
                    $row['created_at'],
                    $row['updated_at'],
                    $row['spot_left']
                );
    
                $eventUser = new EventUser(
                    $row['event_user_uuid'],
                    $row['user_uuid'],
                    $row['uuid'],
                    $row['event_status']
                );
    
                $event->addEventUser($eventUser);
    
                if (!isset($events[$event->uuid])) {
                    $events[$event->uuid] = $event;
                } else {
                    $events[$event->uuid]->addEventUser($eventUser);
                }
            }
    
            return array_values($events);
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
    
    public function getTotalEventsCount($search = '', $filter = [])
    {
        $query = "SELECT COUNT(*) AS total FROM events e";
    
        $conditions = [];
        $params = [];
    
        if (!empty($search)) {
            $conditions[] = "(e.name LIKE ? OR e.description LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
    
        if (!empty($filter['location'])) {
            $conditions[] = "e.location = ?";
            $params[] = $filter['location'];
        }
    
        if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
            $conditions[] = "e.event_date_time BETWEEN ? AND ?";
            $params[] = $filter['start_date'];
            $params[] = $filter['end_date'];
        }
    
        if (!empty($filter['capacity'])) {
            $conditions[] = "e.capacity >= ?";
            $params[] = $filter['capacity'];
        }

        if (!empty($filter['spot_left'])) {
            $conditions[] = "e.spot_left >= ?";
            $params[] = $filter['spot_left'];
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    
        try {
            $stmt = $this->db->prepare($query);
            if ($stmt === false) {
                die("Prepare failed: " . $this->db->error);
            }
    
            if (!empty($params)) {
                $types = str_repeat('s', count($params));
                $stmt->bind_param($types, ...$params);
            }
    
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['total'];
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

}

