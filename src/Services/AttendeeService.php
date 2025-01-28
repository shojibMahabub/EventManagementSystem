<?php

namespace src\Services;

use src\Repositories\AttendeeRepository;

class AttendeeService
{
    private $attendeeRepository;

    public function __construct($db)
    {
        $this->attendeeRepository = new AttendeeRepository($db);
    }


    public function attachEventToAttendee(array $data)
    {

        $result = $this->attendeeRepository->checkForExistingEvent($data);

        if ($result) {
            return $this->attendeeRepository->updateEventAttendee($data);
        }

        return $this->attendeeRepository->attachEventAttendee($data);
    }
}

