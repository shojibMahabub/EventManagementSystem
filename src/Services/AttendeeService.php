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
        
        $data = [];
        
        foreach ($attendee_list as $attendee) {
            array_push($data, $attendee->user_uuid);
        }
        $attendee_list = $this->userRepository->findByUuid($data);



        foreach ($attendee_list as $attendee) {
            array_push($data, [
                'name'  => $attendee->name,
                'email' => $attendee->email
            ]);
        }
        

        return ['name' => $attendee_list->name, 'email' => $attendee_list->email];


    }
}

