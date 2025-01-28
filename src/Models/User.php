<?php
namespace src\Models;

class User
{
    public $uuid;
    public $name;
    public $email;
    public $password;
    public $role;

    public function __construct($uuid, $name, $email, $password, $role)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
    }
}

?>
