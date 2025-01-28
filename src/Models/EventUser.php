<?php

namespace src\Models;

class EventUser
{
    public $uuid;
    public $event_uuid;
    public $user_uuid;
    public $event_status;

    public function __construct($uuid, $user_uuid, $event_uuid, $event_status)
    {
        $this->uuid = $uuid;
        $this->event_uuid = $event_uuid;
        $this->user_uuid = $user_uuid;
        $this->event_status = $event_status;
    }
}
