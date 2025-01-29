<?php

namespace src\Services;

use src\Repositories\EventRepository;

class EventService
{
    private $eventRepository;

    public function __construct($db)
    {
        $this->eventRepository = new EventRepository($db);
    }

    public function getAllEvents(): array
    {
        return $this->eventRepository->getAll();
    }

    public function createEvent(array $data): array
    {
        $validationResult = $this->validateEventData($data);
        if (!$validationResult['success']) {
            return $validationResult;
        }

        $result = $this->eventRepository->create($data);

        if ($result) {
            return ['success' => true, 'message' => 'Event created successfully.'];
        }

        return ['success' => false, 'message' => 'Failed to create the event.'];
    }

    private function validateEventData(array $data): array
    {
        if (empty($data['name']) || $data['name'] === '') {
            return ['success' => false, 'message' => 'Name is required.'];
        }

        if (empty($data['description']) || $data['description'] === '') {
            return ['success' => false, 'message' => 'Description is required.'];
        }

        if (empty($data['capacity']) || $data['capacity'] === '') {
            return ['success' => false, 'message' => 'Capacity is required.'];
        }

        if (empty($data['location']) || $data['location'] === '') {
            return ['success' => false, 'message' => 'Location is required.'];
        }

        if (empty($data['datetime']) || $data['datetime'] === '') {
            return ['success' => false, 'message' => 'Datetime is required.'];
        }

        if (!is_numeric($data['capacity']) || $data['capacity'] <= 0) {
            return ['success' => false, 'message' => 'Capacity must be a positive number.'];
        }

        return ['success' => true];
    }


    public function updateEvent(array $data): array
    {
        $validationResult = $this->validateEventData($data);
        if (!$validationResult['success']) {
            return $validationResult;
        }

        $result = $this->eventRepository->update($data);

        if ($result) {
            return ['success' => true, 'message' => 'Event updated successfully.'];
        }

        return ['success' => false, 'message' => $result];
    }

    public function getEventByUuid(string $uuid)
    {
        return $this->eventRepository->findByUuid($uuid);
    }

    public function deleteEventByUuid(string $uuid)
    {
        return $this->eventRepository->deleteByUuid($uuid);
    }


    public function getAllEventsWithUsers()
    {
        return $this->eventRepository->getAllEventsWithUsers();
    }

    public function getSingleEventWithUsers ($eventUuid) {
        return $this->eventRepository->getSingleEventWithUsers($eventUuid);
    }
}

