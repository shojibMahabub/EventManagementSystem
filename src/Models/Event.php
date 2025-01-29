<?php
namespace src\Models;

class Event
{
    public $uuid;
    public $name;
    public $description;
    public $capacity;
    public $event_date_time;
    public $location;
    public $created_at;
    public $updated_at;
    public $spot_left;
    public $event_users = [];


    public function __construct($uuid, $name, $description, $capacity, $event_date_time, $location, $created_at, $updated_at, $spot_left)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->description = $description;
        $this->capacity = $capacity;
        $this->event_date_time = $event_date_time;
        $this->location = $location;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->spot_left = $spot_left;
    }

    public function addEventUser(EventUser $eventUser)
    {
        $this->event_users[] = $eventUser;
    }
}
