<?php
return [
    '/api/events' => ['EventController', 'apiList'],
    '/api/event/details' => ['EventController', 'apiDetails'],
    '/api/login' => ['AuthController', 'apiLogin'],
];