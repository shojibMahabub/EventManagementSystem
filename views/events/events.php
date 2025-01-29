<?php
include __DIR__ . '/../templates/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="container mt-5">
    <h2 class="text-center">Events</h2>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']->role !== 'attendee'): ?>
        <a href="/events/add" class="btn btn-light mb-3">Add Event</a>
    <?php endif; ?>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Date & Time</th>
            <th>Capacity</th>
            <th>Spots Left</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-end">
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>

        <?php foreach ($events as $event): ?>
            <tr>
                <td><?= htmlspecialchars($event->name); ?></td>
                <td><?= htmlspecialchars($event->location); ?></td>
                <td><?= htmlspecialchars($event->event_date_time); ?></td>
                <td><?= $event->capacity; ?></td>
                <td><?= $event->spot_left; ?></td>
                <td>
                    <div class="btn-group" role="group" aria-label="Event actions">
                        <a href="/events/details?uuid=<?= $event->uuid; ?>" class="btn btn-light">Details</a>

                        <?php if (isset($_SESSION['user']) && $_SESSION['user']->role !== 'attendee'): ?>
                            <a href="/events/edit?uuid=<?= $event->uuid; ?>" class="btn btn-light">Edit</a>
                            <a href="/events/delete?uuid=<?= $event->uuid; ?>" class="btn btn-light">Delete</a>
                        <?php elseif (isset($_SESSION['user']) && $_SESSION['user']->role === 'attendee'): ?>
                            <?php
                            $session_user_uuid = $_SESSION['user']->uuid ?? null;
                            $user_event = null;

                            // Find matching event user for the logged-in user
                            foreach ($event->event_users as $event_user) {
                                if ($event_user->user_uuid === $session_user_uuid) {
                                    $user_event = $event_user;
                                    break;
                                }
                            }
                            ?>

                            <?php if ($user_event): ?>
                                <?php $button_label = $user_event->event_status ?? 'Join'; ?>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop_<?= $user_event->uuid; ?>" type="button" class="btn btn-light dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= ucfirst(strtolower($button_label === 'NOTGOING' ? 'Not Going' : $button_label)); ?>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop_<?= $user_event->uuid; ?>">
                                        <a class="dropdown-item" href="?event_uuid=<?= $event->uuid; ?>&status=GOING&user_uuid=<?= $session_user_uuid; ?>">Going</a>
                                        <a class="dropdown-item" href="?event_uuid=<?= $event->uuid; ?>&status=NOTGOING&user_uuid=<?= $session_user_uuid; ?>">Not Going</a>
                                        <a class="dropdown-item" href="?event_uuid=<?= $event->uuid; ?>&status=INTERESTED&user_uuid=<?= $session_user_uuid; ?>">Interested</a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        Join
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="?event_uuid=<?= $event->uuid; ?>&status=GOING&user_uuid=<?= $session_user_uuid; ?>">Going</a>
                                        <a class="dropdown-item" href="?event_uuid=<?= $event->uuid; ?>&status=NOTGOING&user_uuid=<?= $session_user_uuid; ?>">Not Going</a>
                                        <a class="dropdown-item" href="?event_uuid=<?= $event->uuid; ?>&status=INTERESTED&user_uuid=<?= $session_user_uuid; ?>">Interested</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php include __DIR__ . '/../templates/footer.php'; ?>
