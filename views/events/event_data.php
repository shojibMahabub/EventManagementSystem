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

                            <a
                                href="?sort=location&order=<?= $sort === 'location' && $order === 'asc' ? 'desc' : 'asc' ?>">
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
                            <a
                                href="?sort=capacity&order=<?= $sort === 'capacity' && $order === 'asc' ? 'desc' : 'asc' ?>">
                                Capacity
                                <?php if ($sort === 'capacity'): ?>
                                <i class="fas fa-sort-<?= $order === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php else: ?>
                                <i class="fas fa-sort"></i>
                                <?php endif; ?>
                            </a>
                        </th>
                        <th>
                            <a
                                href="?sort=spot_left&order=<?= $sort === 'spot_left' && $order === 'asc' ? 'desc' : 'asc' ?>">
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
                        <td><?= htmlspecialchars($event->name) ?></td>
                        <td><?= htmlspecialchars($event->location) ?></td>
                        <td><?= date('F d, Y', strtotime($event->event_date_time)) ?></td>
                        <td><?= date('H:i', strtotime($event->event_date_time)) ?></td>
                        <td><?= $event->capacity ?></td>
                        <td><?= $event->spot_left ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Event actions">
                                <a href="/event/details?uuid=<?= $event->uuid ?>" class="btn btn-light">Details</a>

                                <?php if (isset($_SESSION['user']) && $_SESSION['user']->role !== 'attendee'): ?>
                                <a href="/event/edit?uuid=<?= $event->uuid ?>" class="btn btn-light">Edit</a>
                                <a href="/event/delete?uuid=<?= $event->uuid ?>" class="btn btn-light">Delete</a>
                                <a href="/events/export?uuid=<?= $event->uuid ?>" class="btn btn-light">Export</a>
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
                                    <button id="btnGroupDrop_<?= $user_event->uuid ?>" type="button"
                                        class="btn btn-light dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <?= ucfirst(strtolower($button_label === 'NOTGOING' ? 'Not Going' : $button_label)) ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#"
                                            data-eventuuid="<?= htmlspecialchars($event->uuid) ?>"
                                            data-useruuid="<?= htmlspecialchars($session_user_uuid) ?>"
                                            data-status="GOING">
                                            Going
                                        </a>
                                        <a class="dropdown-item" href="#"
                                            data-eventuuid="<?= htmlspecialchars($event->uuid) ?>"
                                            data-useruuid="<?= htmlspecialchars($session_user_uuid) ?>"
                                            data-status="NOTGOING">
                                            Not going
                                        </a>
                                        <a class="dropdown-item" href="#"
                                            data-eventuuid="<?= htmlspecialchars($event->uuid) ?>"
                                            data-useruuid="<?= htmlspecialchars($session_user_uuid) ?>"
                                            data-status="INTERESTED">
                                            Interested
                                        </a>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-light dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?= ucfirst(strtolower($button_label === 'NOTGOING' ? 'Not Going' : $button_label)) ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#"
                                            data-eventuuid="<?= htmlspecialchars($event->uuid) ?>"
                                            data-useruuid="<?= htmlspecialchars($session_user_uuid) ?>"
                                            data-status="GOING">
                                            Going
                                        </a>
                                        <a class="dropdown-item" href="#"
                                            data-eventuuid="<?= htmlspecialchars($event->uuid) ?>"
                                            data-useruuid="<?= htmlspecialchars($session_user_uuid) ?>"
                                            data-status="NOTGOING">
                                            Not going
                                        </a>
                                        <a class="dropdown-item" href="#"
                                            data-eventuuid="<?= htmlspecialchars($event->uuid) ?>"
                                            data-useruuid="<?= htmlspecialchars($session_user_uuid) ?>"
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

<div class="d-flex justify-content-between mb-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-end">
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>">Previous</a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
                        </li>
                        <?php endfor; ?>

                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>