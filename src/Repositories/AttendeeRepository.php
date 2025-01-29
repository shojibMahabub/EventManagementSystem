<?php

namespace src\Repositories;

use Exception;
use src\Utils\Uuid;

class AttendeeRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function attachEventAttendee(array $data)
    {
        try {
            $uuid = (new Uuid())->generate();
    
            $this->db->begin_transaction();
    
            $checkStmt = $this->db->prepare("SELECT spot_left FROM events WHERE uuid = ? FOR UPDATE");
            $checkStmt->bind_param("s", $data['event_uuid']);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            $event = $result->fetch_assoc();
    
            if (!$event || $event['spot_left'] <= 0) {
                $this->db->rollback();
                return ['success' => false, 'message' => 'No available spots left.'];
            }
    
            $updateStmt = $this->db->prepare("
                UPDATE events SET spot_left = spot_left - 1 WHERE uuid = ? AND spot_left > 0
            ");
            $updateStmt->bind_param("s", $data['event_uuid']);
            $updateStmt->execute();
    
            if ($updateStmt->affected_rows === 0) {
                $this->db->rollback();
                return ['success' => false, 'message' => 'Failed to update spot count.'];
            }
    
            $insertStmt = $this->db->prepare("
                INSERT INTO event_users (uuid, event_uuid, user_uuid, event_status)
                VALUES (?, ?, ?, ?)
            ");

            $insertStmt->bind_param("ssss",
                $uuid,
                $data['event_uuid'],
                $data['user_uuid'],
                $data['status']
            );
            $insertResult = $insertStmt->execute();
    
            if (!$insertResult) {
                $this->db->rollback();
                return ['success' => false, 'message' => 'Failed to insert event user.'];
            }
    
            $this->db->commit();
    
            return ['success' => true, 'message' => 'Event attached successfully.'];
            
        } catch (Exception $e) {
            $this->db->rollback();
            return ['success' => false, 'message' => 'Exception: ' . $e->getMessage()];
        }
    }
    

    public function checkForExistingEvent($data)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM event_users WHERE event_uuid = ? AND user_uuid = ?");
            $stmt->bind_param("ss", $data['event_uuid'], $data['user_uuid']);
            $stmt->execute();
            $result = $stmt->get_result();
            return ($result->num_rows > 0) ? true : false;
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }


    public function updateEventAttendee(array $data)
    {

        try {
            $stmt = $this->db->prepare("UPDATE event_users SET event_status = ? WHERE event_uuid = ? AND user_uuid = ?");

            $stmt->bind_param("sss",
                $data['status'],
                $data['event_uuid'],
                $data['user_uuid'],
            );

            $result = $stmt->execute();

            if ($result) {
                return ['success' => true, 'message' => 'Event attached successfully.'];
            } else {
                return ['success' => false, 'message' => 'Database error: ' . implode(' ', $stmt->errorInfo())];
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
}
