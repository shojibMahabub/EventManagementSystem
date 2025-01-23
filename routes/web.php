<?php
return [
    '/home' => ['EventController', 'index'],
    '/login' => ['AuthController', 'login'],
    '/register' => ['AuthController', 'register'],
    '/events' => ['EventController', 'list'],
    '/events/add' => ['EventController', 'add'],
    '/events/details' => ['EventController', 'details'],
];
