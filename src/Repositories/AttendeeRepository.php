<?php
namespace src\Repositories;

use Exception;
use src\Models\Attendee;
use src\Utils\Uuid;

class AttendeeRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function attachEventAttendee (array $data) {

        try {

            $uuid = new Uuid();
            $uuid = $uuid->generate();

            $stmt = $this->db->prepare("
                INSERT INTO event_users (uuid, event_uuid, user_uuid, event_status)
                VALUES (?, ?, ?, ?)
            ");
            
            $stmt->bind_param("ssss",
                $uuid,
                $data['event_uuid'],
                $data['user_uuid'],
                $data['status']
            );
            
            $result = $stmt->execute();
            
            if ($result) {
                return ['success' => true, 'message' => 'Event attached successfully.'];
            } else {
                return ['success' => false, 'message' => 'Database error: ' . implode(' ', $stmt->errorInfo())];
            }  
        }
        catch (Exception $e) {
            echo "Exception : " . $e->getMessage();
        }
    }

    public function checkForExistingEvent ($data) {
        $stmt = $this->db->prepare("SELECT * FROM event_users WHERE event_uuid = ? AND user_uuid = ?");
        $stmt->bind_param("ss", $data['event_uuid'], $data['user_uuid']);
        $result = $stmt->execute();
        
        return ($result) ? 'True' : 'False';
    }


    public function updateEventAttendee (array $data) {

        try {
            $stmt = $this->db->prepare("
                UPDATE event_users SET event_status = ? WHERE event_uuid = ? AND user_uuid = ?
                VALUES (?, ?, ?)
            ");
            
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
        }
        catch (Exception $e) {
            echo "Exception : " . $e->getMessage();
        }
    }
}
?>
