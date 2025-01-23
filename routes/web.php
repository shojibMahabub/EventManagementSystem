<?php
return [
    '/home' => ['EventController', 'index'],
    '/login' => ['AuthController', 'login'],
    '/logout' => ['AuthController', 'logout'],
    '/register' => ['AuthController', 'register'],
    '/events' => ['EventController', 'list'],
    '/events/add' => ['EventController', 'add'],
    '/events/details' => ['EventController', 'details'],
    '/events/edit' => ['EventController', 'edit'],
    '/events/update' => ['EventController', 'update'],
    '/events/delete' => ['EventController', 'delete'],
];
