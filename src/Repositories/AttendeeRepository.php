<?php
namespace src\Repositories;

use Exception;
use src\Models\Attendee;

class AttendeeRepository
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}
?>
