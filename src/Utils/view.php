<?php

namespace src\Utils;


class View
{
    public function __construct()
    {

    }

    public static function generate($name)
    {
        return __DIR__ . "/../../views/$name.php";
    }

}

?>