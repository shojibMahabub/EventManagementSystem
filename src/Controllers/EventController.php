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
        include __DIR__ . '/../../views/events/home.php';
    }

    public function list()
    {
        $events = $this->eventService->getAllEventsWithUsers();
        include __DIR__ . '/../../views/events/events.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'capacity' => $_POST['capacity'] ?? '',
                'location' => $_POST['location'] ?? '',
                'datetime' => $_POST['datetime'] ?? '',
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
        $eventUuid = $_GET['uuid'] ?? 0;
        $event = $this->eventService->getEventByUuid($eventUuid);
        include __DIR__ . '/../../views/events/event_details.php';
    }


    public function edit()
    {
        $eventUuid = $_GET['uuid'] ?? 0;
        $event = $this->eventService->getEventByUuid($eventUuid);
        include __DIR__ . '/../../views/events/add_event.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'capacity' => $_POST['capacity'] ?? '',
                'location' => $_POST['location'] ?? '',
                'datetime' => $_POST['datetime'] ?? '',
                'uuid' => $_POST['uuid'] ?? '',
            ];

            $result = $this->eventService->updateEvent($data);

            if ($result['success']) {
                header('Location: /events');
                exit;
            } else {
                echo $result['message'];
            }
        } else {
            echo "Method not supported";
        }
    }

    public function delete()
    {
        $eventUuid = $_GET['uuid'] ?? 0;
        $this->eventService->deleteEventByUuid($eventUuid);
        header('Location: /events');
        exit;
    }

    public function apiList()
    {
        $events = $this->eventService->getAllEvents();

        header('Content-Type: application/json');
        echo json_encode($events);
    }

    public function apiDetails()
    {
        $eventUuid = $_GET['uuid'] ?? 0;
        $event = $this->eventService->getEventByUuid($eventUuid);

        header('Content-Type: application/json');
        echo json_encode($event);
    }
}