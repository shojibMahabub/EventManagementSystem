<?php


function parse_env($file)
{
    $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];

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

        $env[$key] = $value;
    }

    return $env;
}

$env = parse_env(__DIR__ . '/.env');

$host = $env['DB_HOST'] ?? 'localhost';
$dbname = $env['DB_NAME'] ?? 'event_management';
$username = $env['DB_USER'] ?? 'root';
$password = $env['DB_PASS'] ?? '';

$db = new mysqli($host, $username, $password, $dbname);

if ($db->connect_error) {
    die('Database connection failed: ' . $db->connect_error);
}

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/src/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});