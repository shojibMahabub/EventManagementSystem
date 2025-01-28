<?php
namespace src\Controllers;

use src\Services\AttendeeService;
use src\Services\EventService;

class AttendeeController
{
    private $attendeeService;
    private $eventService;

    public function __construct($db)
    {
        $this->attendeeService = new AttendeeService($db);
        $this->eventService = new EventService($db);
    }

    public function register()
    {

        $events = $this->eventService->getAllEvents();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? ''
            ];

            $result = $this->attendeeService->register($data);

            if ($result['success']) {
                header('Location: /login');
                exit;
            } else {
                echo $result['message'];
            }
        } else {
            include __DIR__ . '/../../views/attendee/register.php';
        }

    }

    public function attachEvent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $data = [
                'event_uuid' => $_POST['event_uuid'] ?? '',
                'status' => $_POST['status'] ?? '',
                'user_uuid' => $_SESSION['user']->uuid ?? '',
            ];
            $result = $this->attendeeService->attachEventToAttendee($data);

        } else {
            echo "Method not supported";
        }
    
    }
}