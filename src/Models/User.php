<?php
namespace src\Models;

class User
{
    public $uuid;
    public $name;
    public $email;
    public $password;

    public function __construct($uuid, $name, $email, $password)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
}
?>
