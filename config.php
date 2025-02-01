<?php

class Config
{
    private static $instance = null;
    private $env = [];

    private function __construct()
    {
        $this->loadEnv();
    }

    private function loadEnv()
    {
        $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if (preg_match('/^".*"$/', $value) || preg_match('/^\'.*\'$/', $value)) {
                $value = substr($value, 1, -1);
            }

            $this->env[$key] = $value;
        }
    }

    public static function getInstance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getDatabaseConnection(): mysqli
    {
        $host = $this->get('DB_HOST', 'db');
        $dbname = $this->get('DB_NAME', 'eventdb');
        $username = $this->get('DB_USER', 'root');
        $password = $this->get('DB_PASS', 'root');

        try {
            return new mysqli($host, $username, $password, $dbname);
        } catch (Exception $e) {
            echo "Database : " . $e->getMessage();
        }
    }

    public function get(string $key, $default = null)
    {
        return $this->env[$key] ?? $default;
    }
}

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});