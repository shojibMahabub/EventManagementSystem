<?php
namespace src\Services;

use src\Repositories\AttendeeRepository;
use src\Utils\Uuid;

class AttendeeService
{
    private $attendeeRepository;

    public function __construct($db)
    {
        $this->attendeeRepository = new AttendeeRepository($db);
    }
}

