<?php
class Config
{
    private static $instance = null;
    private $env = [];

    private function __construct()
    {
        $this->loadEnv();
    }

    public static function getInstance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function loadEnv()
    {
        $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue; // Skip comments
            }

            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            if (preg_match('/^".*"$/', $value) || preg_match('/^\'.*\'$/', $value)) {
                $value = substr($value, 1, -1); // Remove quotes
            }

            $this->env[$key] = $value;
        }
    }

    public function get(string $key, $default = null)
    {
        return $this->env[$key] ?? $default;
    }

    public function getDatabaseConnection(): mysqli
    {
        $host = $this->get('DB_HOST', 'localhost');
        $dbname = $this->get('DB_NAME', 'event_management');
        $username = $this->get('DB_USER', 'root');
        $password = $this->get('DB_PASS', '');

        $db = new mysqli($host, $username, $password, $dbname);

        if ($db->connect_error) {
            die('Database connection failed: ' . $db->connect_error);
        }

        return $db;
    }
}

// Autoload Classes
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});