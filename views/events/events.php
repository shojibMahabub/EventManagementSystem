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

                            
                            foreach ($event->event_users as $event_user) {
                                if ($event_user->user_uuid === $session_user_uuid) {
                                    $user_event = $event_user;
                                    break;
                                }
                            }
                            ?>

                            <?php $button_label = $user_event->event_status ?? 'Join'; ?>
                            <?php if ($user_event): ?>
                                <div class="btn-group" role="group">
                                    <button id="btnGroupDrop_<?= $user_event->uuid; ?>" type="button"
                                            class="btn btn-light dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= ucfirst(strtolower($button_label === 'NOTGOING' ? 'Not Going' : $button_label)); ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#"
                                           data-eventuuid="<?= htmlspecialchars($event->uuid); ?>"
                                           data-useruuid="<?= htmlspecialchars($session_user_uuid); ?>"
                                           data-status="GOING">
                                            Going
                                        </a>
                                        <a class="dropdown-item" href="#"
                                           data-eventuuid="<?= htmlspecialchars($event->uuid); ?>"
                                           data-useruuid="<?= htmlspecialchars($session_user_uuid); ?>"
                                           data-status="NOTGOING">
                                            Not going
                                        </a>
                                        <a class="dropdown-item" href="#"
                                           data-eventuuid="<?= htmlspecialchars($event->uuid); ?>"
                                           data-useruuid="<?= htmlspecialchars($session_user_uuid); ?>"
                                           data-status="INTERESTED">
                                            Interested
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <?= ucfirst(strtolower($button_label === 'NOTGOING' ? 'Not Going' : $button_label)); ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#"
                                           data-eventuuid="<?= htmlspecialchars($event->uuid); ?>"
                                           data-useruuid="<?= htmlspecialchars($session_user_uuid); ?>"
                                           data-status="GOING">
                                            Going
                                        </a>
                                        <a class="dropdown-item" href="#"
                                           data-eventuuid="<?= htmlspecialchars($event->uuid); ?>"
                                           data-useruuid="<?= htmlspecialchars($session_user_uuid); ?>"
                                           data-status="NOTGOING">
                                            Not going
                                        </a>
                                        <a class="dropdown-item" href="#"
                                           data-eventuuid="<?= htmlspecialchars($event->uuid); ?>"
                                           data-useruuid="<?= htmlspecialchars($session_user_uuid); ?>"
                                           data-status="INTERESTED">
                                            Interested
                                        </a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.dropdown-item').on('click', function() {
                const status = $(this).data('status');
                const eventUuid = $(this).attr('data-eventuuid');
                const userUuid = $(this).attr('data-useruuid');
                const button = $(this).closest('.btn-group').find('button');

                if (!eventUuid || !userUuid) {
                    console.error('Missing event or user UUID');
                    return;
                }

                console.log('Event UUID:', eventUuid, 'User UUID:', userUuid, 'Status:', status);

                $.ajax({
                    url: '/update_attendee_event',
                    type: 'POST',
                    data: {
                        event_uuid: eventUuid,
                        user_uuid: userUuid,
                        status: status
                    },
                    success: function(response) {
                        button.text(ucfirst(status.toLowerCase()));
                    },
                    error: function(xhr) {
                        alert('Error updating status. Please try again.');
                    }
                });
            });

            function ucfirst(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        });

    </script>
