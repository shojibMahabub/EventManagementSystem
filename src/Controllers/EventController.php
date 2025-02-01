<?php

namespace src\Controllers;

use src\Services\EventService;
use src\Utils\View;
class EventController
{
    private $eventService;

    public function __construct($db)
    {
        $this->eventService = new EventService($db);
    }

    public function index()
    {
        include View::generate('events/home');
    }

    public function listEvents()
    {
        $page = $_GET['page'] ?? 1;
        $limit = $_GET['limit'] ?? 5;
        $search = $_GET['search'] ?? '';
        $filter = $_GET['filter'] ?? [];
    
        if (!empty($_GET['date_range'])) {
            $dateRange = explode(' to ', $_GET['date_range']);
            $filter['start_date'] = $dateRange[0] ?? '';
            $filter['end_date'] = $dateRange[1] ?? $dateRange[0];
        }
    
        $events = $this->eventService->getAllEventsWithUsers($page, $limit, $search, $filter);
        $totalEvents = $this->eventService->getTotalEventsCount($search, $filter);
        $totalPages = ceil($totalEvents / $limit);

        include View::generate('events/event_list');
    }

    public function addEvent()
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
            include View::generate('events/add_event');
        }
    }

    public function eventDetails()
    {
        $eventUuid = $_GET['uuid'] ?? 0;
        $event = $this->eventService->getSingleEventWithUsers($eventUuid);
        include View::generate('events/event_details');
    }


    public function editEvent()
    {
        $eventUuid = $_GET['uuid'] ?? 0;
        $event = $this->eventService->getEventByUuid($eventUuid);
        include View::generate('events/add_event');
    }

    public function updateEvent()
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

    public function deleteEvent()
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