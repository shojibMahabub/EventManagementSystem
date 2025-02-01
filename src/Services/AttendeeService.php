<?php

namespace src\Services;

use src\Repositories\AttendeeRepository;
use src\Repositories\UserRepository;

class AttendeeService
{
    private $attendeeRepository;
    private $userRepository;

    public function __construct($db)
    {
        $this->attendeeRepository = new AttendeeRepository($db);
        $this->userRepository = new UserRepository($db);
    }


    public function attachEventToAttendee(array $data)
    {

        $exitstingEvent = $this->attendeeRepository->checkForExistingEvent($data);

        if ($exitstingEvent) {
            return $this->attendeeRepository->updateEventAttendee($data);
        }

        return $this->attendeeRepository->attachEventAttendee($data);
    }

    public function getAttendeeInformationByEvent($attendee_list) {
        
        $user_uuids = [];
        $exported_data = [];

        foreach ($attendee_list as $attendee) {
            array_push($user_uuids, $attendee->user_uuid);
        }

        $attendee_list = $this->userRepository->findByUuid($user_uuids);

        foreach ($attendee_list as $attendee) {
            array_push($exported_data, [
                'name'  => $attendee->name,
                'email' => $attendee->email
            ]);
        }
        
        return $exported_data;


    }
}

