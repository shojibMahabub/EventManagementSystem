<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/styles.css">
    <title>Event Management System</title>
</head>
<body>
    <header>
        <nav>
            <a href="/">Home</a>
            <a href="/events">Events</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/logout">Logout</a>
            <?php else: ?>
                <a href="/login">Login</a>
                <a href="/register">Register</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
