<?php
namespace src\Models;

class Event
{
    public $id;
    public $name;
    public $description;
    public $capacity;

    public function __construct($id, $name, $description, $capacity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->capacity = $capacity;
    }
}
?>
