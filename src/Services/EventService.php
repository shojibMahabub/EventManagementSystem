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
        if (empty($data['name']) || empty($data['description']) || empty($data['capacity'])) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }

        if (!is_numeric($data['capacity']) || $data['capacity'] <= 0) {
            return ['success' => false, 'message' => 'Capacity must be a positive number.'];
        }

        $result = $this->eventRepository->create($data);

        if ($result) {
            return ['success' => true, 'message' => 'Event created successfully.'];
        }

        return ['success' => false, 'message' => 'Failed to create the event.'];
    }

    public function getEventByUuid(string $uuid)
    {
        return $this->eventRepository->findByUuid($uuid);
    }
}
?>
