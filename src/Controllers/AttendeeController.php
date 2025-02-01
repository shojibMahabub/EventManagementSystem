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

    public function attachEvent()
    {
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

    public function exportAttendeeData()
    {
        if ($_SESSION['user']->role === 'admin') {
            $eventUuid = '1C356248-0D3D-ABB2-6C96-7484DA16DCB1';
            $event = $this->eventService->getSingleEventWithUsers($eventUuid);
            $attendeeData = $this->attendeeService->getAttendeeInformationByEvent($event->event_users);
            die(var_dump($attendeeData));
            $data = [
                'name' => '',
                'email' => '',
                'status' => '',
            ];


            die(var_dump($event));
        } else {
            echo "Method not supported";
        }

    }


}