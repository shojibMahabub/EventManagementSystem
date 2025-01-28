<?php
include __DIR__ . '/../templates/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="container mt-5">
    <h2 class="text-center">Events</h2>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']->role != 'attendee'): ?>
        <a href="/events/add" class="btn btn-light mb-3">Add Event</a>
    <?php endif; ?>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Location</th>
            <th>Date Time</th>
            <th>Capacity</th>
            <th>Spot left</th>
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
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <a href="/events/details?uuid=<?= $event->uuid; ?>" class="btn btn-light" role="button"
                           aria-pressed="true">Details</a>

                        <?php if (isset($_SESSION['user']) && $_SESSION['user']->role != 'attendee'): ?>
                            <a href="/events/edit?uuid=<?= $event->uuid; ?>" class="btn btn-light" role="button"
                               aria-pressed="true">Edit</a>
                            <a href="/events/delete?uuid=<?= $event->uuid; ?>" class="btn btn-light" role="button"
                               aria-pressed="true">Delete</a>
                        <?php elseif (isset($_SESSION['user']) && $_SESSION['user']->role == 'attendee'): ?>
                            <div class="btn-group" role="group">

                                <button id="btnGroupDrop1" type="button" class="btn btn-light dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo ucfirst(strtolower($event->event_users[0]->event_status)) ?>
                                </button>

                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                    <a class="dropdown-item" href="#">Yes</a>
                                    <a class="dropdown-item" href="#">No</a>
                                    <a class="dropdown-item" href="#">Interested</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
