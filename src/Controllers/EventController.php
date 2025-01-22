<?php
namespace src\Controllers;

use src\Services\EventService;

class EventController
{
    private $eventService;

    public function __construct($db)
    {
        $this->eventService = new EventService($db);
    }

    public function index()
    {
        $events = $this->eventService->getAllEvents();
        include __DIR__ . '/../../views/events/dashboard.php';
    }

    public function list()
    {
        $events = $this->eventService->getAllEvents();
        include __DIR__ . '/../../views/events/dashboard.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'capacity' => $_POST['capacity'] ?? ''
            ];

            $result = $this->eventService->createEvent($data);

            if ($result['success']) {
                header('Location: /events');
                exit;
            } else {
                echo $result['message'];
            }
        } else {
            include __DIR__ . '/../../views/events/add_event.php';
        }
    }

    public function details()
    {
        $eventId = $_GET['id'] ?? 0;
        $event = $this->eventService->getEventById($eventId);
        include __DIR__ . '/../../views/events/event_details.php';
    }

    public function apiList()
    {
        $events = $this->eventService->getAllEvents();

        header('Content-Type: application/json');
        echo json_encode($events);
    }

    public function apiDetails()
    {
        $eventId = $_GET['id'] ?? 0;
        $event = $this->eventService->getEventById($eventId);

        header('Content-Type: application/json');
        echo json_encode($event);
    }
}