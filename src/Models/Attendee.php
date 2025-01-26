<?php
namespace src\Models;

class Attendee
{
    public $uuid;
    public $name;
    public $description;
    public $capacity;

    public function __construct($uuid, $name, $description, $capacity)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->description = $description;
        $this->capacity = $capacity;
    }
}
?>
