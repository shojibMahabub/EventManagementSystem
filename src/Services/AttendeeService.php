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

        $exitstingEvent = $this->attendeeRepository->checkForExistingEvent($data);

        if ($exitstingEvent) {
            return $this->attendeeRepository->updateEventAttendee($data);
        }

        return $this->attendeeRepository->attachEventAttendee($data);
    }
}

