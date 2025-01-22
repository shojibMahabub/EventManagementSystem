<?php
return [
    '/api/events' => ['EventController', 'apiList'],
    '/api/events/details' => ['EventController', 'apiDetails'],
    '/api/login' => ['AuthController', 'apiLogin'],
];