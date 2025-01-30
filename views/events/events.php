<?php
include __DIR__ . '/../templates/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sort = $_GET['sort'] ?? 'date';
$order = $_GET['order'] ?? 'asc';

usort($events, function($a, $b) use ($sort, $order) {
    if ($sort === 'name') {
        return $order === 'asc' ? strcmp($a->name, $b->name) : strcmp($b->name, $a->name);
    } elseif ($sort === 'date') {
        return $order === 'asc' ? strtotime($a->event_date_time) - strtotime($b->event_date_time) : strtotime($b->event_date_time) - strtotime($a->event_date_time);
    } elseif ($sort === 'time') {
        return $order === 'asc' ? strtotime($a->event_date_time) - strtotime($b->event_date_time) : strtotime($b->event_date_time) - strtotime($a->event_date_time);
    } elseif ($sort === 'capacity') {
        return $order === 'asc' ? $a->capacity - $b->capacity : $b->capacity - $a->capacity;
    } elseif ($sort === 'spot_left') {
        return $order === 'asc' ? $a->spot_left - $b->spot_left : $b->spot_left - $a->spot_left;
    } elseif ($sort === 'location') {
        return $order === 'asc' ? strcmp($a->location, $b->location) : strcmp($b->location, $a->location);
    }
    return 0;
});
?>

<div class="container mt-5">
    <h2 class="text-center">Events</h2>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']->role !== 'attendee'): ?>
        <a href="/events/add" class="btn btn-light mb-3">Add Event</a>
    <?php endif; ?>

    <div class="d-flex justify-content-between mb-3">
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
        <form method="GET" class="form-inline">
            <input type="text" name="search" class="form-control" placeholder="Search event" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        </form>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    <a href="?sort=name&order=<?= $sort === 'name' && $order === 'asc' ? 'desc' : 'asc' ?>">
                        Name
                        <?php if ($sort === 'name'): ?>
                            <i class="fas fa-sort-<?= $order === 'asc' ? 'up' : 'down' ?>"></i>
                        <?php else: ?>
                            <i class="fas fa-sort"></i>
                        <?php endif; ?>
                    </a>
                </th>
                <th>
                
                    <a href="?sort=location&order=<?= $sort === 'location' && $order === 'asc' ? 'desc' : 'asc' ?>">
                            Location
                            <?php if ($sort === 'location'): ?>
                                <i class="fas fa-sort-<?= $order === 'asc' ? 'up' : 'down' ?>"></i>
                            <?php else: ?>
                                <i class="fas fa-sort"></i>
                            <?php endif; ?>
                    </a>
            
                </th>
                <th>
                    <a href="?sort=date&order=<?= $sort === 'date' && $order === 'asc' ? 'desc' : 'asc' ?>">
                        Date
                        <?php if ($sort === 'date'): ?>
                            <i class="fas fa-sort-<?= $order === 'asc' ? 'up' : 'down' ?>"></i>
                        <?php else: ?>
                            <i class="fas fa-sort"></i>
                        <?php endif; ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=time&order=<?= $sort === 'time' && $order === 'asc' ? 'desc' : 'asc' ?>">
                        Time
                        <?php if ($sort === 'time'): ?>
                            <i class="fas fa-sort-<?= $order === 'asc' ? 'up' : 'down' ?>"></i>
                        <?php else: ?>
                            <i class="fas fa-sort"></i>
                        <?php endif; ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=capacity&order=<?= $sort === 'capacity' && $order === 'asc' ? 'desc' : 'asc' ?>">
                        Capacity
                        <?php if ($sort === 'capacity'): ?>
                            <i class="fas fa-sort-<?= $order === 'asc' ? 'up' : 'down' ?>"></i>
                        <?php else: ?>
                            <i class="fas fa-sort"></i>
                        <?php endif; ?>
                    </a>
                </th>
                <th>
                    <a href="?sort=spot_left&order=<?= $sort === 'spot_left' && $order === 'asc' ? 'desc' : 'asc' ?>">
                        Spots Left
                        <?php if ($sort === 'spot_left'): ?>
                            <i class="fas fa-sort-<?= $order === 'asc' ? 'up' : 'down' ?>"></i>
                        <?php else: ?>
                            <i class="fas fa-sort"></i>
                        <?php endif; ?>
                    </a>
                </th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event->name); ?></td>
                    <td><?= htmlspecialchars($event->location); ?></td>
                    <td><?= date('F d, Y', strtotime($event->event_date_time)); ?></td>
                    <td><?= date('H:i', strtotime($event->event_date_time)); ?></td>
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
</div>