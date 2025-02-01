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
            $eventUuid = $_GET['uuid'] ?? '';
            if (empty($eventUuid)) {
                echo "Something went wrong !";
            }
            
            $event = $this->eventService->getSingleEventWithUsers($eventUuid);
            $exported_data = $this->attendeeService->getAttendeeInformationByEvent($event->event_users);

            $filename = $event->name."_attendees_" . date('Y-m-d_H-i-s') . ".csv";

            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');

            $output = fopen('php://output', 'w');

            fputcsv($output, ['Name', 'Email']);

            foreach ($exported_data as $attendee) {
                fputcsv($output, [$attendee['name'], $attendee['email']]);
            }

            fclose($output);
            exit;
        } else {
            echo "Method not supported";
        }
    }



}