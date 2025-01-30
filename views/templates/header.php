<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="/assets/css/style.css">

    <title>Event Management System</title>
</head>
<body>


<div class="container-fluid">

    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/home">EMS</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/events">Events</a>
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="/logout">Logout</a>
                        </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link active" href="/login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="/register">Register</a>
                            </li>
                        <?php endif; ?>
                        </li>
                    </ul>
                </div>
                <div>
                <?php if (isset($_SESSION['user'])): ?>
                    <p>Welcome <strong><?=$_SESSION['user']->name?></strong></p>
                <?php endif; ?>
                </div>
            </div>
        </nav>


    </header>
