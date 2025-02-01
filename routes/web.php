<?php
return [
    '/' => ['EventController', 'listEvents'],
    
    '/login' => ['AuthController', 'login'],
    '/logout' => ['AuthController', 'logout'],
    '/register' => ['AuthController', 'register'],
    
    '/events' => ['EventController', 'listEvents'],
    '/event/add' => ['EventController', 'addEvent'],
    '/event/details' => ['EventController', 'eventDetails'],
    '/event/edit' => ['EventController', 'editEvent'],
    '/event/update' => ['EventController', 'updateEvent'],
    '/event/delete' => ['EventController', 'deleteEvent'],
    
    '/update_attendee_event' => ['AttendeeController', 'attachEvent'],
    '/export_attendee_data' => ['AttendeeController', 'exportAttendeeData'],
];
